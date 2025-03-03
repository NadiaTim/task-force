<?php

namespace TaskForce\logic;

use TaskForce\logic\actions\CancelAction;
use TaskForce\logic\actions\CompletedAction;
use TaskForce\logic\actions\RefuseAction;
use TaskForce\logic\actions\RespondAction;

class Task
{
    //определять список возможных действий и статусов
    // в виде констант все возможные 
    //статусы и 
    const STATUS_NEW = 'new';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_AT_WORK = 'at work';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    //роли
    const ROLE_CLIENT = 'client';
    const ROLE_EXECUTOR = 'executor';

    private ?int $idExecutor;
    private int $idClient;

    private $currentStatus;


    /**
     * Конструктор класса
     * @param int $idClient
     * @param string $currentStatus
     * @param int|null $idExecutor
     */
    public function __construct(int $idClient, string $currentStatus = 'new', ?int $idExecutor = null)
    {
        $this->idClient = $idClient;
        $this->setStatus($currentStatus);
        $this->idExecutor = $idExecutor;
    }

    /**
     * получаем ассоциативный масссив статусов (ключ-внутреннее имя, значение - название статуса на русском)
     * @return string[]
     */
    public function getStatusMap(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELLED => 'Отменено',
            self::STATUS_AT_WORK => 'В работе',
            self::STATUS_COMPLETED => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',
        ];
    }

    /**
     * Проверяет существует ли переданный статус среди допустимых 
     * и назначает его переменной, содержащий текущий статус
     * @param string $status
     * @return void
     */
    private function setStatus(string $status): void
    {
        $availableStatuses = [
            self::STATUS_NEW,
            self::STATUS_CANCELLED,
            self::STATUS_AT_WORK,
            self::STATUS_COMPLETED,
            self::STATUS_FAILED
        ];
        if (in_array($status, $availableStatuses)) {
            $this->currentStatus = $status;
        }
    }

    public function getAvalableAction(string $role, int $id)
    {
        //
        $statusActions = $this->availableActionOfStatus($this->currentStatus);
        $roleActions = $this->availableActionOfRole($role);
        $allowedActions = array_intersect($statusActions, $roleActions);
        $allowedActions = array_filter($allowedActions, function ($action) use ($id) {
            return $action::isAvalableAction($id, $this->idExecutor, $this->idClient);
        });

        return array_values($allowedActions);
    }

    /**
     * получаем следующий статус в соответствии с переданным действием
     * @param string $action абсолютное имя класса из пространства имен 
     * (Например для CancelAction::class - TaskForce\logic\actions\CancelAction)
     * @return string|null
     */
    public function getNextStatus(string $action): ?string
    {
        $map = [
            CancelAction::class => self::STATUS_CANCELLED,
            RespondAction::class => self::STATUS_AT_WORK,
            CompletedAction::class => self::STATUS_COMPLETED,
            RefuseAction::class => self::STATUS_FAILED
        ];

        return $map[$action] ?? null;
    }

    /**
     * определяет список доступных действий для указанного статуса
     * @param string $status
     * @return array
     */
    private function availableActionOfStatus(string $status): array
    {
        $map = [
            self::STATUS_NEW => [
                CancelAction::class,
                RespondAction::class
            ],
            self::STATUS_AT_WORK => [
                CompletedAction::class,
                RefuseAction::class
            ]
        ];

        return $map[$status] ?? [];
    }

    /**
     * определяет список доступных действий для указанной роли
     * @param string $role
     * @return array
     */
    private function availableActionOfRole(string $role): array
    {
        $map = [
            self::ROLE_CLIENT => [
                CancelAction::class,
                CompletedAction::class
            ],
            self::ROLE_EXECUTOR => [
                RespondAction::class,
                RefuseAction::class
            ]
        ];

        return $map[$role] ?? [];
    }
}
