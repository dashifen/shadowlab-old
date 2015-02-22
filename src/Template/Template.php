<?php

namespace Shadowlab\Template;

use Shadowlab\Exceptions\TemplateException;
use Shadowlab\Interfaces\Template\AbstractTemplate;

/**
 * Class Template
 * This class converts templates which include variables in the form of {$variable} or actions like
 * {foreach $scripts}<script type='text/javascript' src='{$scr}'></script>{foreach} into strings lacking
 * those structures.  Sure, I could have used something like Smarty to do this sort of thing but, frankly,
 * I always wanted to try and build something like this myself.
 * @package Shadowlab\Template
 */
class Template extends AbstractTemplate
{
    public function apply($content = '', array $data = [])
    {
        // this function may be called from within some of the protected methods below to allow for
        // a template string within the content of another template string.  when that happens, the
        // arguments will not be their defaults and we want to use them.  but, when the arguments
        // are defaulted to empty values, we'll want to use the content and data properties to apply
        // our template to the contents of $this->file;

        if (sizeof($data)==0) $data = $this->data;
        if (empty($content)) $content = $this->content;

        // to apply our template we take the following steps.  first, we remove whitespace to make
        // the pattern matching much, much more simple and, beneficially, reduce the size of the
        // content we send back to the client.  then, we replace any variables not used as a part
        // of a template action.  finally, we handle all of our template actions.  throughout, the
        // $content variable is manipulated and returned here.  we can't use the property because
        // we want to be sure that we leave that alone in case we ever need it again later.

        $content = $this->removeWhitespace($content);
        $content = $this->replaceVariables($content, $data);
        $content = $this->handleActions($content, $data);
        return $content;
    }

    protected function removeWhitespace($content)
    {
        // the first regular expression changes any whitespace character or repeated series of whitespace
        // characters into a single space.  then, the second converts any spaces between either HTML tags
        // or our template entities

        $content = preg_replace('/\s\s*/', ' ', $content);
        $content = preg_replace('/(?<=>|}) (?=<|{)/', '', $content);
        return $content;
    }

    protected function replaceVariables($content, array $data)
    {
        // our individual variables are in the form of {$variable}.  our template actions are also
        // surrounded by curly braces but they won't begin with '{$' so we can replace our variables with
        // their corresponding $data index as follows.  within the callback function below, the $matches
        // array has two indices the first of which is the matched string within $content and the second is
        // the name of the variable we'll replace.  if that name is in $data, we'll replace the variable
        // with that value.

        $callback = function(array $matches) use ($data) {
            return isset($data[$matches[1]]) ? $data[$matches[1]] : $matches[0];
        };

        $content = preg_replace_callback('/{\$(\w+)}/', $callback, $content);
        return $content;
    }

    protected function handleActions($content, array $data)
    {
        // to handle the actions buried within our template we first need to identify them.  because we've
        // already handled our variables, the only remaining braces should be our actions.  we use the
        // following pattern makes two matches:  the action to perform and an index within $data.

        $matches = preg_match_all('/{(?:(foreach|if) )?\$(\w+)}/', $content, $actions);
        if ($matches != false) {

            // the $actions array has three indices.  the zeroth are the strings matched by the pattern; we
            // don't care much about those here.  the first is the optional action to be performed; when empty
            // we can continue onto the next match.  the second index has the name of the template variable
            // involved in the matched action.

            for ($i = 0; $i < $matches; $i++) {
                if (empty($action = $actions[1][$i])) continue;

                switch ($action) {
                    case "foreach":
                        $content = $this->handleForeach($content, $data, $actions[2][$i]);
                        break;

                    case "if":
                        $content = $this->handleIf($content, $data, $actions[2][$i]);
                        break;

                    default:
                        throw new TemplateException("Unexpected action: {$action}");
                }
            }
        }

        return $content;
    }

    protected function handleForeach($content, array $data, $variable)
    {
        // foreach statements use $variable within $data to loop over a section of content adding that
        // content over and over again to our final content.  for example, table rows can be stamped out
        // based on a template using such a technique.  first, the $variable index within $data has to
        // be an array.

        if (!isset($data[$variable]) || !is_array($data[$variable])) {
            throw new TemplateException('Foreach requires array for $data['.$variable.']');
        }

        // now, we need to identify the part of $content that we're going to use during our iteration
        // to stamp out the replacement for this action.  we use another regular expression as follows.
        // notice that this one includes the name of our $variable to ensure that we don't match the
        // wrong foreach block.

        $pattern = sprintf('/{foreach \$%s}(.*){endforeach}/', $variable);
        $matched = preg_match_all($pattern, $content, $matches);

        if ($matched === false) {
            throw new TemplateException("Unable to identify foreach content for {$variable}");
        }

        if ($matched) {
            $search  = $matches[0][0];      // the string that we searched for and matched.
            $replace = $matches[1][0];      // the sub-string within $content to reproduce.

            // now, for each of the indices within $data we want to treat $replace as if it's content
            // for a Template.  we can easily do so by calling the $this->apply() method passing it the
            // $replace string and the $datum array as follows.  we simply concatenate all of the
            // resulting strings together and then cram them into $content instead of the $search
            // string.

            $replacement = '';
            foreach ($data[$variable] as $datum) {
                $replacement .= $this->apply($replace, $datum);
            }

            $content = str_replace($search, $replacement, $content);
        }

        return $content;
    }

    protected function handleIf($content, $data, $variable)
    {
        // ifs are a little easier to handle than foreach loops above.  for these actions, the $variable
        // specified within $data must simply evaluate to true and, if so, the body of our if-statement in
        // the template is added back onto $content.  otherwise, it's removed.  in this way, we can
        // conditionally add information to a page.  we want to make sure that our $variable within $data
        // is explicitly a boolean just to avoid truth-y values causing side effects.

        if (!isset($data[$variable]) || !is_bool($data[$variable])) {
            throw new TemplateException('If requires bool for $data['.$variable.']');
        }

        $pattern = sprintf('/{if \$%s}(.*){endif}/', $variable);
        $matched = preg_match_all($pattern, $content, $matches);

        if ($matched === false) {
            throw new TemplateException("Unable to identify if content for {$variable}");
        }

        // if we didn't match, then to remove our if-block from the template we'll replace it with an
        // empty string.  but, if we did match, then we'll evaluation $data[$variable] and include the
        // matched content as if it were a Template by calling the apply() method on it.

        $replacement = $matched && $data[$variable]
            ? $this->apply($matches[1][0], $data)
            : '';

        $content = str_replace($matches[0][0], $replacement, $content);
        return $content;
    }
}
