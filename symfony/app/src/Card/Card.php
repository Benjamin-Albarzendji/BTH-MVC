<?php

namespace App\Card;

class Card
{
    private $cardValue;
    private $cardSuit;
    private $cardColor;


    public function __construct($cardValue, $cardSuit, $cardColor)
    {
        $this->cardValue = $cardValue;
        $this->cardSuit = $cardSuit;
        $this->cardColor = $cardColor;
    }

    public function getCardValue(): string
    {
        return $this->cardValue;
    }

    public function getCardSuit(): string
    {
        return $this->cardSuit;
    }

    public function getCardColor(): string
    {
        return $this->cardColor;
    }
}
