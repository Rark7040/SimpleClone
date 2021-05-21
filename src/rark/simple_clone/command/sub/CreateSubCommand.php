<?php

declare(strict_types = 1);

namespace rark\simple_clone\command\sub;

final class CreateSubCommand extends BaseSubCommand{

	public function __construct(){
		parent::__construct(
			'create',
			LanguageHolder::translation('command.description.sub.create');
			['c']
		);
	}

	public function prepare():void{
		$this->registerArgument(0, new RawStringArgument('structure_name'));
		$this->registerArgument(0, new RawStringArgument('invalid'));
	}

	public function onRun(CommandSender $sender, string $command, array $args):void{

	}
}