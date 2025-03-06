<?php

namespace app\logic\actions;

class CancelAction extends AbstractAction
{
    public static function getActionRealName(): string
    {
        return "Отменить";
    }
    public static function getActionInnerName(): string
    {
        return "cancel";
    }
    public static function isAvalableAction(int $userid, ?int $executorId, ?int $ownerId): bool
    {
        return $userid === $ownerId;
    }
}
