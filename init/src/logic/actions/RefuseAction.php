<?php

namespace TaskForce\logic\actions;

class RefuseAction extends AbstractAction
{
    public static function getActionRealName(): string
    {
        return "Отказаться";
    }
    public static function getActionInnerName(): string
    {
        return "refuse";
    }
    public static function isAvalableAction(int $userid, int $executorId, int $ownerId): bool
    {
        return $userid === $executorId;
    }
}
