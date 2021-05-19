<?php

declare(strict_types = 1);

namespace rarl\simple_clone\utils;

use pocketmine\Player;


trait CreatingStructurePool{
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

	protected static function register(Player $player, string $structure_name):bool{
		$structure = new Structure($structure_name);
		$structure->init();

		if(!$structure->canUse()) return false;
		self::$data_holder[$player->getName()] = [$structure, false];
		return true;
	}

	/**
	 * Structureにvector3を格納させます。 v2を格納した場合はStructureのインスタンスを返します
	 */
	protected static function set(Player $player, Vector3 $v, bool $bool):?Structure{
		$dat = self::$data_holder[$player->getName()];
		if($dat[1]){
			$dat[0]->resize(null, $v);

			if(!Structure::register($dat[0])) throw new \ErrorException('invalid structure instance');
			return $dat[0];
		}
		$dat[0]->resize($v);
		return null;
	}

	/**
	 * 指定した名前のプレイヤーデータをdata_holderから削除します
	 */
	protected static function cancel(string $player_name):void{
		unset(self::$data_holder[$player_name]);
	}
}