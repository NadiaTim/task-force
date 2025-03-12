<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;

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
     * виртуальные свойства для хранения данных из формы
     */
    public $id_category;
    public $is_without_executor;
    public $is_without_location;
    public $filter_period;

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
            [['is_without_executor', 'is_without_location'], 'boolean'],
            [['filter_period'], 'number'],
            [['id_category'], 'integer'],
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
            'is_without_executor' => 'Без откликов',
            'is_without_location' => 'Удаленная работа',
        ];
    }

    /**
     * Gets query for [[Address]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::class, ['id_address' => 'id_address']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::class, ['id_user' => 'id_client']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::class, ['id_task' => 'id_task']);
    }

    /**
     * Gets query for [[Respons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRespons()
    {
        return $this->hasMany(Respons::class, ['id_task' => 'id_task']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['id_task' => 'id_task']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id_status' => 'id_status']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id_category' => 'id_category'])->viaTable('task_category', ['id_task' => 'id_task']);
    }

    public function getTaskListQuery()
    {
        $query = self::find()
            ->filterWhere(['id_status' => 1])
            ->joinWith('categories', 'address')
            ->andFilterWhere(['category.id_category' => $this->id_category])
            ->andFilterWhere(['id_address' => $this->id_address]);
        if ($this->is_without_executor) {
            $query->With('responce r')
                ->andWhere('r.id_response IS NULL');
        }
        if ($this->filter_period) {
            $query->andWhere(
                '(unix_timestamp(task.date_public) > (unix_timestamp () - 604800))'
            );
        }
        return $query->addOrderBy(['date_public' => SORT_DESC]);
    }
}
