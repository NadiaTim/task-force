<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Respons]].
 *
 * @see Respons
 */
class ResponsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Respons[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Respons|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
