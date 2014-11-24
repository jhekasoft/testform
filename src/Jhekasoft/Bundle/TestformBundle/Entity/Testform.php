<?php

namespace Jhekasoft\Bundle\TestformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="testform")
 */
class Testform
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $ip;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="datetime", name="birthday_date", nullable=true)
     */
    protected $birthdayDate;

    /**
     * @ORM\Column(type="string", length=100, name="shoe_size", nullable=true)
     */
    protected $shoeSize;

    /**
     * @ORM\Column(type="boolean", name="personal_data_setted", nullable=true)
     */
    protected $personalDataSetted;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $answer1;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $answer2;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $answer3;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $answer4;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $answer5;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $ended;

    /**
     * @ORM\Column(type="datetime", name="ended_at", nullable=true)
     */
    protected $endedAt;

    /**
     * @ORM\Column(type="string", length=100, name="result_seconds", nullable=true)
     */
    protected $resultSeconds;

    /**
     * @ORM\Column(type="datetime", name="created_at", nullable=true)
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $errorlogs;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Testform
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Testform
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Testform
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Testform
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set birthdayDate
     *
     * @param \DateTime $birthdayDate
     * @return Testform
     */
    public function setBirthdayDate($birthdayDate)
    {
        $this->birthdayDate = $birthdayDate;

        return $this;
    }

    /**
     * Get birthdayDate
     *
     * @return \DateTime
     */
    public function getBirthdayDate()
    {
        return $this->birthdayDate;
    }

    /**
     * Set shoeSize
     *
     * @param string $shoeSize
     * @return Testform
     */
    public function setShoeSize($shoeSize)
    {
        $this->shoeSize = $shoeSize;

        return $this;
    }

    /**
     * Get shoeSize
     *
     * @return string
     */
    public function getShoeSize()
    {
        return $this->shoeSize;
    }

    /**
     * Set answer1
     *
     * @param string $answer1
     * @return Testform
     */
    public function setAnswer1($answer1)
    {
        $this->answer1 = $answer1;

        return $this;
    }

    /**
     * Get answer1
     *
     * @return string
     */
    public function getAnswer1()
    {
        return $this->answer1;
    }

    /**
     * Set answer2
     *
     * @param string $answer2
     * @return Testform
     */
    public function setAnswer2($answer2)
    {
        $this->answer2 = $answer2;

        return $this;
    }

    /**
     * Get answer2
     *
     * @return string
     */
    public function getAnswer2()
    {
        return $this->answer2;
    }

    /**
     * Set answer3
     *
     * @param string $answer3
     * @return Testform
     */
    public function setAnswer3($answer3)
    {
        $this->answer3 = $answer3;

        return $this;
    }

    /**
     * Get answer3
     *
     * @return string
     */
    public function getAnswer3()
    {
        return $this->answer3;
    }

    /**
     * Set answer4
     *
     * @param string $answer4
     * @return Testform
     */
    public function setAnswer4($answer4)
    {
        $this->answer4 = $answer4;

        return $this;
    }

    /**
     * Get answer4
     *
     * @return string
     */
    public function getAnswer4()
    {
        return $this->answer4;
    }

    /**
     * Set answer5
     *
     * @param string $answer5
     * @return Testform
     */
    public function setAnswer5($answer5)
    {
        $this->answer5 = $answer5;

        return $this;
    }

    /**
     * Get answer5
     *
     * @return string
     */
    public function getAnswer5()
    {
        return $this->answer5;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Testform
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Testform
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set ended
     *
     * @param boolean $ended
     * @return Testform
     */
    public function setEnded($ended)
    {
        $this->ended = $ended;

        return $this;
    }

    /**
     * Get ended
     *
     * @return boolean
     */
    public function getEnded()
    {
        return $this->ended;
    }

    /**
     * Set endedAt
     *
     * @param \DateTime $endedAt
     * @return Testform
     */
    public function setEndedAt($endedAt)
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    /**
     * Get endedAt
     *
     * @return \DateTime
     */
    public function getEndedAt()
    {
        return $this->endedAt;
    }

    /**
     * Set personalDataSetted
     *
     * @param boolean $personalDataSetted
     * @return Testform
     */
    public function setPersonalDataSetted($personalDataSetted)
    {
        $this->personalDataSetted = $personalDataSetted;

        return $this;
    }

    /**
     * Get personalDataSetted
     *
     * @return boolean
     */
    public function getPersonalDataSetted()
    {
        return $this->personalDataSetted;
    }

    /**
     * Set resultSeconds
     *
     * @param string $resultSeconds
     * @return Testform
     */
    public function setResultSeconds($resultSeconds)
    {
        $this->resultSeconds = $resultSeconds;

        return $this;
    }

    /**
     * Get resultSeconds
     *
     * @return string
     */
    public function getResultSeconds()
    {
        return $this->resultSeconds;
    }

    public function getAnswer($number)
    {
        return $this->{"answer{$number}"};
    }

    /**
     * Set errorlogs
     *
     * @param array $errorlogs
     * @return Testform
     */
    public function setErrorlogs(array $errorlogs)
    {
        $this->errorlogs = serialize($errorlogs);

        return $this;
    }

    /**
     * Get errorlogs
     *
     * @return array
     */
    public function getErrorlogs()
    {

        return isset($this->errorlogs)?unserialize($this->errorlogs):array();
    }
}
