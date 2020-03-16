<?php

namespace App\Controller;

use App\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    /**
     * @Route("/formation", name="formation")
     */
    public function index()
    {
        return $this->render('formation/index.html.twig', [
            'controller_name' => 'FormationController',
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request)
    {
        $formation = new Formation();
        $form= $this->createForm("App\\Form\\FormationFormType",$formation);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em= $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute("list");
        }
          return $this->render("formation/add.html.twig",array('form'=>$form->createView()));
    }

    /**
     * @Route("/list", name="list")
     */
    public function list(){
        $formations= $this->getDoctrine()->getRepository(Formation::class)->findAll();
        return $this->render("formation/list.html.twig",array('entities'=>$formations));
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $request,$id)
    {

          $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);
        $form= $this->createForm("App\\Form\\FormationFormType",$formation);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em= $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("list");
        }
        return $this->render("formation/update.html.twig",array('form'=>$form->createView()));
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id)
    {
            $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);
            $em= $this->getDoctrine()->getManager();
            $em->remove($formation);
            $em->flush();
            return $this->redirectToRoute("list");
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show($id)
    {
        $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);
        return $this->render("formation/show.html.twig",array('formation'=>$formation));

    }
}
