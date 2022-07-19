<?php


namespace blackjack200\wdpe;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use prokits\player\PracticePlayer;

class ExtendedWaterdogTransferCommand extends Command {
	public function __construct() {
		parent::__construct('wdselftransfer', 'WaterdogPE transfer', '/wdtransfer <server>');
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if ($sender instanceof PracticePlayer && count($args) >= 1) {
			Tools::connectProxyServer($sender, $args[0]);
		}
	}
}