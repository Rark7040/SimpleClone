<?php

declare(strict_types = 1);

namespace rark\simple_clone\utils;


final class ClipStore{
	/** @var Player::getName() => Structure */
	private static array $clips = [];

	public static function set(Player $player, Structure $structure):bool{
		if(!Structure::isRegistered($structure->getName(), $structure0->getId())) return false;
		self::$clips[$player->getName()] = $structure;
		return true;
	}

	public static function remove(string $player_name):void{
		unset(self::$clips[$player_name]);
	}

	public static function get(Player $player):?Structure{
		if(self::isset(($name = $player->getName()))) return null;
		return self::$clips[$name];
	}

	public static function isset(string $player_name):bool{
		return isset(self::$clips[$player_name]);
	}
}