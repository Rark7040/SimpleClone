<?php

declare(strict_types = 1);

namespace rark\simple_clone\i18n;


class LanguageHolder{
	/** @var [int => locale] */
	protected static array $langs = [];
	/** @var [string => string] */
	protected static array $use_texts = [];
	protected static string $default;

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
	public static function translation(?string $locale_code, string $text):string{
		$locale_code?? $locale_code = self::$default;
		if(isset(self::$langs[Locale::ID[$locale_code]])){
			return self::$langs[Locale::ID[$locale_code]]->getTranslated();

		} self::$langs[Locale::ID[$locale_code]]->getTranslated(): $text;
	}

	public static function setDefault(string $locale_code):void{
		if(!isset(Locale::ID[$locale_code])) throw new \ErrorException('invaliid locale code');
		self::$default = $locale_code;
	}

	public static function save():void{
		foreach(self::$langs as $locale){
			$locale->save();
		}
	}
}