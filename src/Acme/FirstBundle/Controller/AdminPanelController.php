<?php
/**
 * Created by PhpStorm.
 * User: Ričardas
 * Date: 14.8.7
 * Time: 14.23
 */
namespace Acme\FirstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class AdminPanelController extends Controller
{
    public function listAction()
    {
        $repository = $this->getDoctrine()->getRepository('AcmeUserBundle:User');
        $users = $repository->findAll();
        return $this->render('AcmeFirstBundle:AdminPanel:usersList.html.twig', array('users' => $users));
    }

    public function addAction(Request $request)
    {
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('email', 'email')
            ->add('username')
            ->add('plainPassword', 'repeated', array(
                'first_name' => 'password',
                'second_name' => 'confirm',
                'type' => 'password',
                'invalid_message' => 'Passwords does not match'))
            ->add('enabled', 'text')
            ->add('Add', 'submit')
            ->getForm();
        if($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->get('session')->getFlashBag()->add('successMsg', 'User successfully added!');
                return $this->redirect($this->generateUrl('admin_list_users'));
            }
        }
            return $this->render('AcmeFirstBundle:AdminPanel:addUser.html.twig', array('form' => $form->createView()));
    }

    public function editAction($id, Request $request)
    {
        if($id == 0) {
            $this->get('session')->getFlashBag()->add('successMsg', 'Wrong user ID!');
            return $this->redirect($this->generateUrl('admin_edit_user'));
        }
        $user = $this->getDoctrine()->getRepository('AcmeUserBundle:User')->find($id);

        if(!$user) {
            throw $this->createNotFoundException('There are no user with id: '.$id);
        }
        $form = $this->createFormBuilder($user)
            ->add('email', 'email')
            ->add('username')
            ->add('enabled', 'text')
            ->add('Edit', 'submit')
            ->getForm();
        if($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->get('session')->getFlashBag()->add('successMsg', 'User data successfully updated!');
                return $this->redirect($this->generateUrl('admin_list_users'));
            }
        }
        return $this->render('AcmeFirstBundle:AdminPanel:editUser.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function changeUserPasswordAction($id, Request $request)
    {
        if($id == 0) {
            $this->get('session')->getFlashBag()->add('successMsg', 'Wrong user ID!');
            return $this->redirect($this->generateUrl('admin_edit_user'));
        }
        $user = $this->getDoctrine()->getRepository('AcmeUserBundle:User')->find($id);

        if(!$user) {
            throw $this->createNotFoundException('There are no user with id: '.$id);
        }
        $form = $this->createFormBuilder($user)
            ->add('password', 'password', array(
                'label' => 'Current password'
            ))
            ->add('Change', 'submit')
            ->getForm();
        if($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if($form->isValid()) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($form["password"]->getData(), $user->getSalt());
                $user->setPassword($password);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->get('session')->getFlashBag()->add('successMsg', 'User password successfully changed!');
                return $this->redirect($this->generateUrl('admin_list_users'));
            }
        }
        return $this->render('AcmeFirstBundle:AdminPanel:changeUserPassword.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    public function deleteAction($id)
    {
        if($id == 0) {
            $this->get('session')->getFlashBag()->add('successMsg', 'Wrong user ID!');
            return $this->redirect($this->generateUrl('admin_panel'));
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AcmeUserBundle:User')->find($id);

        if(!$user) {
            throw $this->createNotFoundException('There are no user with id: '.$id);
        } else {
            $em->remove($user);
            $em->flush();
            $this->get('session')->getFlashBag()->add('successMsg', 'User successfully deleted!');
            return $this->redirect($this->generateUrl('admin_list_users'));
        }
    }
}