<?php

declare(strict_types = 1);

namespace rark\simple_clone\form\api\element;


class Button extends Element{

	private string $text;
	/** @var ButtonImage|null */
	private array $image;

	public function __construct(string $text = '', ?callable $submit = null, ?ButtonImage $image = null){
		$this->text = $text;
		$this->image = $image === null? null: json_encode($image);
		parent::__construct($submit);
	}

	public function jsonSerialize(){
		return array_merge(
			['text' => $this->text],
			$image === null? []: $this->image
		);
	}
}