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
        $this->registerSubCommand();
    }
}