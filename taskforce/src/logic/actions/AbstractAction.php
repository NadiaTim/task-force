<?php

namespace app\logic\actions;

abstract class AbstractAction
{
    abstract public static function getActionRealName(): string;
    abstract public static function getActionInnerName(): string;
    abstract public static function isAvalableAction(int $userid, ?int $executorId, ?int $ownerId): bool;
}
