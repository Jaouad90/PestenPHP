<?php

spl_autoload_register(function($class) {
    require_once($class.'.php');
});

$dealer = new Dealer();
$waste = new Waste($dealer);

$dealer->createDeck();

$playerList = [];
$playerList[] = new Player('Alice', $dealer->shareCardsToPlayer());
$playerList[] = new Player('Bob', $dealer->shareCardsToPlayer());
$playerList[] = new Player('Carol', $dealer->shareCardsToPlayer());
$playerList[] = new Player('Eve', $dealer->shareCardsToPlayer());

echo "Starting game with ".$playerList[0]->getName().", ".$playerList[1]->getName().", ".$playerList[2]->getName().", ".$playerList[3]->getName()."\n";

foreach($playerList as $player) {
    echo $player;
}

echo "Top card is: ".$dealer->convertSymbolEncoding($waste->putFirstCardOnTable($dealer)["Card"]["Symbol"]).$waste->putFirstCardOnTable($dealer)["Card"]["Value"]."\n";

// Players take turns discarding a card to a central discard pile (same color or same value).
$i = 0;
while( $i < 200) {
    $playerState = [];
    $playerState[] .= $waste->playCardIfPossible($playerList[0]);
    $playerState[] .= $waste->playCardIfPossible($playerList[1]);
    $playerState[] .= $waste->playCardIfPossible($playerList[2]);
    $playerState[] .= $waste->playCardIfPossible($playerList[3]);

    foreach($playerState as $key=>$player) {
        if(strpos($player, "won") !== false){
            $last_word_start = strrpos($player, ' ') + 1;
            $lastCard = substr($player, $last_word_start);
            echo $playerList[$key]->getName()." plays ".$lastCard."\n".$playerList[$key]->getName()." has won."."\n";
            exit();
        }

        if($playerList[$key] !== false) {
            echo $playerState[$key];
        }
        else {
            echo "\n Dealer has no cards!! \n";
        }
    }

    if($playerState[0] == false && $playerState[1] == false && $playerState[2] == false && $playerState[3] == false) {
        echo "\n All players run out for play options!! \n";
        $i = 200;
    }

}
