<?php
namespace AppBundle\Entity;

use AppBundle\Model\User as BaseUser;

class User extends BaseUser
{
    /**
     *
     * @var boolean
     */
    protected $isEmailChanged = false;

    /**
     * 
     * @return boolean
     */
    function isEmailChanged()
    {
        return $this->isEmailChanged;
    }
    
    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        if ($this->email && $this->email != $email)
        {
            $this->isEmailChanged = true;
        }
        return parent::setEmail($email);
    }
}
