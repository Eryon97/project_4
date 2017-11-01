<?php

namespace P4\BilletBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use P4\BilletBundle\Entity\Billet;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Formulaire
 *
 * @ORM\Table(name="p4_formulaire")
 * @ORM\Entity(repositoryClass="P4\BilletBundle\Repository\FormulaireRepository")
 */
class Formulaire
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
     * @var date
     *
     * @ORM\Column(name="Date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="integer")
     */
     private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email()
     */
     private $email;

    /**
    * @ORM\OneToMany(targetEntity="P4\BilletBundle\Entity\Billets", mappedBy="formulaire")
    * @ORM\JoinTable(name="p4_formulaire_billets")
    */
    private $billets;


    public function __construct()
    {
      $this->billets   = new ArrayCollection();
    }

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
     * Set date
     *
     * @param date $date
     *
     * @return Formulaire
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nombre
     *
     * @param int $nombre
     *
     * @return Formulaire
     */
     public function setNombre($nombre)
     {
         $this->nombre = $nombre;
 
         return $this;
     }
 
     /**
      * Get nombre
      *
      * @return int
      */
     public function getNombre()
     {
         return $this->nombre;
     }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Formulaire
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Billet
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
    * @param Billet $billet
    */
    public function addBillet(Billet $billet)
    {
        $this->billets[] = $billet;
    }

    /**
    * @param Billet $billet
    */
    public function removeBillet(Billet $billet)
    {
        $this->billets->removeElement($billet);
    }

    /**
    * @return ArrayCollection
    */
    public function getBillets()
    {
        return $this->billets;
    }
}

