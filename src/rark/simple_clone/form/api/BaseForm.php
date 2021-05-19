<?php

declare(strict_types = 1);

namespace rark\simple_clone\form\api;

use pocketmine\{
	Player,
	form\Form
};
use rark\simple_clone\form\api\element\Element;


abstract class BaseForm implements Form{

	public const FORM_TYPE = 'unknown';

	public string $title = 'form.name.unknown';
	private array $content = [];
	private array $elements = [];
	/** @var callable|null */
	private $submit;
	private $cancelled;

	public function __construct(?callable $submit = null, ?callable $cancelled = null){
		$this->func = $submit;
		$this->cancelled = $cancelled;
	}

	final protected function addElement(Element ...$elements):void{
		foreach($elements as $element){
			$this->elements[] = $element;
			$this->content[] = json_encode($element);
		}
	}

	final public function jsonSerialize(){
		return array_merge(
			[
				'type' => static::FORM_TYPE,
				'title' => $this->title,
			],
			$this->content
		);
	}

	final public function getSibmit():?callable{
		return $this->submit;
	}

	final public function getCendelled():?callable{
		return $this->cancelled;
	}

	final public function getElements():array{
		return $this->elements;
	}
}