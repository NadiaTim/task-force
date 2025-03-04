<?php

namespace TaskForce\logic\actions;

class RespondAction extends AbstractAction
{
    public static function getActionRealName(): string
    {
        return "Откликнуться";
    }
    public static function getActionInnerName(): string
    {
        return "respond";
    }
    public static function isAvalableAction(int $userid, ?int $executorId, ?int $ownerId): bool
    {
        return $userid !== $ownerId;
    }
}
