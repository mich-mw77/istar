<?php

namespace app\modules\PhoneBook\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\Exception;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $date_of_birth
 *
 * @property UserPhone[] $userPhones
 */
class User extends \yii\db\ActiveRecord
{

    private array $newPhones = [];
    private array $oldPhones = [];

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
            [['first_name'], 'required', 'message' => 'Заполните имя'],
            [['email'], 'email', 'message' => 'Некорректная почта'],
            [['newPhones', 'oldPhones'], 'safe'],
            [['date_of_birth'], 'date', 'format' => 'php:Y-m-d', 'message' => 'Введите дату в формате'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 255],
            ['date_of_birth', 'ageValidate'],
        ];
    }

    public function ageValidate()
    {
        $dateObj = new \DateTime($this->date_of_birth);
        $ageLimit = new \DateTime('-18 years');
        if ($dateObj > $ageLimit) {
            $this->addError('date_of_birth', 'Возвраст должен быть больше 18 лет');
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'email' => 'Почта',
            'date_of_birth' => 'День рождения'
        ];
    }

    /**
     * Gets query for [[UserPhones]].
     *
     * @return \yii\db\ActiveQuery|UserPhoneQuery
     */
    public function getUserPhones()
    {
        return $this->hasMany(UserPhone::className(), ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setNewPhones(array $data): User
    {
        $this->newPhones = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getNewPhones(): array
    {
        return $this->newPhones;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setOldPhones(array $data): User
    {
        $this->oldPhones = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getOldPhones(): array
    {
        return $this->oldPhones;
    }

    /**
     * @return bool
     * @throws Exception
     * @throws \Throwable
     */
    public function saveWithPhones()
    {
        $transaction = static::getDb()->beginTransaction();
        try {
            $result = $this->save();
            if ($result === false || !$this->_saveUserPhones()) {
                $transaction->rollBack();
                return false;
            } else {
                $transaction->commit();
            }

            return $result;// TODO: Change the autogenerated stub
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    protected function _saveUserPhones()
    {
        $userPhone = new UserPhone();
        $newPhones = $this->getNewPhones();
        $oldPhones = $this->getOldPhones();

        $insertPhones = [];
        $deletePhones = array_diff($oldPhones, $newPhones);

        foreach ($newPhones as $newPhone) {
            if (!empty($newPhone) && !in_array($newPhone, $oldPhones)) {
                $userPhone->phone = $newPhone;
                if (!$userPhone->validate(['phone'])) {
                    Yii::error($userPhone->getErrors());
                    return false;
                }

                $insertPhones [] = [$this->id, $newPhone];
            }
        }

        Yii::$app->db->createCommand()->delete($userPhone::tableName(), ['user_id' => $this->id, 'phone' => $deletePhones])->execute();
        Yii::$app->db->createCommand()->batchInsert($userPhone::tableName(), ['user_id', 'phone'], $insertPhones)->execute();

        return $this;
    }
}