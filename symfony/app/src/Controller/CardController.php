<?php

namespace App\Controller;

use App\Card\DeckOfCards;
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



        return $this->render('card/card.html.twig');
    }

    // card/Deck is used to create a deck of cards
    #[Route("/card/deck", name: "card_deck")]
    public function deck(SessionInterface $session): Response
    {

        // Check if session has deck, otherwise create it
        if ($session->has('deck')) {
            $deckOfCards = $session->get('deck');
        } else {
            $deckOfCards = new DeckOfCards();
        }


        // Get the deck of cards
        $deck = $deckOfCards->getDeckOfCards();

        // Set session data
        $session->set('deck', $deckOfCards);

        return $this->render("card/deckOfCards.html.twig", ["deck" => $deck]);
    }

    // card/deck/shuffle shuffles the cards
    #[Route("/card/deck/shuffle", name: "card_shuffle")]
    public function shuffle(SessionInterface $session): Response
    {

        // Check if session has deck, otherwise create the deck
        if (!$session->has('deck')) {
            $deck = new DeckOfCards();
        } else {
            $deck = $session->get('deck');
        }

        // Shuffle the deck
        $deck->shuffleCards();

        // Set session data after shuffling
        $session->set('deck', $deck);

        // Redirect to deck of cards
        return $this->redirectToRoute('card_deck');
    }

    /**
     *  The card/deck/draw route is used to draw a card from the deck
     */

    #[Route("/card/deck/draw/{number}", name: "card_draw")]
    public function draw(SessionInterface $session, int $number = 1): Response
    {

        // Get the number to draw from the URL


        // Check if session has deck, otherwise create the deck
        if (!$session->has('deck')) {
            $deck = new DeckOfCards();
        } else {
            $deck = $session->get('deck');
        }

        // Get the card
        $cards = $deck->getCard($number);

        // Set session data after drawing a card
        $session->set('deck', $deck);


        // Render draw_card
        return $this->render('card/draw_card.html.twig', ['cards' => $cards[0],
            'countOfCards' => $cards[1]]);
    }


}
