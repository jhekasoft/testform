<?php

namespace Jhekasoft\Bundle\RegistrationBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Jhekasoft\Bundle\RegistrationBundle\Entity\User;

class Registration
{
    /**
     * @Assert\Type(type="Jhekasoft\Bundle\RegistrationBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;


    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
