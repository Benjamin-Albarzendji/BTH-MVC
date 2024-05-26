<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardControllerJSON extends AbstractController
{
    /**
     * GET api/deck/
     */

    #[Route("/api/deck/", name: "jsonDeck", methods: ['GET'])]
    public function jsonDeck(SessionInterface $session): Response
    {

        // Check if the session has a deck of cards
        if ($session->has('deck')) {
            $deck = $session->get('deck');
        } else {
            $deck = new DeckOfCards();
            $session->set('deck', $deck);
        }

        // Get the deck of cards
        $deckOfCards = $deck->getDeckOfCards();

        // Data array
        $data = [];

        // Loop through the deck of cards and add to the data array
        foreach ($deckOfCards as $card) {
            $data[] = [
                "Suit" => $card->getCardSuit(), "Value" => $card->getCardValue(), "Color" => $card->getCardColor()
            ];
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    /**
     * POST api/deck/shuffle
     */

    #[Route("/api/deck/shuffle", name: "jsonShuffle", methods: ['POST'])]
    public function jsonShuffle(SessionInterface $session): Response
    {
        // Check if the session has a deck of cards
        if ($session->has('deck')) {
            $deck = $session->get('deck');
        } else {
            $deck = new DeckOfCards();
            $session->set('deck', $deck);
        }

        // Shuffle the deck of cards
        $deck->shuffleCards();

        $session->set('deck', $deck);

        // Redirect to api/deck/
        return $this->redirectToRoute('jsonDeck');
    }

    /**
     * POST api/deck/draw
     */

    #[Route("/api/deck/draw/{number}", name: "jsonDraw", methods: ['POST'])]
    public function jsonDraw(SessionInterface $session, $number = 1): Response
    {

        // Get POST variable number
        $number = $_POST['number'];

        // Check if the session has a deck of cards
        if ($session->has('deck')) {
            $deck = $session->get('deck');
        } else {
            $deck = new DeckOfCards();
            $session->set('deck', $deck);
        }

        // Draw a card from the deck
        $cards = $deck->getCard($number);


        // Data array
        $data = [
            "Remaining Cards" => $cards[1]

        ];

        // Loop through the deck of cards and add to the data array
        foreach ($cards[0] as $card) {
            if ($card != null) {
                $data[] = [

                    "Suit" => $card->getCardSuit(), "Value" => $card->getCardValue(), "Color" => $card->getCardColor()

                ];
            }
        }


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
