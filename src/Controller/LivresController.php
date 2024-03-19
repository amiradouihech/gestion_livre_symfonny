<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        
        return $this->render('livres/show.html.twig', [
            'livre' =>$livre,
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
        $em->persist($livre1);//preparire un obje pourl'insere
        $em->flush();
        dd($livre1);
    }
    #[Route('/admin/livres/delete/{id}', name: 'app_admin_livres_delete')]
    public function delete(EntityManagerInterface $em,Livres $livre): Response
    {
        $livre=$rep->find($id);
        $em->remove($livre);
        $em->flush();
        dd($livre);

    }
    ///créer uneméthode qui permet en connaissant id du livre  de modifier son prix et je faire les lin 
}
