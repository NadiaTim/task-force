<?php

namespace app\logic\actions;

class CompletedAction extends AbstractAction
{
    public static function getActionRealName(): string
    {
        return "Выполнено";
    }
    public static function getActionInnerName(): string
    {
        return "completed";
    }
    public static function isAvalableAction(int $userid, ?int $executorId, ?int $ownerId): bool
    {
        return $userid === $ownerId;
    }
}
