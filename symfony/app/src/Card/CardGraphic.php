<?php

namespace App\Card;

use App\Card\Card;

// Require the Card class
require_once("Card.php");



class CardGraphic extends Card
{
    private $cardSuit;

    // Array of Suite Graphics
    private $suitGraphics = [
        "Clubs" => "♣",
        "Diamonds" => "♦",
        "Hearts" => "♥",
        "Spades" => "♠"
    ];



    public function __construct($value, $suit, $cardColor)
    {

        // Call the parent constructor
        parent::__construct($value, $suit, $cardColor);



        $this->cardSuit = $this->suitGraphics[$suit];

    }

    public function getCardSuit(): string
    {
        return $this->cardSuit;
    }

}
