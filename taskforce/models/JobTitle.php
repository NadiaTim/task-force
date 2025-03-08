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
     * @return \yii\db\ActiveQuery
     */
    public function getUserJobTitles()
    {
        return $this->hasMany(UserJobTitle::class, ['id_specialization' => 'id_specialization']);
    }
}
