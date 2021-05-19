<?php

declare(strict_types = 1);

namespace rark\simple_clone\i18n;

use pocketmine\utils\Config;


class Locale extends Config implements LocaleIds{
	protected int $id;
	/** @var string[]*/
	protected array $lang = [];
	/** @var pocketmine\utils\Config */
	protected $conf;

	/** 言語コードからインスタンスを生成します */
	public function __construct(string $locale_code){
		if(isset(self::ID[$locale_code])) throw new \ErrorException('invalid locale id');
		$this->id = self::ID[$locale_code];
		$this->conf = new Config(Main::getDataPath().'lang/'.$locale_code.'.yml', Config::YAML);
	}

	public function getId():int{
		return $this->id;
	}

	/** textを翻訳したものを返します */
	public function getTranslated(string $text):string{
		return $this->conf->exists($text)? $this->conf->get($text); $text;
	}
}