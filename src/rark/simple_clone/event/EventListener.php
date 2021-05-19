<?php

declare(strict_types = 1);

namespace rark\simple_clone\event;

use pocketmine\event\{
	Listener,
	block\BlockBreakEvent,
	block\BlockPlaceEvent,
	player\PlayerQuitEvent
};


final class EventListener implements Listener{

	public function onBreakBlock(BlockBreakEvent $event):void{
		handler\BlockBreakEventHandler::recive($event);
	}

	public function onBlockPlace(BlockPlaceEvent $event):void{
		handler\BlockPlaceEventHandler::recive($event);
	}

	public function onQuitPlayer(PlayerQuitEvent $event):void{
		handler\PlayerQuitEventHandler::recive($event);
	}
}