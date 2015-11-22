<?php

namespace Shadowlab\Domains\Cheatsheets\Gear;

use Shadowlab\Interfaces\Domain\AbstractFilter;

abstract class GearFilter extends AbstractFilter
{
    public function filterInsert()
    {
        $properties = GearEntity::getProperties();

        foreach ($properties as $property) {
            $value = $this->entity->get($property);

            switch ($property) {
                case "gear":
                    if (empty($value)) {
                        $this->errors[$property] = "Please enter a name.";
                    }

                    break;

                case "gear_category_id":
                    if (empty($value) || !is_numeric($value)) {
                        $this->errors[$property] = "Please select a category.";
                    } else {
                        $categories = $this->domain->getGearCategories();

                        // $categories is list of arrays.  we'll use array walk to convert those arrays
                        // into a single list of gear category IDs and then we can see if $value is within
                        // them.

                        array_walk($categories, function(&$x) { $x = $x["gear_category_id"]; });

                        if (array_search($value, $categories) === false) {
                            $this->errors[$property] = "Invalid category; choose another.";
                        }
                    }

                    break;

                case "availability":
                    if (empty($value) && $value != 0) {
                        $this->errors[$property] = "Please enter an availability.";
                    }

                    break;

                case "legality":
                    if (!empty($value) && $value != "R" && $value != "F") {
                        $this->errors[$property] = "Invalid legality; choose another.";
                    }

                    break;

                case "cost":
                    if (empty($value)) {
                        $this->errors[$property] = "Please enter a cost.";
                    }

                    break;

                case "book_id":
                    if (empty($value) || !is_numeric($value)) {
                        $this->errors[$property] = "Please select a book.";
                    } else {
                        $books = $this->domain->getBooks();
                        if (array_search($value, array_keys($books)) === false) {
                            $this->errors[$property] = "Invalid book; select another.";
                        }
                    }

                    break;

                case "page":
                    if (empty($value) || !is_numeric($value)) {
                        $this->errors[$property] = "Please enter a page.";
                    }

                    break;
            }

        }

        return $this->errors;
    }

    public function filterSelect()
    {
    }

    public function filterUpdate()
    {
    }

    public function filterDelete()
    {
    }
}