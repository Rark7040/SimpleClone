<?php

declare(strict_types = 1);

final class LoadSubCommand extends BaseSubCommand{

	public function __construct(){
		parent::__construct('load', LanguageHolder::translation(null, 'command.description.sub.load'), ['l']);
	}

	protected function prepare():void{
		$this->registerArgument(0, new RawStringArgument('file'));
	}

	public function onRun(CommandSender $sender, string $command, array $args):void{
		if(!$sender instanceof Player){
			$sender->sendMessage(LanguageHolder::translation(null, 'command.exception.send_must_in_game'));
			return;
		}

		if(isset($args['file'])){
			$structure = new Structure;

			if($structure->load($args['file'])){
				Structure::register($structure);

				if(ClipStore::set($sender, $structure)){
					$sender->sendMessage(LanguageHolder::translation($sender->getLocale(), 'structure.load.success'));
					return;
				}
			}
			$sender->sendMessage(LanguageHolder::translation($sender->getLocale(), 'structure.load.failed'));
		}else{
			$sender->sendForm(new LoadForm);
		}
	}
}