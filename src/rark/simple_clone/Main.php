<?php

declare(strict_types = 1);

namespace rark\simple_clone;

use pocketmine\{
	plugin\PluginBase,
	utils\Config
};


final class Main extends PluginBase{

	private static string $dat_path;
	/** @var pocketmine\utils\Config */
	private static $conf;

	public function onEnable(){
		self::$data_path = $this->getDataFolder();
		self::$conf = new Config(
			self::$data_path.'config.yml',
			Config::YAML,
			[
				'quit.refresh' => false
			]
		);
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

	public static function getConfig():Config{
		return self::$conf;
	}
}