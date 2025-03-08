<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id_review
 * @property int $id_user
 * @property int $id_commentator
 * @property int $grade
 * @property string $date_add
 * @property int|null $id_task
 * @property string|null $comment
 *
 * @property User $commentator
 * @property Task $task
 * @property User $user
 */
class Review extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_task', 'comment'], 'default', 'value' => null],
            [['id_user', 'id_commentator', 'grade'], 'required'],
            [['id_user', 'id_commentator', 'grade', 'id_task'], 'integer'],
            [['date_add'], 'safe'],
            [['comment'], 'string'],
            [['id_commentator'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_commentator' => 'id_user']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id_user']],
            [['id_task'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['id_task' => 'id_task']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_review' => 'id отзыва',
            'id_user' => 'id пользователя',
            'id_commentator' => 'id комментатора',
            'grade' => 'оценка',
            'date_add' => 'дата отзыва',
            'id_task' => 'id задания',
            'comment' => 'отзыв',
        ];
    }

    /**
     * Gets query for [[Commentator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCommentator()
    {
        return $this->hasOne(User::class, ['id_user' => 'id_commentator']);
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id_user' => 'id_user']);
    }
}
