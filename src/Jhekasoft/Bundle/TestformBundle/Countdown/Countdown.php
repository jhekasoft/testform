<?php

namespace Jhekasoft\Bundle\TestformBundle\Countdown;

use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Jhekasoft\Bundle\TestformBundle\Entity\Testform;

class Countdown
{
    protected $sessionNamespace;
    protected $session;
    protected $countdownSeconds;
    protected $em;
    protected $requestInjector;

    public function __construct(RequestInjector $requestInjector, EntityManager $em, $sessionNamespace = '', $countdownSeconds = 360) {
        $this->requestInjector = $requestInjector;
        $this->em = $em;
        $this->sessionNamespace = $sessionNamespace;
        $this->session = new Session();
        $this->session->start();
        $this->countdownSeconds = $countdownSeconds;
    }

    public function start() {
        if ($this->session->has($this->sessionNamespace . '_testform_started')) {
            return;
        }

        $this->session->set($this->sessionNamespace . '_testform_started', true);

        $startDateTime = new \DateTime();
        $this->session->set($this->sessionNamespace . '_testform_start_timestamp', $startDateTime->getTimestamp());

        $testform = new Testform();
        $testform->setIp($this->requestInjector->getRequest()->getClientIp());
        $testform->setCreatedAt(new \DateTime());
        $testform->setUpdatedAt(new \DateTime());
        $testform->setAnswer1($this->sessionNamespace);

        $this->em->persist($testform);
        $this->em->flush();

        $this->session->set($this->sessionNamespace . '_testform_id', $testform->getId());
    }

    public function reset() {
        $this->session->remove($this->sessionNamespace . '_testform_started');
    }

    public function getSecondsLeft() {
        $currentDateTime = new \DateTime();

        $timeHasPassed = $currentDateTime->getTimestamp() - $this->session->get($this->sessionNamespace . '_testform_start_timestamp');
        $secondsLeft = $this->countdownSeconds - $timeHasPassed;
        if ($secondsLeft < 0) {
            $secondsLeft = 0;
        }

        return $secondsLeft;
    }

    public function getCountdownSeconds() {
        return $this->countdownSeconds;
    }

    public function getStartTimestamp() {
        if (!$this->session->has($this->sessionNamespace . '_testform_started')) {
            return NULL;
        }

        return $this->session->get($this->sessionNamespace . '_testform_start_timestamp');
    }

    public function getTestformId() {
        if (!$this->session->has($this->sessionNamespace . '_testform_id')) {
            return NULL;
        }

        return $this->session->get($this->sessionNamespace . '_testform_id');
    }
}
