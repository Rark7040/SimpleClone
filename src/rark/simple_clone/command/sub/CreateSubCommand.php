<?php

declare(strict_types = 1);

namespace rark\simple_clone\command\sub;

final class CreateSubCommand extends BaseSubCommand{

	public function __construct(){
		parent::__construct('create', LanguageHolder::translation('command.description.sub.create'), ['c']);
	}

	protected function prepare():void{
		$this->registerArgument(0, new RawStringArgument('structure_name'));
	}

	public function onRun(CommandSender $sender, string $command, array $args):void{
		if(!$sender instanceof Player){
			$sender->sendMessage(LanguageHolder::translation(null, 'command.exception.send_must_in_game'));
			return;

		}elseif(!isset($args['structure_name'])){
			$sender->sendMessage(LanguageHolder::translation($sender->getLocale(), 'command.exception.non_structure_name'));
			return;

		}elseif($args['structure_name'] === 'cancel' or $args['structure_name'] === 'cancel'){
			$sender->sendMessage(LanguageHolder::translation($sender->getLocale(), 'command.exception.invalid_structure_name'));
			return;
		}
		CreatingStructurePool::register($sender, $args['structure_name']);
		$sender->sendMessage(LanguageHolder::translation($sender->getLocale(), 'command.success.registered_structure_pool'));
	}
}