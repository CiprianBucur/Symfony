<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Symfony;

class SymfonyControlerController extends Controller {
    /**
     * @Route("/", name="fav_list")
     */
    public function indexAction() {
        return $this->render('fav/index.html.twig', array());
    }

    /**
     * @Route("/fav/add", name="add_fav")
     */
    public function addAction() {
        $this->addFlash('notice', 'Favorite added.');
        return $this->render('fav/add.html.twig', array());
    }

    /**
     * @Route("/fav/details/{id}", name="view_fav")
     */
    public function viewAction($id) {
        $this->addFlash('notice', 'Details of favorite: ' . $id . ".");
        return $this->render('fav/view.html.twig', array());
    }

    /**
     * @Route("/fav/edit/{id}", name="edit_fav")
     */
    public function editAction($id) {
        $this->addFlash('notice', 'Edited favorite: ' . $id . ".");
        return $this->render('fav/edit.html.twig', array());
    }

    /**
     * @Route("/fav/delete/{id}", name="delete_fav")
     */
    public function deteleAction($id) {
        $this->addFlash('error', 'Favorite ' . $id . " couldn't be removed.");
        return $this->redirectToRoute('fav_list');
    }

}
