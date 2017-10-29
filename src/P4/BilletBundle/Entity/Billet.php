<?php

namespace P4\BilletBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Billet
 *
 * @ORM\Table(name="billet")
 * @ORM\Entity(repositoryClass="P4\BilletBundle\Repository\BilletRepository")
 */
class Billet
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\Length(min=2)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     * @Assert\Length(min=2)     
     */
    private $prenom;

    /**
     * @var date
     *
     * @ORM\Column(name="naissance", type="date")
     */
    private $naissance;

    /**
     * @var bool
     *
     * @ORM\Column(name="tarif", type="boolean")
     */
    private $tarif;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer")
     */
     private $prix;

     /**
     * @var string
     *
     * @ORM\Column(name="cle", type="string")
     */
     private $cle;

     /**
     * @var object
     * 
     * @ORM\ManyToOne(targetEntity="P4\BilletBundle\Entity\Formulaire", inversedBy="billets")
     */
     private $formulaire;
    
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Billet
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Billet
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set naissance
     *
     * @param date $naissance
     *
     * @return Billet
     */
    public function setNaissance($naissance)
    {
        $this->naissance = $naissance;

        return $this;
    }

    /**
     * Get naissance
     *
     * @return date
     */
    public function getNaissance()
    {
        return $this->naissance;
    }

    /**
     * Set tarif
     *
     * @param boolean $tarif
     *
     * @return Billet
     */
    public function setTarif($tarif)
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * Get tarif
     *
     * @return bool
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Set prix
     *
     * @param int $prix
     *
     * @return Billet
     */
     public function setPrix($prix)
     {
         $this->prix = $prix;
 
         return $this;
     }

     /**
     * Get prix
     *
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set cle
     *
     * @param string $cle
     *
     * @return Billet
     */
     public function setCle($cle)
     {
         $this->cle = $cle;
 
         return $this;
     }

     /**
     * Get cle
     *
     * @return string
     */
    public function getCle()
    {
        return $this->cle;
    }

    /**
     * Set formulaire
     *
     * @param Formulaire $formulaire
     *
     * @return Billet
     */
     public function setFormulaire(Formulaire $formulaire = null)
     {
        if ($this->formulaire !== null) {
            $this->formulaire->removeBillet($this);
        }

        $this->formulaire = $formulaire;

        if ($this->formulaire !== null) {
            $this->formulaire->addBillet($this);
        }
 
        return $this;
     }

     /**
     * Get formulaire
     *
     * @return Formulaire
     */
    public function getFormulaire()
    {
        return $this->formulaire;
    }
}