<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardGraphic;

// This class constructs an entire deck of cards with colors, suites and numbers
class DeckOfCards
{
    // The deck of cards as an array
    private $deckOfCards = [];

    // The suits of the deck of cards
    private $suits = ["Clubs", "Diamonds", "Hearts", "Spades"];

    // The values of the deck of cards
    private $values = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];


    // Constructor
    public function __construct()
    {
        $this->deckOfCards = $this->createDeckOfCards();
    }

    // Create a deck of cards
    private function createDeckOfCards(): array
    {




        // Placeholder for deck of cards
        $deckOfCards = [];

        // Loop through suits and values to create a deck of cards
        foreach ($this->suits as $suit) {
            foreach ($this->values as $value) {


                // PlaceHolder for color
                $cardColor = null;

                // Switch statement to determine color of card
                switch ($suit) {
                    case 'Clubs':
                        $cardColor = 'black';
                        break;
                    case 'Spades':
                        $cardColor = 'black';
                        break;
                    case 'Diamonds':
                        $cardColor = 'red';
                        // no break
                    case 'Hearts':
                        $cardColor = 'red';
                        break;
                };

                // Get a random number between 0 and 1 to decide if the card is graphic or not
                $randomNumber = rand(0, 1);


                $card = $randomNumber == 0 ? new Card($value, $suit, $cardColor) : new CardGraphic($value, $suit, $cardColor);


                $deckOfCards[] = $card;
            }
        }


        return $deckOfCards;
    }

    // Get the deck of cards
    public function getDeckOfCards(): array
    {
        return $this->deckOfCards;
    }

    // Get the number of cards in the deck
    public function getNumberOfCards(): int
    {
        return count($this->deckOfCards);
    }

    // Get a card from the deck
    public function getCard($number = 1)
    {

        // Array to hold the cards
        $cards = [];

        // Loop through the number of cards to draw
        for ($i = 0; $i < $number; $i++) {

            // Get the number of cards
            $countOfCards = $this->getNumberOfCards();

            // Get a random index
            $index = rand(0, $countOfCards - 1);

            // Get the card if index is valid otherwise return null
            $card = $index >= 0 && $index < $countOfCards ? $this->deckOfCards[$index] : null;

            // Remove the card from the deck if index is valid
            if ($index >= 0 && $index < $countOfCards) {
                array_splice($this->deckOfCards, $index, 1);
            }

            // Push the card to the cards array
            $cards[] = $card;
        }


        // Return card and remaining number of cards
        return [$cards, $this->getNumberOfCards()];
    }

    // Shuffle cards
    public function shuffleCards(): void
    {

        // Create a new set of cards
        $this->deckOfCards = $this->createDeckOfCards();

        // Shuffle the cards
        shuffle($this->deckOfCards);
    }
}
