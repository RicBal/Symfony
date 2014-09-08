<?php
/**
 * Created by PhpStorm.
 * User: Ričardas
 * Date: 14.7.30
 * Time: 11.54
 */

namespace Acme\FirstBundle\Entity;

class ContactForm
{
    protected $name;
    protected $email;
    protected $subject;
    protected $body;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }
}