<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wine
 *
 * @ORM\Table(name="wine")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WineRepository")
 */
class Wine
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="composition", type="string", length=255)
     */
    private $composition;

    /**
     * @var int
     *
     * @ORM\Column(name="vintage", type="integer")
     */
    private $vintage;

    /**
     * @var string
     *
     * @ORM\Column(name="method", type="text")
     */
    private $method;

    /**
     * @var string
     *
     * @ORM\Column(name="history", type="text")
     */
    private $history;

    /**
     * @var string
     *
     * @ORM\Column(name="key_point", type="text")
     */
    private $keyPoint;

    /**
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @var bool
     *
     * @ORM\Column(name="hidden", type="boolean")
     */
    private $hidden;

    /**
     * @var string
     *
     * @ORM\Column(name="style", type="string", length=255)
     */
    private $style;

    /**
     * @var string
     *
     * @ORM\Column(name="testing_notes", type="text")
     */
    private $testingNotes;


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
     * Set name
     *
     * @param string $name
     *
     * @return Wine
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Wine
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set composition
     *
     * @param string $composition
     *
     * @return Wine
     */
    public function setComposition($composition)
    {
        $this->composition = $composition;

        return $this;
    }

    /**
     * Get composition
     *
     * @return string
     */
    public function getComposition()
    {
        return $this->composition;
    }

    /**
     * Set vintage
     *
     * @param integer $vintage
     *
     * @return Wine
     */
    public function setVintage($vintage)
    {
        $this->vintage = $vintage;

        return $this;
    }

    /**
     * Get vintage
     *
     * @return int
     */
    public function getVintage()
    {
        return $this->vintage;
    }

    /**
     * Set method
     *
     * @param string $method
     *
     * @return Wine
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set history
     *
     * @param string $history
     *
     * @return Wine
     */
    public function setHistory($history)
    {
        $this->history = $history;

        return $this;
    }

    /**
     * Get history
     *
     * @return string
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * Set keyPoint
     *
     * @param string $keyPoint
     *
     * @return Wine
     */
    public function setKeyPoint($keyPoint)
    {
        $this->keyPoint = $keyPoint;

        return $this;
    }

    /**
     * Get keyPoint
     *
     * @return string
     */
    public function getKeyPoint()
    {
        return $this->keyPoint;
    }

    /**
     * Set region
     *
     * @param Region $region
     *
     * @return Wine
     */
    public function setRegion(Region $region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set hidden
     *
     * @param boolean $hidden
     *
     * @return Wine
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return bool
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set style
     *
     * @param string $style
     *
     * @return Wine
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set testingNotes
     *
     * @param string $testingNotes
     *
     * @return Wine
     */
    public function setTestingNotes($testingNotes)
    {
        $this->testingNotes = $testingNotes;

        return $this;
    }

    /**
     * Get testingNotes
     *
     * @return string
     */
    public function getTestingNotes()
    {
        return $this->testingNotes;
    }
}

