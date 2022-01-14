<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_ad_rate".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $ad_id
 * @property float|null $rate
 */
class UserAdRate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_ad_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'ad_id'], 'integer'],
            [['rate'], 'number'],
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
            'ad_id' => 'Ad ID',
            'rate' => 'Rate',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getAd()
    {
        return $this->hasOne(UserAd::class, ['id' => 'ad_id']);
    }
}
