<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TaskCategory]].
 *
 * @see TaskCategory
 */
class TaskCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaskCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaskCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
