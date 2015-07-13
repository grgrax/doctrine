<?php
namespace student\models;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity()
 * @ORM\Table(name="tbl_students")
 */
class student
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * Get id
     *
     * @return integer 
     */


    /**
    * @ORM\Column(name="name",type="string",nullable=false,unique=true)
    */
    private $name;


    /**
    * @ORM\OneToOne(targetEntity="student\Models\student")
    */
    private $mentor;

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return student
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
     * Set mentor
     *
     * @param \student\Models\student $mentor
     * @return student
     */
    public function setMentor(\student\Models\student $mentor = null)
    {
        $this->mentor = $mentor;

        return $this;
    }

    /**
     * Get mentor
     *
     * @return \student\Models\student 
     */
    public function getMentor()
    {
        return $this->mentor;
    }
}
