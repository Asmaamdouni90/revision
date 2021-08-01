<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Form\ProjetType;
class EquipeController extends AbstractController
{
    /**
     * @Route("/equipe", name="equipe")
     */
    public function index(): Response
    {
        return $this->render('equipe/index.html.twig', [
            'controller_name' => 'EquipeController',
        ]);
    }

    /**
     * @Route("/addequipe", name="addequipe")
     */
    public function add( EquipeRepository $repository,\Symfony\Component\HttpFoundation\Request $request)
    {
       $equipes=$repository->findAll();//1
        $equipe = new Equipe();//1
        $projet=new Projet();//2
        $form=$this->createForm(EquipeType::class,$equipe);
        $formProjet=$this->createForm(ProjetType::class,$projet);//2
       $form->handleRequest($request);
        if ($form ->isSubmitted()){
           $em=$this->getDoctrine()->getManager();
           $em->persist($equipe);
            $em->flush();
            return $this->redirectToRoute('addequipe');
       }
        $formProjet->handleRequest($request);//2
        if ($formProjet ->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($projet);
            $em->flush();
            return $this->redirectToRoute('addequipe');
        }
        return $this->render('equipe/add.html.twig',array('formProjet'=>$formProjet->createView(),'equipe'=>$equipes,'formEquipe'=>$form->createView()));
    }


}
