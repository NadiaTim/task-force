<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_title".
 *
 * @property int $id_job_title
 * @property string $job_title
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
            [['job_title'], 'required'],
            [['job_title'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_job_title' => 'id специализации',
            'job_title' => 'специализация',
        ];
    }

    /**
     * Gets query for [[UserJobTitles]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUserJobTitles()
    {
        return $this->hasMany(User::class, ['id_job_title' => 'id_job_title'])->viaTable('user_job_title', ['id_user' => 'id_user']);
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
