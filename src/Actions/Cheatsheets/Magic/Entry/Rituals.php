<?php

namespace Shadowlab\Actions\Cheatsheets\Magic\Entry;

use Shadowlab\Interfaces\Action\AbstractAction;

class Rituals extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Magic\Rituals\Rituals
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Magic\Entry\Rituals
     */
    protected $http;

    public function execute()
    {
        $isPost = $this->request->post->get("isPost");

        if (!$isPost) {

            // if no data has been posted here, then we can set up a blank payload and show
            // the empty form.

            $blank = $this->domain->getPayload("blank");
            $form_data = $this->domain->getFormData();

            $form_data = array_merge($form_data, [ "values" => [
               "book_id" => $this->request->query->get("book_id"),
                "page"   => $this->request->query->get("page"),
            ]]);


            $blank->setPayload($form_data);
            $this->http->setPayload($blank);
        } else {
            $post = $this->request->post->get();
            $payload = $this->domain->addRitual($post);

            // $payload is of various types, but as long as it's not an inserted payload, then
            // we will have to re-show the form.  doing so means we want to merge the payload's
            // data with the data the form needs before sending it all over to our response.

            if ($payload->getType() != "created") {
                $payload_data = $payload->getPayload();
                $form_data = $this->domain->getFormData();
                $data = array_merge($payload_data, $form_data);
                $payload->setPayload($data);
            }

            $this->http->setPayload($payload);
        }

        return $this->http->execute();
    }
}
