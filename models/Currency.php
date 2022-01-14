<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "currencies".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $icon
 * @property string|null $code
 * @property string|null $code_int
 * @property string|null $symbol
 * @property string|null $format
 * @property string|null $exchange_rate
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currencies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'icon', 'code', 'code_int', 'symbol', 'format', 'exchange_rate'], 'string', 'max' => 191],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'icon' => 'Icon',
            'code' => 'Code',
            'code_int' => 'Code Int',
            'symbol' => 'Symbol',
            'format' => 'Format',
            'exchange_rate' => 'Exchange Rate',
        ];
    }
}
