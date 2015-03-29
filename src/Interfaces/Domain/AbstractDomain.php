<?php

namespace Shadowlab\Interfaces\Domain;

use Aura\View\Exception;
use League\Event\Emitter;
use League\Event\AbstractListener;
use Shadowlab\Exceptions\DomainException;
use Shadowlab\Interfaces\Domain\Payloads\PayloadFactory;

abstract class AbstractDomain implements Domain
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @varFactory
     */
    protected $factory;

    /**
     * @var Gateway
     */
    protected $gateway;

    /**
     * @var PayloadFactory
     */
    protected $payload;

    /**
     * @var AbstractListener
     */
    protected $listener;

    /**
     * @var Emitter
     */
    protected $emitter;

    public function __construct(
        Filter $filter,
        Factory $factory,
        Gateway $gateway,
        PayloadFactory $payload,
        AbstractListener $listener,
        Emitter $emitter
    ) {
        $this->setFilter($filter);
        $this->setFactory($factory);
        $this->setGateway($gateway);
        $this->setPayload($payload);
        $this->setListener($listener);
        $this->setEmitter($emitter);
    }

    /**
     * @return Payload|null
     */
    public function getPayload($type)
    {
        return method_exists($this->payload, $type)
            ? $this->payload->$type()
            : null;
    }

    /**
     * @param AbstractListener $listener
     */
    protected function setListener(AbstractListener $listener)
    {
        $this->listener = $listener;
    }

    /**
     * @param Emitter $emitter
     * @throws DomainException
     */
    protected function setEmitter(Emitter $emitter)
    {
        $this->emitter = $emitter;
        if (!($this->listener instanceof AbstractListener)) {
            throw new DomainException("Cannot add emiter without a listener.");
        }

        $this->emitter->addListener("*", $this->listener);
    }

    /**
     * @param string $template
     * @param array $variables
     * @return string
     */
    protected function convertTemplate($template, array $variables)
    {
        preg_match_all('/(?<=\\$)(\w+)/', $template, $matches);

        foreach ($matches[0] as $match) {
            if (isset($variables[$match])) {
                $template = str_replace("$" . $match, $variables[$match], $template);
            }
        }

        return $template;
    }

    abstract protected function setFilter(Filter $filter);

    abstract protected function setFactory(Factory $factory);

    abstract protected function setGateway(Gateway $gateway);

    abstract protected function setPayload(PayloadFactory $payload);
}
