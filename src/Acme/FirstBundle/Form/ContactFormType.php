<?php
/**
 * Created by PhpStorm.
 * User: Ričardas
 * Date: 14.7.30
 * Time: 11.58
 */
namespace Acme\FirstBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('email', 'email');
        $builder->add('subject');
        $builder->add('body', 'textarea');
    }

    public function getName()
    {
        return 'ContactForm';
    }
}