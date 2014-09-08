<?php
/**
 * Created by PhpStorm.
 * User: Ričardas
 * Date: 14.7.28
 * Time: 12.36
 */
namespace Acme\FirstBundle\Controller;

use Acme\FirstBundle\Entity\ContactForm;
use Acme\FirstBundle\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

class ContactController extends Controller
{
    public function contactAction(Request $request)
    {
        $ContactFormObj = new ContactForm();
        $ContactForm = $this->createForm(new ContactFormType(), $ContactFormObj);

        if($request->getMethod() == "POST") {
            $ContactForm->handleRequest($request);
            if($ContactForm->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Contact Form')
                    ->setFrom('send@example.com')
                    ->setTo('BRycka121@gmail.com')
                    ->setBody($this->renderView('AcmeFirstBundle:Mail:email.html.twig', array('mail' => $ContactFormObj)));
                $this->get('mailer')->send($message);
                $this->get('session')->getFlashBag()->add('successMsg', 'Mail successfully sent!');
                return $this->redirect($this->generateUrl("first_contactUs"));
            }
        }
        return $this->render('AcmeFirstBundle:Home:contactUs.html.twig', array(
            'form' => $ContactForm->createView(),
        ));
    }
}