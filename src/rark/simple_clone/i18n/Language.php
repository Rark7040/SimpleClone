<?php

declare(strict_types = 1);

namespace rark\simple_clone\i18n;


class Language{
	/** @var [int => locale] */
	protected static array $langs = [];
	/** @var [string => string] */
	protected static array $use_texts = [];

	/** このクラスに登録されているテキストをlocaleに登録し、そのlocaleをこのクラスに登録します */
	public static function register(locale $locale):void{
		foreach(self::$use_texts as $text => $default){
			if(!$locale->exists($text)) $locale->set($text, $default);
		}
		$langs[$locale->getId()] = $locale;
	}

	/** プラグイン内で使用するテキストと、そのデフォルト値を登録します */
	public static function registerText(string $text, string $default = ''):void{
		self::$use_texts[$text] = $default;
	}

	/** 登録済みのlocaleインスタンスを返します */
	public static function getLocale(string $locale_code):locale{
		return isset(self::$langs[Locale::ID[$locale_code]])? self::$langs[Locale::ID[$locale_code]]: null;
	}

	/** 指定したlocale_codeでtextを翻訳します */
	public static function translation(string $locale_code, string $text):string{
		return isset(self::$langs[Locale::ID[$locale_code]])? self::$langs[Locale::ID[$locale_code]]->getTranslated(): $text;
	}
}