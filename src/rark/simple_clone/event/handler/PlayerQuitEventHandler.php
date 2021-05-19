<?php

declare(strict_types = 1);

namespace rark\simple_clone\event\handler;

use pocketmine\event\{
	Event,
	player\PlayerQuitEvent
};
use rark\simple_clone\{
	Main,
	utils\Structure
};


final class PlayerQuitEventHandler implements Handler{

	public static function recive(Event $event):void{
		if(!$event instanceof PlayerQuitEvent) return;
		if(!Main::getConfig()->get('quit.refresh')) return;
		Structure::refreshHistoryCash($event->getPlayer()->getName());
	}
}