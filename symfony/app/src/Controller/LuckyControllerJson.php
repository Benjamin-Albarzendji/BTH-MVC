<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LuckyControllerJson extends AbstractController
{
    #[Route("/api", name: "api")]
    public function jsonNumber(): Response
    {


        $data = [
            '/api' => "This is the API endpoint",
            '/api/quote' => "Get your daily dosage of wisdom",
            "api/deck/" => "Get a deck of cards",
            "api/deck/shuffle" => "Shuffle the deck",
            "api/deck/draw" => "Draw a card from the deck",
        ];



        // Render the API template

        return $this->render("api.html.twig", ["routes" => $data]);
    }

    #[Route("/api/quote")]
    public function jsonQuote(): Response
    {
        $number = random_int(0, 3);

        $quotes = [
            "The greatest glory in living lies not in never falling, but in rising every time we fall. -Nelson Mandela",
            "The way to get started is to quit talking and begin doing. -Walt Disney",
            "Your time is limited, so don't waste it living someone else's life. -Steve Jobs",
            "If life were predictable it would cease to be life, and be without flavor. -Eleanor Roosevelt",
        ];

        // Current date
        $date = date('Y-m-d H:i:s');

        $data = [
            'quote' => $quotes[$number],
            'Time' => $date
        ];

        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
