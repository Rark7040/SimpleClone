<?php

declare(strict_types = 1);

namespace rark\simple_clone\command\sub;

final class CreateSubCommand extends BaseSubCommand{

	public function __construct(){
		parent::__construct(
			'create',
			LanguageHolder::translation('command.description.sub.create'),
			['c']
		);
	}

	public function prepare():void{
		$this->registerArgument(0, new RawStringArgument('structure_name'));
		$this->registerArgument(1, new RawStringArgument('invalid'));
	}

	public function onRun(CommandSender $sender, string $command, array $args):void{
		if(!$sender instanceof Player){
			$sender->sendMessage(null, LanguageHolder::translation('command.exception.send_must_in_game'));
			return;

		}elseif(!isset($args['structure_name'])){
			$sender->sendMessage(null, LanguageHolder::translation('command.exception.non_structure_name'));
			return;

		}elseif($args['structure_name'] === 'cancel'){


		}elseif(isset($args['invalid'])){
			$sender->sendMessage($sender->getLocale(), LanguageHolder::translation('command.exception.unknown_subcommand'));
			return;
		}
		CreatingStructurePool::register($sender, $args['structure_name']);
		$sender->sendMessage($sender->getLocale(), LanguageHolder::translation('command.success.registered_structure_pool'));
	}
}