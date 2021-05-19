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
	}

	public function onBlockPlace(BlockPlaceEvent $event):void{
	}

	public function onQuitPlayer(PlayerQuitEvent $event):void{
	}
}