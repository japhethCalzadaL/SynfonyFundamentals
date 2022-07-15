<?php

namespace App\Controller;

use App\Form\CommentType; 
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(
        EntityManagerInterface $entityManager, 
        Request $request): Response
    {
        $form = $this->createForm(CommentType::class); 
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid()){
            $entityManager->persist($form->getData()); 
            $entityManager->flush(); 
            
            return $this->redirectToRoute('home');
        }
        //return new Response( 'Welcome, pagina home '.$search) ; 
        return $this->render('home.html.twig',
            [
                "comments" => $entityManager->getRepository(Comment::class)->findAll(),
                'form'=> $form->createView()
            ]
        );
    }
}
