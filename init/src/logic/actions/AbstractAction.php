<?php

namespace TaskForce\logic\actions;

abstract class AbstractAction
{
    abstract public static function getActionRealName();
    abstract public static function getActionInnerName();
    abstract public static function isAvalableAction(int $userid, int $executorId, int $ownerId);
}
