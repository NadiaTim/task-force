<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id_user
 * @property string $name
 * @property string $email
 * @property int $id_city
 * @property string $password
 * @property string|null $birth
 * @property string $registration
 * @property string|null $telegram
 * @property int|null $id_job_title
 * @property string|null $avatar
 * @property string|null $information
 * @property int $id_role
 * @property string|null $phone
 *
 * @property City $city
 * @property Respon[] $respons
 * @property Review[] $reviews
 * @property Review[] $reviews0
 * @property Role $role
 * @property Task[] $tasks
 * @property UserJobTitle[] $userJobTitles
 */
class User extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birth', 'telegram', 'id_job_title', 'avatar', 'information', 'phone'], 'default', 'value' => null],
            [['name', 'email', 'id_city', 'password', 'registration', 'id_role'], 'required'],
            [['id_city', 'id_job_title', 'id_role'], 'integer'],
            [['birth', 'registration'], 'safe'],
            [['information'], 'string'],
            [['name', 'avatar'], 'string', 'max' => 50],
            [['email', 'password'], 'string', 'max' => 100],
            [['telegram'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 20],
            [['id_city'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['id_city' => 'id_city']],
            [['id_role'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['id_role' => 'id_role']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'id пользователя',
            'name' => 'Имя пользователя',
            'email' => 'Email',
            'id_city' => 'id города',
            'password' => 'пароль',
            'birth' => 'дата рождения',
            'registration' => 'дата регистрации',
            'telegram' => 'Telegram',
            'id_job_title' => 'id специализация',
            'avatar' => 'аватар',
            'information' => 'дополнительная информация',
            'id_role' => 'id роли',
            'phone' => 'телефон',
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CityQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id_city' => 'id_city']);
    }

    /**
     * Gets query for [[Respons]].
     *
     * @return \yii\db\ActiveQuery|ResponsQuery
     */
    public function getRespons()
    {
        return $this->hasMany(Respons::class, ['id_executor' => 'id_user']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['id_commentator' => 'id_user']);
    }

    /**
     * Gets query for [[Reviews0]].
     *
     * @return \yii\db\ActiveQuery|ReviewQuery
     */
    public function getReviews0()
    {
        return $this->hasMany(Review::class, ['id_user' => 'id_user']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery|RoleQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id_role' => 'id_role']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['id_client' => 'id_user']);
    }

    /**
     * Gets query for [[UserJobTitles]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getJobTitles()
    {
        return $this->hasMany(JobTitle::class, ['id_user' => 'id_user'])->viaTable('user_job_title', ['id_job_title' => 'id_job_title']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
