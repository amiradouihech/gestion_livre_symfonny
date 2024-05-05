<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Form\LivreType;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\form;

  
class LivresController extends AbstractController
{
    #[Route('/admin/livres', name: 'app_admin_livres')]
    
    public function index(LivresRepository $res): Response
    {
        //$livre=$res->findByExampleField(100); 
        //dd($livre)  ;
        $livres=$res->findAll();
        return $this->render('livres/index.html.twig', [
            'livres' =>$livres,
        ]);
    }
    #[Route('/admin/livres/{id<\d+>}', name: 'app_admin_livres_show')]
    public function show(Livres $livre): Response
    {
        //ParamConverter
        return $this->render('livres/show.html.twig', [
            'livre' =>$livre,
        ]);
    }
    #[Route('/profile/livres', name: 'app_admin_livres_client')]
    public function afficheClient(LivresRepository $res): Response
    {
        //afficher pour client 
        $livres=$res->findAll();
        return $this->render('affiche_livre/index.html.twig', [
            'livres' =>$livres,
        ]);
    }
    #[Route('/admin/livres/update/{id}', name: 'app_admin_livres_update')]
    public function modif(Livres $livre,EntityManagerInterface $em,Request $request): Response
    {
        
        //creation d'un objet formulaire
        $form=$this->createForm(Livres::class,$livre);
        //Récupération et traitement des données
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($livre);
            $em->flush();
            return $this->redirectToRoute('admin_livres');

        }
        //affichage du formulaire
        return $this->render('livres/update.html.twig', [
            'f' => $form,
        ]);

    }
    #[Route('/admin/Livre/add', name: 'admin_livre_create')]
    public function add(EntityManagerInterface $em,Request $request): Response
    {
        $livre=new Livres();
        //creation d'un objet formulaire
        $form=$this->createForm(LivreType::class,$livre);
        //Récupération et traitement des données
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($livre);
            $em->flush();
            return $this->redirectToRoute('app_admin_livres');

        }
        //affichage du formulaire
        return $this->render('livres/create.html.twig', [
            'f' => $form,
        ]);

    }
 
    #[Route('/admin/livres/create', name: 'app_admin_livres_create')]
    public function create(EntityManagerInterface $em): Response
    {
        $livre=new Livres();
        $livre->setAuteur('auteur 1');
        $livre->setDateEdition(new \DateTime('01-01-2023'));
        $livre->setTitre('titre 4');
        $livre->setResume('1213118hhvgv');
        $livre->setSlug('titre-1');
        $livre->setPrix(200);
        $livre->setEditeur('re1');
        $livre->setISBN('111.111.111.11');
        $livre->setImage('https://picsum.photos/id/237/200/300');
        $livre1=new Livres();
        $livre1->setAuteur('auteur 1');
        $livre1->setDateEdition(new \DateTime('01-01-2023'));
        $livre1->setTitre('titre 4');
        $livre1->setResume('1213118hhvgv');
        $livre1->setSlug('titre-1');
        $livre1->setPrix(200);
        $livre1->setEditeur('re1');
        $livre1->setISBN('111.111.111.11');
        $livre1->setImage('https://picsum.photos/id/237/200/300');
        $em->persist($livre);
        $em->persist($livre1);//preparire un objet avant l'insitant pourl'insere temps de reponse se augmente 
        $em->flush();
        dd($livre1);
    }
    #[Route('/admin/livres/delete/{id}', name: 'app_admin_livres_delete')]
    public function delete(EntityManagerInterface $em,Livres $livre,LivresRepository $res): Response
    {
        
        $em->remove($livre);
        $em->flush();
        //dd($livre);
        $livres=$res->findAll();
        return $this->render('livres/index.html.twig', [
            'livres' =>$livres,
        ]);

    }
    #[Route('/admin/livres/update/{id}', name: 'app_admin_livres_update')]
    public function update(EntityManagerInterface $em,Livres $livre,LivresRepository $res): Response
    {
        
        $livre->setPrix(500);
        $em->persist($livre);
        $em->flush();
        $livres=$res->findAll();
        return $this->render('livres/index.html.twig', [
            'livres' =>$livres,
        ]);

    }
    
}
