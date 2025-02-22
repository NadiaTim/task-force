<?php

namespace TaskForce\logic;

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

    //действия
    const ACTION_CANCEL = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_COMPLETED = 'completed';
    const ACTION_REFUSE = 'refuse';

    private ?int $idExecutor;
    private int $idСlient;

    private $currentStatus;


    /**
     * Конструктор класса
     * @param int $idСlient
     * @param string $currentStatus
     * @param int|null $idExecutor
     */
    public function __construct(int $idСlient, string $currentStatus = 'new', ?int $idExecutor = null)
    {
        $this->idСlient = $idСlient;
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
     * получаем ассоциативный масссив действий (ключ-внутреннее имя, значение - название действия на русском)
     * @return string[]
     */
    public function getActionMap(): array
    {
        return [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPOND => 'Откликнуться',
            self::ACTION_COMPLETED => 'Выполнено',
            self::ACTION_REFUSE => 'Отказаться',
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

    /**
     * получаем следующий статус в соответствии с переданным действием
     * @param string $action
     * @return string|null
     */
    public function getNextStatus(string $action): ?string
    {
        $map = [
            self::ACTION_CANCEL => self::STATUS_CANCELLED,
            self::ACTION_RESPOND => self::STATUS_AT_WORK,
            self::ACTION_COMPLETED => self::STATUS_COMPLETED,
            self::ACTION_REFUSE => self::STATUS_FAILED
        ];

        return $map[$action] ?? null;
    }

    /**
     * определяет список доступных действий для указанного статуса
     * @param string $status
     * @return array
     */
    private function getAvailableStatus(string $status): array
    {
        $map = [
            self::STATUS_NEW => [
                self::ACTION_CANCEL,
                self::ACTION_RESPOND
            ],
            self::STATUS_AT_WORK => [
                self::ACTION_COMPLETED,
                self::ACTION_REFUSE
            ]
        ];

        return $map[$status] ?? [];
    }
}
