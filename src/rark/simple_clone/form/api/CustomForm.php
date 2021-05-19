<?php

declare(strict_types = 1);

namespace rark\simple_clone\form\api;

use pocketmine\Player;
use rark\simple_clone\form\api\element\{
	DropDown,
	Input,
	Label,
	Slider,
	StepSlider,
	Toggle
};


class CustomForm extends BaseForm{

	public const FORM_TYPE = 'custom_form';

	public function addDropDown(DropDown $dropdown):void{
		$this->addElement($dropdown);
	}

	public function addInput(Input $input):void{
		$this->addElement($input);
	}

	public function addLabel(Label $label):void{
		$this->addElement($label);
	}

	public function addSlider(Slider $slider):void{
		$this->addElement($slider);
	}

	public function addStepSlider(StepSlider $stepslider):void{
		$this->addElement($stepslider);
	}

	public function addToggle(Toggle $toggle){
		$this->addElement($toggle);
	}

	final public function handleResponce(Player $player, $data):void{
		if($data === null){
			if($this->getCancelled() !== null) $this->getCancelled()($player);
			return;
		}
		if(count(($this->getElements()) !== count($data))) throw new \ErrorException('エレメントが破損してます');
		if($this->getSibmit() !== null) !$this->getSubmit()($player, $data);
		$i = 0;

		foreach($this->getElements() as $element){
			$element->onSubmit($player, $data[$i]);
			++$i;
		}
	}
}