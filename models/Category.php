<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $name
 * @property string|null $slug
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 191],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'slug' => 'Slug',
        ];
    }

    public static function getWithAdsCount()
    {
        return self::find()->select([
            'categories.id',
            'categories.parent_id',
            'categories.name',
            'COUNT(user_ads.id) AS ads_count',
        ])
        ->leftJoin('user_ads', 'user_ads.category_id = categories.id AND user_ads.status = 1')
        ->where('categories.parent_id IS NULL')
        ->groupBy('categories.id')
        ->orderBy('categories.name ASC');
    }
}
