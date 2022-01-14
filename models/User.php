<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return '{{users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'location_id' => 'Страна',
            'city_id' => 'Город',
            'email' => 'Почта',
            'phone' => 'Телефон',
            'block' => 'Заблокирован',
            'password' => 'Пароль',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['location_id', 'city_id'], 'integer'],
            [['email', 'name'], 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            [['name', 'phone', 'password', 'email'], 'string', 'max' => 191],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    /**
     * Finds user by email
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail(string $email)
    {
        return self::findOne(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
    }

    public function setPassword(string $password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function validatePassword(string $password)
    {
        return password_verify($password, $this->password);
    }

    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    public function getRatedAds()
    {
        return $this->hasMany(UserAd::class, ['id' => 'ad_id'])
            ->viaTable('user_ad_rate', ['user_id' => 'id']);
    }

    public function getLocation()
    {
        return $this->hasOne(Location::class, ['id' => 'location_id']);
    }

    public function getAds()
    {
        return $this->hasMany(UserAd::class, ['user_id' => 'id']);
    }
}
