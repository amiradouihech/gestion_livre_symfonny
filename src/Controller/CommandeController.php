<?php

namespace App\Controller;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
class CommandeController extends AbstractController
{
    #[Route('/admin/commande', name: 'app_commande')]
    public function index(CommandeRepository $res): Response
    {
        $commande=$res->findAll();
        return $this->render('commande/index.html.twig', [
            'commande' =>$commande ,
        ]);

    }
    #[Route('/admin/Commande/{id<\d+>}', name: 'app_admin_Commande_show')]
    public function show(Commande $co): Response
    {
        //ParamConverter
        return $this->render('commande/show.html.twig', [
            'co' =>$co,
        ]);
    }
    #[Route('/admin/Commande/update/{id}', name: 'app_admin_commande_update')]
    public function modif(Commande $co,EntityManagerInterface $em,Request $request): Response
    {
        
        //creation d'un objet formulaire
        $form=$this->createForm(CommandeType::class,$co);
        //Récupération et traitement des données
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($co);
            $em->flush();
            return $this->redirectToRoute('app_commande');

        }
        //affichage du formulaire
        return $this->render('commande/update.html.twig', [
            'f' => $form,
        ]);

    }
    #[Route('/admin/Commande/add', name: 'admin_commande_create')]
    public function add(EntityManagerInterface $em,Request $request): Response
    {
        $co=new Commande();
        //creation d'un objet formulaire
        $form=$this->createForm(CommandeType::class,$co);
        //Récupération et traitement des données
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($co);
            $em->flush();
            return $this->redirectToRoute('app_commande');

        }
        //affichage du formulaire
        return $this->render('commande/create.html.twig', [
            'f' => $form,
        ]);

    }
}
