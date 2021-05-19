<?php

declare(strict_types = 1);

namespace rark\simple_clone\form\api\element;


class DropDown extends Element{

	private string $text;
	private int $default;
	private array $options;

	public function __construct(tring $text = '', ?callable $submit = null, int $default = 0, string ...$options){
		if($default < count($options)-1) throw new \ErrorException('デフォルトの値が大きすぎます');
		$this->text = $text;
		$this->default = $default;
		$this->options = $options;
		parent::__construct($submit);
	}

	final public function jsonSerialize(){
		return [
			'type' => 'dropdown',
			'text' => $this->text,
			'options' => $this->options,
			'default' => $this->default
		];
	}
}