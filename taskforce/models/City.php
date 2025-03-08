<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id_city
 * @property string $name_city
 * @property float $lat_city
 * @property float $long_city
 *
 * @property User[] $users
 */
class City extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_city', 'lat_city', 'long_city'], 'required'],
            [['lat_city', 'long_city'], 'number'],
            [['name_city'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_city' => 'id города',
            'name_city' => 'наименование',
            'lat_city' => 'широта',
            'long_city' => 'долгота',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id_city' => 'id_city']);
    }
}
