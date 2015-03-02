<?php

namespace Shadowlab\Actions\User;

use Shadowlab\Interfaces\Action\AbstractAction;

class LoginAction extends AbstractAction
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
        if ($this->isDev()) {

            // if this is the development machine, then we'll log dashifen in as a superuser.  then,
            // we can redirect to the cheat sheet index page.  that's the same page that he and others
            // are taken to

            //$this->session->login('dashifen', 'superuser');
            //$this->http->redirect("/cheatsheets");

        } else {

            // otherwise, we just load up a blank payload and send that back to the client.  the Response
            // can take over from there.

            $this->http->setData([ 'attempts' => $this->session->get('LOGIN_ATTEMPTS', 0) ]);
            $blank_payload = $this->domain->getPayload("blank");
            $this->http->setPayload($blank_payload);
        }

        return $this->http->execute();
    }

    protected function isDev()
    {
        $server_name = $this->request->server->get('SERVER_NAME');
        return $server_name == 'localhost';
    }
}
