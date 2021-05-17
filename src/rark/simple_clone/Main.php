<?php

declare(strict_types = 1);

namespace rark\simple_clone;

use pocketmine\plugin\PluginBase;


final class Main extends PluginBase{

	private static string $dat_path;

	public function onEnable(){
		self::$data_path = $this->getDataFolder();
		$server = $this->getServer();
		$server->getPluginManager()->registerEvents(new event\EventListener, $this);
		$server->getCommandMap()->registerAll(
			'rarks SimpleClone',
			[

			]
		);
	}

	public static function getDataPath():string{
		return self::$data_path;
	}
}