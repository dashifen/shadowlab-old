<?php

namespace Shadowlab\Responses\Cheatsheets\Gear\Entry;

use Shadowlab\Interfaces\Response\AbstractResponse;

class Weapons extends AbstractResponse
{
    protected function handleBlank() {
        $form_data = $this->getFormData();
        $form_data["title"] = "Enter Weapon";
        $this->setView('Cheatsheets\Gear\Entry\Weapons', $form_data);
    }

    protected function handleError($message = "Unknown error encountered") {
        $exception = $this->payload->getPayload("exception");

        $form_data = $this->getFormData();
        $form_data = array_merge($form_data, [
            "message" => $exception->getMessage(),
            "title"   => "Database Error",
        ]);

        $this->setView('Cheatsheets\Gear\Entry\Weapons', $form_data);
    }

    protected function handleNotValid($title = null)
    {
        if ($title == null) {
            $title = "Unable to Save Weapons";
        }

        $form_data = $this->getFormData();
        $form_data = array_merge($form_data, [
            "errors" => $this->payload->getPayload("errors"),
            "error"  => $this->payload->getPayload("error"),
            "title"  => $title,
        ]);

        $this->setView('Cheatsheets\Gear\Entry\Weapons', $form_data);
    }

    protected function handleNotCreated() {
        $this->handleNotValid("Unable to Save Weapons in Database");
    }

    protected function handleCreated() {
        $values = $this->payload->getPayload("values");
        $this->setView('Cheatsheets\Gear\Entry\Weapons', [
            "gear_id" => $this->payload->getPayload("gear_id"),
            "weapon"  => $values["gear"],
            "book_id" => $values["book_id"],
            "page"    => $values["page"],
            "title"   => "Weapon Saved",
        ]);
    }

    protected function getFormData() {
        return [
            "categories" => $this->payload->getPayload("categories"),
            "attributes" => $this->payload->getPayload("attributes"),
            "weapon"     => $this->payload->getPayload("weapon"),
            "values"     => $this->payload->getPayload("values"),
            "books"      => $this->payload->getPayload("books"),
        ];
    }
}
