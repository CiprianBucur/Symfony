<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Symfony;

class SymfonyControlerController extends Controller
{
    /**
     * @Route("/", name="fav_list")
     */
    public function indexAction()
    {
        return $this->render('fav/index.html.twig', array());
    }
}
