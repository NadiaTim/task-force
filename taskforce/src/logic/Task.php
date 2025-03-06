<?php

namespace app\logic;

use app\exceptions\ExistenceException;
use app\logic\actions\AbstractAction;
use app\logic\actions\CancelAction;
use app\logic\actions\CompletedAction;
use app\logic\actions\RefuseAction;
use app\logic\actions\RespondAction;


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
     * @throws ExistenceException
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
        if (!in_array($status, $availableStatuses)) {
            throw new ExistenceException("Неизвесный статус $status");
        }
        $this->currentStatus = $status;
    }

    private function checkRole(string $role): void
    {
        $availableRoles = [
            self::ROLE_CLIENT,
            self::ROLE_EXECUTOR
        ];
        if (!in_array($role, $availableRoles)) {
            throw new ExistenceException("Неизвестная роль $role");
        }
    }

    /**
     * Выводит список допустимых действий для текущего пользователя
     * В соответствии с актуальным статусом задания, роли пользователя и владения задания
     * @param string $role Одна из допустимых ролей
     * @param int $id  Идентификатор текущего пользователя из системы
     * @return array Массив допустимых дейчтвий в виде адреса используемого класса из namespace
     * @throws ExistenceException
     */
    public function getAvalableAction(string $role, int $id): array
    {
        $this->checkRole($role);
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
     * @param object AbstractAction $action объект класса-действия, наследник абстрактного класса-действия
     * @return string|null
     */
    public function getNextStatus(AbstractAction $action): ?string
    {
        $map = [
            CancelAction::class => self::STATUS_CANCELLED,
            RespondAction::class => self::STATUS_AT_WORK,
            CompletedAction::class => self::STATUS_COMPLETED,
            RefuseAction::class => self::STATUS_FAILED
        ];

        return $map[get_class($action)] ?? null;
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
