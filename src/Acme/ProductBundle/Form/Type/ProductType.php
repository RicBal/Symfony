<?php
/**
 * Created by PhpStorm.
 * User: Ričardas
 * Date: 14.9.2
 * Time: 16.32
 */
namespace Acme\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'entity', array(
                'class' => 'AcmeProductBundle:Product',
                'property' => 'name',
                'empty_value' => '--Select product--',
            ))
            ->add('width', 'number')
            ->add('height', 'number')
            ->add('submit', 'submit');
    }

    public function getName()
    {
        return 'product';
    }
}