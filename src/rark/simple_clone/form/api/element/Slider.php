<?php

declare(strict_types = 1);

namespace rark\simple_clone\form\api\element;


class Slider extends Element{

	private string $text;
	private int $min;
	private int $max;
	private int $default;

	public function __construct(string $text, int $min, int $max, ?int $default = null){
		$default?? $default = $min;
		$this->text = $text;
		$this->min = $min;
		$this->max = $max;
		$this->default = $default;
	}

	final public function jsonSerialize(){
		return [
			'type' => 'slider',
			'text' => $this->text,
			'min' => $this->min,
			'max' => $this->max,
			'default' => $this->default;
		]
	}
}