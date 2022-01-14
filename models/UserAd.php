<?php

namespace app\models;

use app\filters\Filter;
use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "user_ads".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $category_id
 * @property int|null $subcategory_id
 * @property int|null $currency_id
 * @property int|null $location_id
 * @property int|null $city_id
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $photo_path
 * @property string|null $photo
 * @property string|null $photo_array
 * @property int|null $parametr
 * @property float|null $price
 * @property int|null $bargain
 * @property string|null $phone_array
 * @property int|null $top
 * @property int|null $watch_phone
 * @property int|null $favourites_count
 * @property int|null $views_count
 * @property int|null $status
 */
class UserAd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_ads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id', 'subcategory_id', 'currency_id', 'location_id', 'city_id', 'bargain', 'status'], 'integer'],
            [['description'], 'string'],
            [['photo_array', 'phone_array'], 'safe'],
            [['price'], 'number'],
            [['title', 'slug'], 'string', 'max' => 191],
        ];
    }

    public function setImagesPath($images)
    {
        $photos = [];
        foreach ($images as $image) {
            $path = 'uploads/' . date('Ymd') . '/';
            FileHelper::createDirectory($path);
            $name = uniqid('', true);
            $fullPath = $path . $name . '.' . $image->extension;
            $image->saveAs($fullPath);
            $photos[] = $fullPath;
        }

        $this->photo_array = json_encode($photos);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Продавец',
            'category_id' => 'Категория',
            'subcategory_id' => 'Подкатегория',
            'currency_id' => 'Валюта',
            'location_id' => 'Регион',
            'city_id' => 'Город',
            'title' => 'Заголовок',
            'slug' => 'Slug',
            'description' => 'Описание',
            'photo_array' => 'Изображения товара',
            'price' => 'Цена',
            'bargain' => 'По договоренности',
            'phone_array' => 'Телефон',
            'status' => 'Статус',
        ];
    }

    public function setPhoneArray()
    {
        if (is_array($this->phone_array)) {
            $this->phone_array = json_encode($this->phone_array);
        }
    }

    public function getPhoneArray()
    {
        if (is_string($this->phone_array)) {
            return json_decode($this->phone_array);
        }

        return $this->phone_array;
    }

    public function setPhotoArray()
    {
        if (is_array($this->photo_array)) {
            $this->photo_array = json_encode($this->photo_array);
        }
    }

    public function getPhotoArray()
    {
        if (is_string($this->photo_array)) {
            return json_decode($this->photo_array) ?? [];
        }

        return $this->photo_array ?? [];
    }

    public function getCurrency()
    {
        return $this->hasOne(Currency::class, ['id' => 'currency_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getSubCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'subcategory_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getRate()
    {
        return $this->hasMany(UserAdRate::class, ['ad_id' => 'id']);
    }

    public function getAverageRate()
    {
        $avg = $this->getRate()
        ->select([
            'id',
            'user_id',
            'ad_id',
            'rate',
        ])->where('ad_id=:id', [':id' => $this->id])
        ->average('rate');

        return round($avg, 2);
    }

    public function isRateByUser()
    {
        $userId = Yii::$app->user->identity->id;
        $userAdRate = $this->getRate()->where('user_id=:id', [':id' => $userId])->one();
        if ($userAdRate) {
            return true;
        }

        return false;
    }

    public function getRateByUser()
    {
        $userId = Yii::$app->user->identity->id;
        $userAdRate = $this->getRate()->where('user_id=:id', [':id' => $userId])->one();
        if ($userAdRate) {
            return $userAdRate->rate;
        }
    }
}
