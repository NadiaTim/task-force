<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_category".
 *
 * @property int $id
 * @property int $id_task
 * @property int $id_category
 *
 * @property Category $category
 * @property Task $task
 */
class TaskCategory extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_task', 'id_category'], 'required'],
            [['id_task', 'id_category'], 'integer'],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['id_category' => 'id_category']],
            [['id_task'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['id_task' => 'id_task']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'id_task' => 'id задания',
            'id_category' => 'id категории',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id_category' => 'id_category']);
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
