<?php

namespace Jhekasoft\Bundle\TestformBundle\Countdown;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class RequestInjector{

    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function getRequest() {
        return $this->container->get('request');
    }
}