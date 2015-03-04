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
        if ($this->isDev() || ($authentic = $this->session->isAuthenticated())) {

            // if this is the development machine or if the visitor is already authentic, then we want to
            // redirect away from this page.  and, if we're not authentic, within this block, then we'll auto-
            // authenticate dash since he must be working on the development machine at the moment.

            if (!$authentic) $this->session->login('dashifen', 'superuser');
            $this->http->redirect("/cheatsheets");

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
        return $server_name == 'localhost' || strpos($server_name, '192.168.1.') !== false;
    }
}
