<?php

namespace frontend\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassName
 */
class ClassName
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;


    /**
     * Set id
     *
     * @param integer $id
     * @return ClassName
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Set username
     *
     * @param string $username
     * @return ClassName
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }
}
