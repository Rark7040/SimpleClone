<?php

declare(strict_types = 1);

namespace rark\simple_clone\form\api\element;


class Input extends Element{

	private string $text;
	private string $placeholder;
	private string $default;

	public function __construct(string $text = '', string $placeholder = '', string $default = '', ?callable $submit = null){
		$this->text = $text;
		$this->placeholder = $placeholder;
		$this->default = $default;
		parent::__construct($submit);
	}

	final public function jsonSerialize(){
		return [
			'type' => 'input',
			'text' => $this->text,
			'placeholder' => $this->placeholder,
			'default' => $this->default
		];
	}
}