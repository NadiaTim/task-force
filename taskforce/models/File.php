<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property int $id_file
 * @property string $path
 * @property string $name
 * @property int $id_task
 * @property string $date_add
 *
 * @property Task $task
 */
class File extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path', 'name', 'id_task'], 'required'],
            [['id_task'], 'integer'],
            [['date_add'], 'safe'],
            [['path'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 30],
            [['id_task'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['id_task' => 'id_task']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_file' => 'id файла',
            'path' => 'путь',
            'name' => 'название',
            'id_task' => 'id задания',
            'date_add' => 'дата добавления',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id_task' => 'id_task']);
    }

    /**
     * {@inheritdoc}
     * @return FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FileQuery(get_called_class());
    }
}
