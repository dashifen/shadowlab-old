<?php

namespace Shadowlab\View;

use Aura\View\View as AuraView;

/*
 * this object adds some protected methods to the Aura\View\View object that are useful for the display
 * of pages (mostly forms) within the ShadowLab.  no public methods are added to the object, so its
 * interface remains the same and we can use these methods within our views because the content of a
 * view gains access to the internals of the Aura\View\View object.
 */

class View extends AuraView
{
    const OPTIONAL = false;
    const REQUIRED = true;

    /**
     * @param string $for
     * @param bool $required
     * @param string $display
     * @param bool $colon
     * @param array $scope
     * @return string
     */
    protected function printLabel($for, $required = false, $display = "", $colon = true, array $scope = null)
    {
        // this method uses the arguments to print a <label> in a structured way that helps display
        // the information a visitor needs to know about on-screen.  if a $scope is not specified,
        // we use the $this->errors variable, if available, or an empty array if it's not.  then,
        // we can see if we have an error in that $scope and determine our display either by using
        // the $display argument or by altering $for to create a more readable display.

        if ($scope == null) {
            $scope = isset($this->errors) && is_array($this->errors) ? $this->errors : [];
        }

        $error = isset($scope[$for]) && $scope[$for] !== false ? $scope[$for] : false;
        $display = strlen($display) > 0 ? $display : ucwords(str_replace("_", " ", $for));

        // the class for our label is a series of terms based on our arguments and on the existence
        // of an error related to this label's field.  we create an array of class names and then
        // join them for use in the HTML below.  then, we're ready to build our HTML.

        if (!$colon) $class[] = "no-colon";
        if ($error !== false) $class[] = "error";
        $class[] = $required ? "required" : "optional";

        $label = sprintf('<label for="%s" class="%s">', $for, join(" ", $class));
        $label .= "<span>" . $display . "</span>";

        if ($required) $label .= '<i class="fa fa-fw fa-star"><span>required</span></i>';
        if ($error !== false) $label .= "<strong>" . $error . "</strong>";

        $label .= "</label>";

        return $label;
    }

    /**
     * @param string $value
     * @param string $default
     * @return string
     */
    protected function getValue($value, $default="", $index=null)
    {
        if (!isset($this->values) || !is_array($this->values) || !isset($this->values[$value])) {
            return $default;
        }

        // if $index is null (as it usually is) then we are looking for a scalar value.  if it's not null,
        // then we expect that $value is an array and we want to return the value of $index within it.

        if($index === null) return $this->values[$value];
        else return is_array($this->values[$value]) && isset($this->values[$value][$index])
            ? $this->values[$value][$index]
            : $default;
    }
}

