<?php


namespace blackjack200\wdpe\player;


use blackjack200\wdpe\WaterdogInterface;
use blackjack200\wdpe\WaterdogPlayerTrait;
use prokits\player\PracticePlayer;

class PracticeCorePlayer extends PracticePlayer implements WaterdogInterface {
	use WaterdogPlayerTrait;
}