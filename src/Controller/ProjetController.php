<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProjetType;
class ProjetController extends AbstractController
{
    /**
     * @Route("/projet", name="projet")
     */
    public function index(): Response
    {
        return $this->render('projet/index.html.twig', [
            'controller_name' => 'ProjetController',
        ]);
    }

    /**
     * @Route("/add", name="addprojet")
     */
    public function add(\Symfony\Component\HttpFoundation\Request $request)
    {

        $projet = new Projet();
        $form=$this->createForm(ProjetType::class,$projet);
        $form->handleRequest($request);
        if ($form ->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($projet);
            $em->flush();
            return $this->redirectToRoute('addprojet');
        }

        return $this->render('projet/add.html.twig',array('formProjet'=>$form->createView()));
    }

    /**
     * @Route("/update/{id}", name="updateprojet")
     */
    public function update($id,\Symfony\Component\HttpFoundation\Request $request)
    {
        $projet = $this->getDoctrine()->getRepository(projet::class)->find($id);
        $form=$this->createForm(ProjetType::class,$projet);
        $form->handleRequest($request);
        if ($form ->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            //return $this->redirectToRoute('updateprojet');
            return new Response("le projet modifié est le projet d'id :".$projet->getId());

        }
        return $this->render('projet/update.html.twig',array('formProjet'=>$form->createView()));
    }

    /**
     * @Route("/remove/{id}", name="removeprojet")
     */
    public function remove($id)
    {
        $projet = $this->getDoctrine()->getRepository(Projet::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($projet);
        $em->flush();
        return $this->redirectToRoute('listprojet');

    }
    /**
     * @Route("/list", name="listprojet")
     */
    public function listProjet (ProjetRepository  $projetRepository )
    {
        $tabprojet =$projetRepository->findAll();
        return $this->render('projet/listeprojet.html.twig',array('tabprojet'=>$tabprojet));
    }
}
