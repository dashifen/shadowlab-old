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
            return $this->{$method}($parameters);
        }

        return false;
    }

    protected function handleSendEmail(array $parameters = null)
    {
        $path = realpath(__DIR__ . "/../..");
        require_once($path . "/vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
        $config = function() use ($path) { return require $path . "/config.php"; };
        $config = $config();

        $mail = new \PHPMailer();
        //$mail->SMTPDebug = 2;
        //$mail->Debugoutput = "html";

        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->SMTPAuth = true;
        $mail->Username = "dashifen@gmail.com";
        $mail->Password = $config["email_password"];

        $mail->setFrom("dashifen@gmail.com", "The ShadowLab by Dashifen");
        $mail->addAddress($parameters["recipient"]);

        $mail->Subject = $parameters["subject"];
        $mail->msgHTML($parameters["message"]);
        $mail->AltBody = strip_tags($parameters["message"]);

        return $mail->send();
    }
}
