<?php

namespace Shadowlab\Actions\User;

use Shadowlab\Interfaces\Action\AbstractAction;

class AuthenticateAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\User\User
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\User\Login
     */
    protected $http;

    public function execute()
    {
        $retval = null;
        $username = $this->request->post->get("username");
        $password = $this->request->post->get("password");
        $payload  = $this->domain->authenticate($username, $password);

        $type = $payload->getType();
        if ($type != "Found") $this->http->setPayload($payload);

        // in addition to our other work, this action has to tell our response about some additional
        // details as follows.  we don't rely on a method of the domain to send back the $username from
        // our request because we don't want to include the password.  plus, the information about the
        // attempts comes out of the Session which we have access to but the response doesn't.

        switch ($type) {
            case 'NotFound':
                $this->http->setData([
                    'username' => $username,
                    'attempts' => $this->getLoginAttempts(),
                    'heading'  => 'Login Failed'
                ]);

                break;

            // if we found our account, then we also want to set up the authenticated Session.  luckily,
            // that's super easy as follows.  then, if we have a location to which we wish to return to
            // we'll go there; otherwise, we go to the cheatsheets index.

            case 'Found':
                $this->session->login($username);

                $location = "/cheatsheets";
                if ($this->session->exists('AFTER_LOGIN_RETURN_TO')) {
                    $location = $this->session->get('AFTER_LOGIN_RETURN_TO');
                    $this->session->remove('AFTER_LOGIN_RETURN_TO');
                }

                $this->http->redirect($location);
                break;
        }

        return $this->http->execute();
    }

    protected function getLoginAttempts()
    {
        // it's possible that this operation should move over to the Session object itself.  however, this
        // is the only place that the application needs to do this sort of thing so, for the moment, we'll
        // leave it here.  we get the previous count of login attempts or zero if this is the first one.
        // then, we increment that number and set it in the Session.

        $attempts = $this->session->exists('LOGIN_ATTEMPTS')
            ? $this->session->get('LOGIN_ATTEMPTS')
            : 0;

        $this->session->set('LOGIN_ATTEMPTS', ++$attempts);
        return $attempts;
    }
}
