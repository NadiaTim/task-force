<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id_address
 * @property int $id_city
 * @property float|null $lat_address
 * @property float|null $long_address
 * @property string|null $address
 *
 * @property Task[] $tasks
 */
class Address extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lat_address', 'long_address', 'address'], 'default', 'value' => null],
            [['id_city'], 'required'],
            [['id_city'], 'integer'],
            [['lat_address', 'long_address'], 'number'],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_address' => 'id адреса',
            'id_city' => 'id города',
            'lat_address' => 'широта',
            'long_address' => 'долгота',
            'address' => 'адрес',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['id_address' => 'id_address']);
    }
}
