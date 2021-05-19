<?php

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
}