<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserJobTitle]].
 *
 * @see UserJobTitle
 */
class UserJobTitleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserJobTitle[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserJobTitle|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
