<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id_task
 * @property string $task
 * @property string|null $discription
 * @property int|null $price
 * @property string $date_public
 * @property string $date_execut
 * @property int $id_status
 * @property int|null $id_address
 * @property int $id_client
 *
 * @property Address $address
 * @property User $client
 * @property File[] $files
 * @property Respon[] $respons
 * @property Review[] $reviews
 * @property Status $status
 * @property TaskCategory[] $taskCategories
 */
class Task extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['discription', 'price', 'id_address'], 'default', 'value' => null],
            [['task', 'id_status', 'id_client'], 'required'],
            [['discription'], 'string'],
            [['price', 'id_status', 'id_address', 'id_client'], 'integer'],
            [['date_public', 'date_execut'], 'safe'],
            [['task'], 'string', 'max' => 255],
            [['id_client'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_client' => 'id_user']],
            [['id_address'], 'exist', 'skipOnError' => true, 'targetClass' => Address::class, 'targetAttribute' => ['id_address' => 'id_address']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['id_status' => 'id_status']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_task' => 'id задания',
            'task' => 'задание',
            'discription' => 'описание',
            'price' => 'цена',
            'date_public' => 'дата публикации',
            'date_execut' => 'дата исполнения',
            'id_status' => 'id статуса',
            'id_address' => 'id адреса',
            'id_client' => 'id владельца',
        ];
    }

    /**
     * Gets query for [[Address]].
     *
     * @return \yii\db\ActiveQuery|AddressQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::class, ['id_address' => 'id_address']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::class, ['id_user' => 'id_client']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery|FileQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::class, ['id_task' => 'id_task']);
    }

    /**
     * Gets query for [[Respons]].
     *
     * @return \yii\db\ActiveQuery|ResponsQuery
     */
    public function getRespons()
    {
        return $this->hasMany(Respons::class, ['id_task' => 'id_task']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['id_task' => 'id_task']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery|StatusQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id_status' => 'id_status']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id_category' => 'id_category'])->viaTable('task_category', ['id_task' => 'id_task']);
    }

    /**
     * {@inheritdoc}
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }
}
