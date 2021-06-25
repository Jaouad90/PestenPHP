<?php

class Player {

    private $name;
    private $playCards;
    private $dealer;

    function __construct($name, $playCards) {
        $this->name = $name;
        $this->playCards = $playCards;
        $this->dealer = new Dealer();
    }

    function getName() {
        return $this->name;
    }

    function getPlayCards() {
        return $this->playCards;
    }

    function updatePlayCards($playCards) {
        return $this->playCards = $playCards;
    }

    function __toString() {

        $playCardsString = "";
        $encodedPlaycards = $this->dealer->convertSymbolEncoding($this->getPlayCards());

        foreach($encodedPlaycards as $card) {
                $playCardsString .= $card["Card"]["Symbol"].$card["Card"]["Value"]." ";
        }
        return $this->getName()." has been dealt: ".$playCardsString."\n";
    }
}