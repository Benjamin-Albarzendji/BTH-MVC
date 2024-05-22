<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class CardController extends AbstractController
{

    // The /session route is used to print out session data to the template
    #[Route("/session", name: "session")]
    public function session(SessionInterface $session): Response
    {

    
        return $this->render('card/session.html.twig', [
            'session' => $session->all(),
        ]);
    }

    // The /session/delete route is used to delete session data
    #[Route("/session/delete", name: "session_delete")]
    public function sessionDelete(SessionInterface $session): Response
    {

        // Clear session
        $session->clear();

        // Add a flash message
        $this->addFlash('success', 'Session was cleared');

        return $this->redirectToRoute('session');
    }


    // /card is the landing page for the card game

    #[Route("/card", name: "card")]
    public function card(SessionInterface $session): Response
    {
        // Check if session data is set
        if (!$session->has('card')) {
            $session->set('card', []);
        }

        // Get session data
        $data = $session->get('card');

        // Check if session data is set
        if (!$session->has('score')) {
            $session->set('score', 0);
        }

        // Get session data
        $score = $session->get('score');

        return $this->render('card/card.html.twig', [
            'data' => $data,
            'score' => $score,
        ]);
    }

}
