<?php

namespace Shadowlab\Listener;

use League\Event\EventInterface;
use League\Event\AbstractListener;


class Listener extends AbstractListener
{
    public function handle(EventInterface $event, array $parameters = null)
    {
        if ($event->isPropagationStopped()) return;

        $name = $event->getName();
        $method = "handle" . ucfirst($name);
        if (method_exists($this, $method)) {
            $this->{$method}($parameters);
        }
    }

    protected function handleSendEmail(array $parameters = null)
    {
        $path = realpath(__DIR__ . "/../..");
        require_once($path . "/vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
        $config = function() use ($path) { return require $path . "/config.php"; };
        $config = $config();

        $message = new \PHPMailer();

        $message->isSMTP();
        $message->SMTPAuth = true;
        $message->Host = "a2ss9.a2hosting.com";
        $message->Username = "dashifen@dashifen.com";
        $message->Password = $config["email_password"];
        $message->SMTPSecure = "ssl";
        $message->Port = 465;

        $message->FromName = "The ShadowLab";
        $message->From = "dashifen+shadowlab@gmail.com";
        $message->Subject = $parameters["subject"];
        $message->AltBody = strip_tags($parameters["message"]);
        $message->Body = $parameters["message"];

        $message->addAddress($parameters["recipient"]);

        if(!$message->send()) {
            echo "Message could not be sent.<br>";
            echo "Mailer Error: " . $message->ErrorInfo;
        } else {
            echo "Message sent.";
        }

        die();
    }
}
