<?php
/**
 * Created by PhpStorm.
 * User: Ričardas
 * Date: 14.8.1
 * Time: 12.53
 */
namespace Acme\FirstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{
    public function sudokuAction()
    {
        return $this->render('AcmeFirstBundle:Games:sudoku.html.twig');
    }
}