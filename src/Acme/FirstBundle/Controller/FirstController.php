<?php
/**
 * Created by PhpStorm.
 * User: Ričardas
 * Date: 14.7.28
 * Time: 12.36
 */
namespace Acme\FirstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FirstController extends Controller
{
    public function homeAction()
    {
        return $this->render('AcmeFirstBundle:Home:home.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('AcmeFirstBundle:Home:about.html.twig');
    }

    public function adminPanelAction()
    {
        return $this->render('AcmeFirstBundle:AdminPanel:adminPanel.html.twig');
    }

    public function userProfileAction()
    {
        return $this->render('AcmeFirstBundle:Profile:userProfile.html.twig');
    }
}