<?php

namespace app\modules\PhoneBook\models;

/**
 * This is the ActiveQuery class for [[UserPhone]].
 *
 * @see UserPhone
 */
class UserPhoneQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserPhone[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserPhone|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
