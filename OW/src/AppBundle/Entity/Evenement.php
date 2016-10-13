<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EvenementRepository")
 */
class Evenement
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
     * @ORM\Column(name="nom", type="string")
     *
     */
    private $nom;
    /**
     * @ORM\Column(name="date", type="date")
     *
     */
    private $date;
        /**
     * @ORM\Column(name="heure", type="time")
     *
     */
    private $heure;
        /**
     * @ORM\Column(name="adresse", type="string")
     *
     */
    private $adresse;
        /**
     * @ORM\Column(name="theme", type="string")
     *
     */
    private $theme;
        /**
     * @ORM\Column(name="budget", type="integer")
     *
     */
    private $budget;



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
     * Get name
     *
     * @return string
     */
    public function getname()
    {
        return $this->name;
    }

     /**
     * Get date
     *
     * @return int
     */
    public function getdate()
    {
        return $this->date;
    }

     /**
     * Get time
     *
     * @return int
     */
    public function gettime()
    {
        return $this->time;
    }

     /**
     * Get adress
     *
     * @return int
     */
    public function getadress()
    {
        return $this->id;
    }

     /**
     * Get theme
     *
     * @return int
     */
    public function gettheme()
    {
        return $this->theme;
    }

     /**
     * Get id
     *
     * @return int
     */
    public function getbudget()
    {
        return $this->budget;
    }


}

