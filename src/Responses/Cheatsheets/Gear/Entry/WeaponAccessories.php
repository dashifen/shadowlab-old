<?php

namespace Shadowlab\Responses\Cheatsheets\Gear\Entry;

use Shadowlab\Interfaces\Response\AbstractResponse;

class WeaponAccessories extends AbstractResponse
{
    protected function handleBlank() {
        $form_data = $this->getFormData();
        $form_data["title"] = "Enter Weapon Accessory";
        $this->setView('Cheatsheets\Gear\Entry\WeaponAccessories', $form_data);
    }

    protected function handleError($message = "Unknown error encountered") {
        $exception = $this->payload->getPayload("exception");

        $form_data = $this->getFormData();
        $form_data = array_merge($form_data, [
            "message" => $exception->getMessage(),
            "title"   => "Database Error",
        ]);

        $this->setView('Cheatsheets\Gear\Entry\WeaponAccessories', $form_data);
    }

    protected function handleNotValid($title = null)
    {
        if ($title == null) {
            $title = "Unable to Save Weapon Accessory";
        }

        $form_data = $this->getFormData();
        $form_data = array_merge($form_data, [
            "errors" => $this->payload->getPayload("errors"),
            "error"  => $this->payload->getPayload("error"),
            "title"  => $title,
        ]);

        $this->setView('Cheatsheets\Gear\Entry\WeaponAccessories', $form_data);
    }

    protected function handleNotCreated() {
        $this->handleNotValid("Unable to Save Weapon Accessory in Database");
    }

    protected function handleCreated() {
        $values = $this->payload->getPayload("values");
        $this->setView('Cheatsheets\Gear\Entry\WeaponAccessories', [
            "gear_id"   => $this->payload->getPayload("gear_id"),
            "accessory" => $values["gear"],
            "book_id"   => $values["book_id"],
            "page"      => $values["page"],
            "title"     => "Weapon Saved",
        ]);
    }

    protected function getFormData() {
        return [
            "categories" => $this->payload->getPayload("categories"),
            "attributes" => $this->payload->getPayload("attributes"),
            "accessory"  => $this->payload->getPayload("accessory"),
            "values"     => $this->payload->getPayload("values"),
            "mounts"     => $this->payload->getPayload("mounts"),
            "books"      => $this->payload->getPayload("books"),
        ];
    }
}
