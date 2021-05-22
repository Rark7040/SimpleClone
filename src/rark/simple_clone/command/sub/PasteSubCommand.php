<?php

declare(strict_types = 1);

namespace rark\simple_clone\command\sub;

final class CreateSubCommand extends BaseSubCommand{

	public function __construct(){
		parent::__construct('paste', LanguageHolder::translation('command.description.sub.create'), ['p']);
	}

	protected function prepare():void{}

	public function onRun(CommandSender $sender, string $command, array $args):void{
		if(!$sender instanceof Player){
			$sender->sendMessage(LanguageHolder::translation(null, 'command.exception.send_must_in_game'));
			return;
		}
		$sender->sendForm(new PasteForm);
	}
}

