<?php

declare(strict_types = 1);

namespace rark\simple_clone\event\handler;

use pocketmine\event\Event;


interface Handler{
	public static function recive(Event $event):void;
}