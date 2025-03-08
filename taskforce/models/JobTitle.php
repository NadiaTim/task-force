<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_title".
 *
 * @property int $id_specialization
 * @property string $specialization
 *
 * @property UserJobTitle[] $userJobTitles
 */
class JobTitle extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_title';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['specialization'], 'required'],
            [['specialization'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_specialization' => 'id специализации',
            'specialization' => 'специализация',
        ];
    }

    /**
     * Gets query for [[UserJobTitles]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUserJobTitles()
    {
        return $this->hasMany(UserJobTitle::class, ['id_specialization' => 'id_specialization']);
    }

    /**
     * {@inheritdoc}
     * @return JobTitleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobTitleQuery(get_called_class());
    }
}
