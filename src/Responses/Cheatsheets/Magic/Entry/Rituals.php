<?php

namespace Shadowlab\Responses\Cheatsheets\Magic\Entry;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Rituals extends AbstractResponse
{
    protected function handleBlank() {
        $form_data = $this->getFormData();
        $form_data["title"] = "Enter Ritual";
        $this->setView('Cheatsheets\Magic\Entry\Rituals', $form_data);
    }

    protected function handleError($message = "Unknown error encountered") {
        $exception = $this->payload->getPayload("exception");

        $form_data = $this->getFormData();
        $form_data = array_merge($form_data, [
            "message" => $exception->getMessage(),
            "title"   => "Database Error",
        ]);

        $this->setView('Cheatsheets\Magic\Entry\Rituals', $form_data);
    }

    protected function handleNotValid($title = null)
    {
        if ($title == null) {
            $title = "Unable to Save Ritual";
        }

        $form_data = $this->getFormData();
        $form_data = array_merge($form_data, [
            "errors" => $this->payload->getPayload("errors"),
            "title"  => $title,
        ]);

        $this->setView('Cheatsheets\Magic\Entry\Rituals', $form_data);
    }

    protected function handleNotCreated() {
        $this->handleNotValid("Unable to Save Ritual in Database");
    }

    protected function handleCreated() {
        $values = $this->payload->getPayload("values");
        $this->setView('Cheatsheets\Magic\Entry\Rituals', [
            "ritual_id" => $this->payload->getPayload("ritual_id"),
            "ritual"    => $values["ritual"],
            "book_id"   => $values["book_id"],
            "page"      => $values["page"],
            "title"     => "Ritual Saved",
        ]);
    }

    protected function getFormData() {
        return [
            "ritual_tags"    => $this->payload->getPayload("ritual_tags"),
            "ritual_lengths" => $this->payload->getPayload("ritual_lengths"),
            "metamagics"     => $this->payload->getPayload("metamagics"),
            "schools"        => $this->payload->getPayload("schools"),
            "ritual"         => $this->payload->getPayload("ritual"),
            "rituals"        => $this->payload->getPayload("rituals"),
            "books"          => $this->payload->getPayload("books"),
            "values"         => $this->payload->getPayload("values"),
        ];
    }
}
