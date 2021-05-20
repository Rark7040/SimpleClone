<?php

declare(strict_types = 1);

namespace rark\simple_clone\command;

use CortexPE\Commando\{
    BaseCommand,
    args\RawStringArgument
};


final class SimpleCloneCommand extends BaseCommand{

    public function __construct(Plugin $plugin){
        parent::__construct(
            $plugin,
            'simpleclone',
            'SimpleClone Command',
            ['sc']
        );
    }

    protected function prepare():void{
        $this->setPermission('simpleclone.command.base.simpleclone');
        $this->registerSubCommand(new CreateSubCommand); //ストラクチャを作成する
        $this->registerSubCommand(new SaveSubCommand); //ストラクチャをアーカイブにする
        $this->registerSubCommand(new LoadSubCommand); //アーカイブのストラクチャをキャッシュにロードする
        $this->registerSubCommand(new UseSubCommand); //キャッシュ内にあるストラクチャをプレイヤーのクリップボードにコピーする
        $this->registerSubCommand(new PasteSubCommand); //プレイヤーのクリップボードにあるストラクチャを設置する
        $this->registerSubCommand(new ListSubCommand); //アーカイブ、もしくはキャッシュ内のストラクチャを表示する
    }

    public function onRun(CommandSender $sender, string $alias_used, array $args):void{
        if(!$sender instanceof Player){
            $sender->sendMessage(null, Language::translation('command.send.must_in_game'));
            return;
        }
    }
}