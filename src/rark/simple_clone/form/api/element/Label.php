<?php

declare(strict_types = 1);

namespace rark\simple_clone\form\api\element;


class Label extends Element{

	private string $text;

	public function __construct(string $text = ''){
		$this->text = $text;
		parent::__construct();
	}

	final public function jsonSerialize(){
		return [
			'type' => 'label',
			'text' => $this->text
		];
	}
}