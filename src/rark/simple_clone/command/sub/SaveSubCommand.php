<?php

declare(strict_types = 1);

final class SaveSubCommand extends BaseSubCommand{

	public function __construct(){
		parent::__construct('save', LanguageHolder::translation(null, 'command.description.sub.save'), ['s']);
	}

	protected function prepare():void{}

	public function onRun(CommandSender $sender, string $command, array $args):void{
		if(!$sender instanceof Player){
			$sender->sendMessage(LanguageHolder::translation(null, 'command.exception.send_must_in_game'));
			return;
		}
		$name = $sender->getName();

		if(!ClipStore::isset($name)){
			$sender->sendMessage(LanguageHolder::translation($sender->getLocale(), 'command.exception.no_selected_structure'));
			return;
		}
		(ClipStore::get($name))->save();
		$sender->sendMessage(LanguageHolder::translation($sender->getLocale(), 'save.success'));
	}
}