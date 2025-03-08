<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[JobTitle]].
 *
 * @see JobTitle
 */
class JobTitleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JobTitle[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JobTitle|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
