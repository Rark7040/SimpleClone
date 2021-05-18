<?php

declare(strict_types = 1);

namespace rark\simple_clone\i18n;


class Language{
	/** @var [int => locale] */
	protected static array $langs = [];
	/** @var [string => string] */
	protected static array $use_texts = [];

	public static function register(locale $locale):void{
		foreach(self::$use_texts as $text => $default){
			if(!$locale->exists($text)) $locale->set($text, $default);
		}
		$langs[$locale->getId()] = $locale;
	}

	public static function registerText(string $text, string $default = ''):void{
		self::$use_texts[$text] = $default;
	}

	public static function getLocale(string $locale_code):locale{
		return isset(self::$langs[Locale::ID[$locale_code]])? self::$langs[Locale::ID[$locale_code]]: new Locale($locale_code);
	}

	public static function translation(string $locale_code, string $text):string{
		return isset(self::$langs[Locale::ID[$locale_code]])? self::$langs[Locale::ID[$locale_code]]->getTranslated(): $text;
	}
}