<?php

namespace Shadowlab\Interfaces\Response;

use Aura\Web\Request;
use Aura\Web\Response as WebResponse;
use Shadowlab\Exceptions\DatabaseException;
use Shadowlab\Exceptions\ResponsePropertyNotFoundException;
use Shadowlab\Interfaces\Domain\Payload;
use Shadowlab\View\View;

/**
 * Class AbstractResponse
 * @package Shadowlab\Interfaces\Response
 */
abstract class AbstractResponse implements Response
{
    /**
     * @var View
     */
    protected $view;

    /**
     * @var WebResponse
     */
    protected $response;

    /**
     * @var Payload
     */
    protected $payload = null;

    /**
     * @var array
     */
    protected $data;

    /**
     * @param View $view
     * @param WebResponse $response
     */
    public function __construct(View $view, WebResponse $response)
    {
        $this->view = $view;
        $this->response = $response;

        // here we just want to set a bit of our default data.  there's not much to mess with
        // at this time, but to be sure that our heading matches our title, we'll simply be sure
        // that it's blank to begin with.

        $this->data = [
            'title'   => '',
            'heading' => '',
            'errors'  => [],
            'values'  => []
        ];
    }

    /**
     * @param $property
     * @return View|WebResponse|Payload
     * @throws ResponsePropertyNotFoundException
     */
    public function __get($property)
    {
        // in order to provide read-only access to some of our protected properties, we've implemented
        // the __get() magic method.  we list the properties that we're allowed to read in the array
        // below and then, as long as $property, is one of them, then we will return it.

        $magic_properties = array("view", "response", "payload");
        if (array_search($property, $magic_properties) !== false) return $this->{$property};
        throw new ResponsePropertyNotFoundException($this, $property);
    }

    /**
     * @param Payload $payload
     */
    public function setPayload(Payload $payload)
    {
        $this->payload = $payload;
    }

    public function setView($view, array $data = [])
    {
        $this->view->setView($view);
        $this->setData($data);
    }

    public function setData(array $data = [])
    {
        $this->data = array_merge($this->data, $data);
    }

    /**
     * @param $url
     */
    public function redirect($url)
    {

        $this->response->redirect->to($url);
    }

    /**
     * @return $this
     */
    public function execute()
    {
        $status = $this->response->status->getCode();
        if ($status != 302) {

            // status 302 is a redirection, and if we're redirecting, then we don't want to mess with a
            // view payload which is what's happening here in this if-block.  so, we only perform these
            // actions if we're not redirecting.  most of the time, we should already have a payload here.
            // but, if we don't, then we'll call this one an error.

            if ($this->payload == null) $this->handleError();
            else {

                // otherwise, we'll get our type of payload and prefix it with "handle" to create method
                // names like handleNotFound() handleValid().  then, as long as that method exists, we
                // call it.  if it doesn't, we'll tell the client about our unknown/unexpected payload.

                $method = "handle" . $this->payload->getType();
                if(method_exists($this, $method)) $this->$method();
                else $this->handleUnknown();
            }
        }

        return $this;
    }

    /**
     *
     */
    public function handle404()
    {
        $this->response->status->set(404);
        $this->data["message_type"] = "error404";
        $this->data["title"] = "Huh?";
        $this->view->setView("Blank");

        $content = <<<EOC
            <p><strong>File Not Found</strong>:<br><em>A Haiku from the Internet to You</em></p>
            <p>You step in the stream,<br>But the water has moved on.<br>This page is not here.</p>
EOC;

        $this->data["message"] = $content;
    }

    public function unauthorized()
    {
        $this->redirect("/");
    }

    /**
     * @param string $message
     */
    protected function handleError($message = "Unknown error encountered")
    {
        $this->response->status->set(500);
        $this->data["title"] = "Uhm... Crap.";
        $this->data["message_type"] = "error";
        $this->view->setView("Blank");

        // most of the time, our payload will have an exception within it when an error has occurred.  but,
        // there are some cases where this won't have happened.  in those cases, we'll end up using the $message
        // argument instead.  here, we'll see if we have an exception in our payload and, if so, we'll use it.

        if ($this->payload != null) {
            $e = $this->payload->getPayload('exception');
            if ($e instanceof \Exception) {
                $message = $e->getMessage();
            }
            if ($e instanceof DatabaseException) {
                $format = '<br><strong>%s:</strong> %s';
                $message .= sprintf($format, "Query", $e->getQuery());
            }
        }

        $this->data["message"] = $message;
    }

    protected function handleUnknown()
    {
        // our unknown payload error is really just a very specific type of an error.  therefore, we can
        // just pass a carefully crafted error message over to the error method.

        $this->handleError("Unexpected payload (" . get_class($this->payload) . ") in " . get_class($this));
    }

    /**
     * @param bool
     */
    public function send()
    {
        // like with the execute above, we have to be careful here to avoid trying to render a display if
        // we're redirecting.  this is one of those cases where the HTTP headers are more important than the
        // body content.

        $status = $this->response->status->getCode();
        if($status != 302) $this->render();

        // to send our response to the client, we start with our status code.

        header($this->response->status->get(), true, $this->response->status->getCode());

        // now, we need to send headers and any cookies that we might be making.  we can get those data
        // from our response property and then iterate through them to send that information back to the
        // client.

        $headers = $this->response->headers->get();
        $cookies = $this->response->cookies->get();
        foreach ($headers as $label => $value) header("{$label}: {$value}");

        // TODO: test a cookie!

        foreach ($cookies as $name => $cookie) setcookie($name, ...$cookie);
        header("Connection: close");

        // finally, we get our content and send it down the pipe to the client.  theoretically, this
        // should be the only echo in our entire program!

        echo $this->response->content->get();

    }

    protected function render()
    {
        // rendering a response includes setting our layout, setting our view's data, and then
        // setting the response's content based on the rendering of that view.  luckily, this is all
        // pretty straightforward as follows.

        $this->view->setLayout("cheatsheets");
        $this->view->setData($this->getData());
        $this->response->content->set($this->view->__invoke());
    }

    protected function getData()
    {
        // this isn't a getter in the strictest sense.  firstly, it's protected and, secondly, we do some
        // default work here to make sure that the data for our layout is ready to go.  we assume that our
        // Response object handles the data that is necessary for its display and that it handed us that
        // data via the setData() or setView() methods above.  thus, we don't worry about anything here but
        // the site's chrome's data.

        if (empty($this->data['heading'])) $this->data['heading'] = $this->data['title'];
        $this->data['title'] .= " | The ShadowLab by Dashifen";
        return $this->data;
    }
}
