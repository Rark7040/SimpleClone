<?php

declare(strict_types = 1);

namespace rark\simple_clone;

use pocketmine\plugin\PluginBase;


final class Main extends PluginBase{

	public function onEnable(){
		$server = $this->getServer();
		$server->getPluginManager()->registerEvents(new event\EventListener, $this);
		$server->getCommandMap()->registerAll(
			'rarks SimpleClone',
			[

			]
		);
	}
}