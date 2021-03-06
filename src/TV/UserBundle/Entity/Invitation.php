<?php

namespace TV\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invitation
 *
 * @ORM\Table(name="invitation")
 * @ORM\Entity(repositoryClass="TV\UserBundle\Repository\InvitationRepository")
 */
class Invitation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $sender;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\UserBundle\Entity\Band", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $band;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\UserBundle\Entity\User", inversedBy="invitations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $receiver;
    
    /**
    * @ORM\Column(name="response", type="boolean", nullable=true)
    */
    private $response;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set sender
     *
     * @param string $sender
     *
     * @return Invitation
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }
    
    /**
     * Set receiver
     * 
     * @param int $receiver
     *
     * @return Invitation
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return string
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Set response
     *
     * @param boolean $response
     *
     * @return Invitation
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get response
     *
     * @return boolean
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set band
     *
     * @param \TV\UserBundle\Entity\Band $band
     *
     * @return Invitation
     */
    public function setBand(\TV\UserBundle\Entity\Band $band = null)
    {
        $this->band = $band;

        return $this;
    }

    /**
     * Get band
     *
     * @return \TV\UserBundle\Entity\Band
     */
    public function getBand()
    {
        return $this->band;
    }
}
