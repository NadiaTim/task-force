<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_job_title".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_specialization
 *
 * @property JobTitle $specialization
 * @property User $user
 */
class UserJobTitle extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_job_title';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_specialization'], 'required'],
            [['id', 'id_user', 'id_specialization'], 'integer'],
            [['id'], 'unique'],
            [['id_specialization'], 'exist', 'skipOnError' => true, 'targetClass' => JobTitle::class, 'targetAttribute' => ['id_specialization' => 'id_specialization']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id_user']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'id_user' => 'id исполнителя',
            'id_specialization' => 'id специализация',
        ];
    }

    /**
     * Gets query for [[Specialization]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialization()
    {
        return $this->hasOne(JobTitle::class, ['id_specialization' => 'id_specialization']);
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
