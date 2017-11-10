<?php

namespace P4\BilletBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class Start
{
    private $id;

    private $date;

    private $nombre;

    private $type;

    private $email;

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
}

