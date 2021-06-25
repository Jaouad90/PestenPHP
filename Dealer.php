<?php

class Dealer {

    private $newDeck = [];

    // Creeren van 52 kaarten A, 2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K (13kaarten x 4symbolen)
    function createDeck() {
        // TODO: Als hiervan een array wordt gemaakt dan kan er minder code gebruikt worden.
        $heart = '&#9829;';
        $spade = '&#9824;';
        $diamond = '&#9830;';
        $club = '&#9827;';
        $mockDeck = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];

        for($y = 0; $y < 4;) {
            foreach($mockDeck as $item) {
                    if($y == 0) {
                        $this->newDeck[] = ["Card"=>["Value"=>$item, "Symbol"=>$heart]];
                    }
                    if($y == 1) {
                        $this->newDeck[] = ["Card"=>["Value"=>$item, "Symbol"=>$spade]];
                    }
                    if($y == 2) {
                        $this->newDeck[] = ["Card"=>["Value"=>$item, "Symbol"=>$diamond]];
                    }
                    if($y == 3) {
                        $this->newDeck[] = ["Card"=>["Value"=>$item, "Symbol"=>$club]];
                    }
            }
            $y++;
        }

        $this->shuffleDeck();
    }

    function getCurrentDeck() {
        return $this->newDeck;
    }

    function shuffleDeck() {
        return shuffle($this->newDeck);
    }

    function shareCardsToPlayer() {
        // Deel 7 kaarten aan elke speler. Rest is Deelstapel
        for($y = 0; $y < 7; $y++) {
            $playerCards[] = $this->getCardFromDeckIfPossible();
        }
        return $playerCards;
    }

    function getCardFromDeckIfPossible() {
        
        // If dealer cards are empty return false
        if(empty($this->newDeck)) {
            
            return false;
        }
        return array_pop($this->newDeck);
    }

    function convertSymbolEncoding($element) {
        return mb_convert_encoding($element, 'UTF-8', 'HTML-ENTITIES');
    }
}