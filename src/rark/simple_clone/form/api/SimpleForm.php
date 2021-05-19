<?php

declare(strict_types = 1);

namespace rark\simple_clone\form\api;

use pocketmine\Player;


class SimpleForm extends BaseForm{

	public const FORM_TYPE = 'form';
	public string $text = '';

	final public function addButton(Button ...$buttons):void{
		$this->addElement(...$buttons);
	}

	final public function onSubmit(Player $player, $data):void{
		if(!is_int($data)){
			if($this->getCancelled() !== null) $this->getCancelled()($player);
			return;
		}
		if(!($result = isset($this->getElements()[$data]))) throw new \ErrorException('エレメントが破損してます');
		if($this->getSubmit() !== null)$this->getSubmit()($player, $data);
		if($result) $this->getElements()[$data]($player, $data);
	}
}