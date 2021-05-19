<?php

declare(strict_types = 1);

namespace rark\simple_clone\utils;

use pocketmine\math\Vector3;


trait Utility{

	/**
	 * v1には最小値、v2には最大値を格納し、参照渡しします
	 */
	protected static function sortVector(Vector3 &$v1, Vector3 &$v2):void{
		$v1 = $v1->asVector3();
		$v2 = $v2->asVector3();
		$dat = [
			[$v1->x, $v2->x],
			[$v1->y, $v2->y],
			[$v1->z, $v2->z]
		];
		$v1->x = min($dat[0]);
		$v2->x = max($dat[0]);
		$v1->y = min($dat[1]);
		$v2->y = max($dat[1]);
		$v1->z = min($dat[2]);
		$v2->z = max($dat[2]);
	}

	/**
	 * v1とv2の差分を返します
	 */
	protected static function getDiff(Vector3 $v1, Vector3 $v2):Vector3{
		return new Vector3($v2->x-$v1->x, $v2->y-$v1->y, $v2->z-$v1->z,);
	}

	/**
	 * Vector3を文字列にシリアライズします
	 */
	protected static function serializeVector(Vector3 $v):string{
		return $v->x.'???'.$v->y.'???'.$v->z;
	}

	/**
	 * serializeVectorで返された値を復元します
	 */
	protected static function unserializeVector(string $str):?Vector3{
		$dat = explode('???', $str);
		if(count($dat)!==3) return null;
		return new Vector3((float)$dat[0], (float)$dat[1], (float)$dat[2]);
	}
}