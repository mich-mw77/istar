<?php

namespace app\modules\PhoneBook\models;

use Yii;

/**
 * This is the model class for table "user_phone".
 *
 * @property int $id
 * @property int $user_id
 * @property string $phone
 *
 * @property User $user
 */
class UserPhone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_phone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'phone'], 'required'],
            [['user_id'], 'integer'],
            ['phone', 'match', 'pattern'=>'/^(\d{10}|\+\d{12})$/', 'message' => 'Номер введен не верно' ],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'phone' => 'Номер',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return UserPhoneQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserPhoneQuery(get_called_class());
    }
}
