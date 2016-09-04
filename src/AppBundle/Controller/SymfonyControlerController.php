<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Symfony;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class SymfonyControlerController extends Controller {
    /**
     * @Route("/", name="fav_list")
     */
    public function indexAction() {

        $favorites = $this->getDoctrine()
            ->getRepository('AppBundle:Symfony')
            ->findAll();

        return $this->render('fav/index.html.twig', array(
            'favorites' => $favorites
        ));
    }

    /**
     * @Route("/fav/add", name="add_fav")
     */
    public function addAction(Request $request) {
        $fav = new Symfony();
        $form = $this->createFormBuilder($fav)
            ->add('name', TextType::class,
                array('attr' =>
                    array('class' => 'form-control',
                        'style' => 'margin-bottom: 15px')
                ))
            ->add('description', TextareaType::class,
                array('attr' =>
                    array('class' => 'form-control',
                        'style' => 'margin-bottom: 15px')
                ))
            ->add('save', SubmitType::class,
                array(
                    'label' => 'Create favorite',
                    'attr' =>
                        array('class' => 'btn-primary',
                            'style' => 'margin-bottom: 15px')
                ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form['name']->getData();
            $description = $form['description']->getData();
            $now = new\DateTime('now');

            $fav->setName($name);
            $fav->setDescription($description);
            $fav->setLastUpdated($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($fav);
            $em->flush();

            $this->addFlash('notice', 'Favorite added.');
            return $this->redirectToRoute('fav_list');
        }
        return $this->render('fav/add.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/fav/details/{id}", name="view_fav")
     */
    public function viewAction($id) {
        $fav = $this->getDoctrine()
            ->getRepository('AppBundle:Symfony')
            ->find($id);

        if (!$fav) {
            $this->addFlash('error', 'Error reading favorite: ' . $id . ".");
            return $this->redirectToRoute('fav_list');
           /* throw $this->createNotFoundException(
                'No favorite found with id: '.$id
            );*/
        }

        return $this->render('fav/view.html.twig', array('favorites' => $fav));
    }

    /**
     * @Route("/fav/edit/{id}", name="edit_fav")
     */
    public function editAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $fav = $em
            ->getRepository('AppBundle:Symfony')
            ->find($id);

        if (!$fav) {
            $this->addFlash('error', 'Error editing favorite: ' . $id . ".");
            return $this->redirectToRoute('fav_list');
        }

        $form = $this->createFormBuilder($fav)
            ->add('name', TextType::class,
                array('attr' =>
                    array('class' => 'form-control',
                        'style' => 'margin-bottom: 15px')
                ))
            ->add('description', TextareaType::class,
                array('attr' =>
                    array('class' => 'form-control',
                        'style' => 'margin-bottom: 15px')
                ))
            ->add('save', SubmitType::class,
                array(
                    'label' => 'Update favorite',
                    'attr' =>
                        array('class' => 'btn-primary',
                            'style' => 'margin-bottom: 15px')
                ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form['name']->getData();
            $description = $form['description']->getData();
            $now = new\DateTime('now');

            $fav->setName($name);
            $fav->setDescription($description);
            $fav->setLastUpdated($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($fav);
            $em->flush();

            $this->addFlash('notice', 'Favorite ' . $id . " was updated.");
            return $this->redirectToRoute('fav_list');
        }

        return $this->render('fav/edit.html.twig', array('favorites' => $fav, 'form' => $form->createView()));
    }

    /**
     * @Route("/fav/delete/{id}", name="delete_fav")
     */
    public function deteleAction($id) {
        $em = $this->getDoctrine()->getManager();
        $fav = $em
            ->getRepository('AppBundle:Symfony')
            ->find($id);

        if (!$fav) {
            $this->addFlash('error', 'Favorite ' . $id . " couldn't be removed.");
        }
        else {
            $this->addFlash('notice', 'Favorite ' . $id . " deleted.");
            $em->remove($fav);
            $em->flush();
        }
        return $this->redirectToRoute('fav_list');
    }

}
