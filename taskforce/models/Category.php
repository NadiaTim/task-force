<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id_category
 * @property string $name_category
 * @property string $icon_category
 *
 * @property TaskCategory[] $taskCategories
 */
class Category extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_category', 'icon_category'], 'required'],
            [['name_category', 'icon_category'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_category' => 'id категории',
            'name_category' => 'наименование',
            'icon_category' => 'код',
        ];
    }

    /**
     * Gets query for [[TaskCategories]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getTaskCategories()
    {
        return $this->hasMany(Task::class, ['id_category' => 'id_category'])->viaTable('task_category', ['id_task' => 'id_task']);
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
}
