<?php

declare(strict_types = 1);

namespace rarl\simple_clone\utils;

use pocketmine\Player;


final class CreatingStructurePool{
	/**
	 * プレイヤーがストラクチャを作成する際の、vector3データを保持するキャッシュです
	 * @param
	 * [
	 * 		(string)player_name => [
	 *   		Structure,
	 *     		bool //v1を登録したか
	 * 		]
	 * ]
	 */
	private static array $data_holder = [];

	public static function register(Player $player, string $structure_name):bool{
		if(!($structure = new Structure($structure_name))->canUse()) return false;
		self::$data_holder[$player->getName()] = [$structure, false];
		return true;
	}

	/**
	 * Structureにvector3を格納させます。 v2を格納した場合はStructureのインスタンスを返します
	 */
	public static function set(Player $player, Vector3 $v, bool $bool):?Structure{
		$name = $player->getName();
		$dat = self::$data_holder[$name];
		if($dat[1]){
			$dat[0]->resize(null, $v);

			if(!Structure::register($dat[0])) throw new \ErrorException('invalid structure instance');
			self::remove($name);
			return $dat[0];
		}
		$dat[0]->resize($v);
		$dat[1] = true;
		self::$data_holder[$name] = $dat;
		return null;
	}

	/**
	 * 指定した名前のプレイヤーデータをdata_holderから削除します
	 */
	public static function remove(string $player_name):void{
		unset(self::$data_holder[$player_name]);
	}

	public static function isRegistered(string $player_name):bool{
		return isset(self::$data_holder[$player_name]);
	}
}