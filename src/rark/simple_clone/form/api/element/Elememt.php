<?php

declare(strict_types = 1);

namespace rark\simple_clone\form\api\element;

use pocketmine\{
	Player
};


abstract class Element implements \JsonSerializable{
	/** @var callable */
	private $submit;

	public function __construct(?callable $submit = null){
		$this->submit = $submit;
	}

	final public function onSubmit(Player $player, $data):void{
		if($this->submit !== null)($this->submit)($player, $data);
	}
}