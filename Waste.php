<?php

class Waste {
    
    private $currentCard;
    private $dealer;
    private $newCard;

    function __construct($dealer) {
        $this->dealer = $dealer;
    }

    // Neem een kaart van de deelstapel, als eerste kaart voor op centrale aflegstapel
    function putFirstCardOnTable() {

        return $this->currentCard = $this->dealer->getCardFromDeckIfPossible();
    }

    // Als een speler niet kan, neemt de speler een kaart van de deelstapel.
    function playerTakesCard($player) {
        $this->newCard = $this->dealer->getCardFromDeckIfPossible();
        if($this->newCard == false) {
            return false;
        }
        $playerCards = $player->getPlayCards();
        $playerCards[] = $this->newCard;
        
        return $playerCards;
    }



    // Discarding a player card to a central discard pile (same color or same value).
    function playCardIfPossible($player) {

        $playerHand = $player->getPlayCards();

            if(empty($playerHand) !== true) {
                // Goes through all the cards of the specific player
                foreach($playerHand as $key=>$playerCard) {
                    //  Checks if card Value or Symbol of player is the same as the one on the table
                    if($playerCard['Card']['Value'] === $this->currentCard['Card']['Value'] ||  $playerCard['Card']['Symbol'] === $this->currentCard['Card']['Symbol']) {
                        
                        // Encoding symbols so they can be shown
                        $symbol = $this->dealer->convertSymbolEncoding($playerCard['Card']['Symbol']);
                        $value = $playerCard['Card']['Value'];

                        // The player card thats been accepted is now put on the table
                        $this->currentCard = $playerCard;

                        // Remove the card from players hand because its on table
                        unset($playerHand[$key]);
                        $player->updatePlayCards($playerHand);

                        // If a player has a last card remaining
                        if(count($playerHand) == 1) {
                            return $player->getName()." plays ".$symbol.$value."\n".$player->getName()." has 1 card remaining!"."\n";
                        }

                        // If player has no cards then he won.
                        if(empty($playerHand) == true) {
                            return "won ".$symbol.$value;
                        } 

                        return $player->getName()." plays ".$symbol.$value."\n";
                    }
                }
            }

        // If there's no card to play and available to take then next player
        if($this->playerTakesCard($player) == false) {
        
            return false;
        }
        $player->updatePlayCards($this->playerTakesCard($player));

        return $player->getName()." does not have a suitable card, taking from deck ".$this->dealer->convertSymbolEncoding($this->newCard['Card']['Symbol']).$this->newCard['Card']['Value']."\n";
    }

}