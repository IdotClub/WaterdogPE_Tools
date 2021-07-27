<?php


namespace blackjack200\wdpe\player;


use blackjack200\wdpe\WaterdogInterface;
use blackjack200\wdpe\WaterdogPlayerTrait;
use pocketmine\player\Player;

class PMPlayer extends Player implements WaterdogInterface {
	use WaterdogPlayerTrait;
}