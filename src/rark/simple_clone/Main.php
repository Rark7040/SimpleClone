<?php

declare(strict_types = 1);

namespace rark\simple_clone;

use pocketmine\{
	plugin\PluginBase,
	utils\Config
};


final class Main extends PluginBase{

	private static string $dat_path;
	/** @var pocketmine\utils\Config */
	private static $conf;

	public function onEnable(){
		self::$data_path = $this->getDataFolder();
		self::$conf = new Config(self::$data_path.'config.yml', Config::YAML,[
			'default.lang' => 'ja_jp',
			'quit.refresh' => false
		]);
		$this->registerLang();
		$server = $this->getServer();
		$server->getPluginManager()->registerEvents(new event\EventListener, $this);
		$server->getCommandMap()->register('rarks SimpleClone', new SimpleCloneCommand);
	}

	public static function getDataPath():string{
		return self::$data_path;
	}

	public static function getConfig():Config{
		return self::$conf;
	}

	private function registerLang():void{
		LanguageHolder::setDefault(self::$conf->get('default.lang'));
		LanguageHolder::registerText('command.exception.send_must_in_game', 'ゲーム内で実行してください');
		LanguageHolder::registerText('command.description.sub.create', 'ストラクチャーを生成します');
		LanguageHolder::registerText('command.exception.non_structure_name', 'ストラクチャー名が必要です');
		LanguageHolder::registerText('command.success.registered_structure_pool', 'pos1とpos2を設定してください'."\n".'/sc create cancelで作成をキャンセルできます');
		LanguageHolder::registerText('command.exception.no_selected_structure', 'クリップボードにストラクチャーが存在しません');
		LanguageHolder::registerText('command.exception.invalid_structure_name', 'そのストラクチャー名は使用できません');
	}
}