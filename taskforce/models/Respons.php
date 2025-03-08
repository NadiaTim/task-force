<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "respons".
 *
 * @property int $id_response
 * @property int $id_executor
 * @property int $id_task
 * @property int $price
 * @property string $date_add
 *
 * @property User $executor
 * @property Task $task
 */
class Respons extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'respons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_executor', 'id_task', 'price'], 'required'],
            [['id_executor', 'id_task', 'price'], 'integer'],
            [['date_add'], 'safe'],
            [['id_executor'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_executor' => 'id_user']],
            [['id_task'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['id_task' => 'id_task']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_response' => 'id отклика',
            'id_executor' => 'id исполнителя',
            'id_task' => 'id задания',
            'price' => 'цена',
            'date_add' => 'дата отклика',
        ];
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::class, ['id_user' => 'id_executor']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id_task' => 'id_task']);
    }
}
