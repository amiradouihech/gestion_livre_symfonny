<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\OrderItem;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanigerController extends AbstractController
{
    #[Route('/panigner', name: 'app_paniger')]
    public function index(SessionInterface $session,LivresRepository $LivresRepository): Response
    {
        $panier=$session->get('panier',[]);


        $panierWithData=[];
        foreach($panier as $id=>$qte){
            $panierWithData[]=[
                'livre'=>$LivresRepository->find($id),
                 'quantite'=>$qte         ];
        }
        $total=0;
        foreach($panierWithData as $item){
            $totalItem=$item['livre']->getPrix()*$item['quantite'];
            $total+=$totalItem;
        }
        return $this->render('paniger/index.html.twig', [
            'items'=>$panierWithData,
            'total'=>$total
        ]);
    }
    #[Route("/panigner/add/{id}",name:'app_paniger_add')]
    public function add($id,SessionInterface $session){
 
        $panier=$session->get('panier',[]);
        if(!empty($panier[$id])){
            $panier[$id]++;
        }
        else{
            $panier[$id]=1;
        }
       
        $session->set('panier',$panier);
        return $this->redirectToRoute("app_paniger");
    }
    #[Route("/panigner/remove/{id}",name:'app_paniger_remove')]
    public function remove($id,SessionInterface $session){
        $panier=$session->get('panier',[]);
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute("app_paniger");
    }
    #[Route('/panigner/increment/{id}', name: 'app_paniger_increment')]
public function increment($id, SessionInterface $session): Response
{
    $panier = $session->get('panier', []);
    if (!empty($panier[$id])) {
        $panier[$id]++;
    }
    $session->set('panier', $panier);
    return $this->redirectToRoute('app_paniger');
}

#[Route('/panigner/decrement/{id}', name: 'app_paniger_decrement')]
public function decrement($id, SessionInterface $session): Response
{
    $panier = $session->get('panier', []);
    if (!empty($panier[$id])) {
        if ($panier[$id] > 1) {
            $panier[$id]--;
        } else {
            unset($panier[$id]);
        }
    }
    $session->set('panier', $panier);
    return $this->redirectToRoute('app_paniger');
}

#[Route('/panigner/checkout', name: 'app_panigner_checkout')]
public function checkout(Request $request, SessionInterface $session, LivresRepository $livresRepository, EntityManagerInterface $entityManager): Response
{
    $panier = $session->get('panier', []);

    if (empty($panier)) {
        return $this->redirectToRoute('app_panigner');
    }

    $order = new Order();
    $form = $this->createForm(OrderType::class, $order); // Ensure OrderType is correctly referenced

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $total = 0;
        foreach ($panier as $id => $quantite) {
            $livre = $livresRepository->find($id);

            if (!$livre) {
                continue;
            }

            $orderItem = new OrderItem();
            $orderItem->setBookTitle($livre->getTitre());
            $orderItem->setBookPrice($livre->getPrix());
            $orderItem->setQuantity($quantite);
            $orderItem->setTotal($livre->getPrix() * $quantite);
            $orderItem->setOrder($order);

            $total += $orderItem->getTotal();

            $entityManager->persist($orderItem);
        }

        $order->setTotal($total);
        $order->setUser($this->getUser()); // Associate the order with the logged-in user
        $entityManager->persist($order);
        $entityManager->flush();

        // Clear the cart
        $session->remove('panier');

        return $this->redirectToRoute('app_paniger');
    }

    return $this->render('paniger/checkout.html.twig', [
        'form' => $form->createView(),
    ]);
}

}