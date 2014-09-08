<?php
/**
 * Created by PhpStorm.
 * User: Ričardas
 * Date: 14.9.2
 * Time: 16.38
 */
namespace Acme\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\ProductBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Acme\ProductBundle\Form\Type\ProductType;

class ProductController extends Controller
{
    public function directAction(Request $request)
    {
        if($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->getProductListAction();
        }
        else {
            return $this->chooseProductAction($request);
        }
    }

    public function getProductListAction()
    {
        $product = $this->getDoctrine()->getRepository('AcmeProductBundle:Product')->findAll();
        return $this->render('AcmeProductBundle:Product:listProduct.html.twig', array('products' => $product));
    }

    public function setProductAction(Request $request)
    {
        $product = new Product();
        $form = $this->createFormBuilder($product)
            ->add('name')
            ->add('about')
            ->add('color')
            ->add('price', 'number')
            ->add('submit', 'submit')
            ->getForm();
        if($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $product->setCreated(new \DateTime);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'Congratulations!');
                return $this->redirect($this->generateUrl('acme_product_list'));
            }
        }
        return $this->render('AcmeProductBundle:Product:addProduct.html.twig', array('form' => $form->createView()));
    }

    public function chooseProductAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(new ProductType(), $product);
        $form->handleRequest($request);
        if($form->isValid()) {
            $size = $product->getWidth() * $product->getHeight();
            $name = $product->getName();
            return $this->render('AcmeProductBundle:Product:selectedInfo.html.twig', array('product' => $name, 'size' => $size));
        }
        return $this->render('AcmeProductBundle:Product:chooseProduct.html.twig', array('form' => $form->createView()));
    }
}