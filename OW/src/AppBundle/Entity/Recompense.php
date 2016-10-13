<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recompense
 *
 * @ORM\Table(name="recompense")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecompenseRepository")
 */
class Recompense 
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
     * @ORM\Column(name="name", type="string")
     *
     */
    private $name;
    /**
     * @ORM\Column(name="valeur", type="integer")
     *
     */
    private $valeur;
        /**
     * @ORM\Column(name="photo", type="string")
     *
     */
    private $photo;
        /**
     * @ORM\Column(name="event_id", type="integer")
     *
     */
    private $event_id;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

