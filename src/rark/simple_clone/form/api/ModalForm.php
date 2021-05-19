<?php

declare(strict_types = 1);

namespace rark\simple_clone\form\api;

use pocketmine\Player;


class ModalForm extends BaseForm{

	public const FORM_TYPE = 'modal';
	public string $text = '';

	final public function addButton(Button $button1, Button $button2):void{
		$this->addElement($button1, $button2);
	}

	final public function onSubmit(Player $player, $data):bool{
		if(!is_bool($data)) return false;
		if($this->func !== null)($this->func)($player, $data);
		return true;
	}

	final public function handleResponce(Player $player, $data):void{
		if(!is_bool($data)){
			if($this->getCendelled() !== null) $this->getCancelled()($player);
			return;
		}
		if(!isset($elements[0]) or !isset($elements[1])) throw new \ErrorException('エレメントが破損してます');
		if($this->getSubmit() !== null) $this->getSibmit()($player, $data);
		$elements = $this->getElements();
		$data? $elements[0]: $elements[1];
	}
}