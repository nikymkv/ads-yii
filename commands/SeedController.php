<?php

namespace app\commands;

use app\models\Category;
use app\models\City;
use app\models\Currency;
use app\models\Location;
use app\models\User;
use app\models\UserAd;
use app\models\UserAdRate;
use yii\console\Controller;
use Faker\Factory;

class SeedController extends Controller
{
    public function actionIndex()
    {
        $this->seedCategories();
        $this->seedCurrencies();
        $this->seedLocations();
        $this->seedCities();
        $this->seedUsers();
        $this->seedUserAds();
        $this->seedUserAdRate();
    }

    protected function seedCategories()
    {
        $categories = [
            'Машины' => ['Легковые'],
            'Ноутбуки' => ['Acer'],
            'Обувь' => ['Кроссовки'],
            'Косметика' => ['Парфюмерия'],
            'Мебель' => ['Стул'],
        ];

        foreach ($categories as $categoryName => $subCategoryName) {
            $category = new Category();
            $category->id = null;
            $category->name = $categoryName;
            $category->slug = $categoryName;
            $category->save(false);
            $category->parent_id = $category->id;

            $subCategory = new Category();
            $subCategory->id = null;
            $subCategory->name = $subCategoryName[0];
            $subCategory->slug = $subCategoryName[0];
            $subCategory->parent_id = $category->id;
            $subCategory->save(false);
        }
    }

    protected function seedLocations()
    {
        $locations = [
            'днр',
            'лнр',
            'Россия',
        ];


        foreach ($locations as $locationName) {
            $location = new Location();
            $location->id = null;
            $location->name = $locationName;
            $location->slug = $locationName;
            $location->save(false);
        }
    }

    protected function seedCities()
    {
        $cities = [
            'Горловка',
            'Донецк',
            'Макеевка',
        ];

        foreach ($cities as $cityName) {
            $city = new City();
            $city->id = null;
            $city->name = $cityName;
            $city->location_id = 1;
            $city->slug = $cityName;
            $city->save(false);
        }
    }

    protected function seedCurrencies()
    {
        $currencies = [
            [
                'name' => 'руб',
                'icon' => 'руб',
                'code' => 'руб',
                'code_int' => 'руб',
                'symbol' => 'руб',
                'format' => 'руб',
                'exchange_rate' => 'руб',
            ],
            [
                'name' => 'дол',
                'icon' => 'дол',
                'code' => 'дол',
                'code_int' => 'дол',
                'symbol' => 'дол',
                'format' => 'дол',
                'exchange_rate' => 'дол',
            ],
            [
                'name' => 'евро',
                'icon' => 'евро',
                'code' => 'евро',
                'code_int' => 'евро',
                'symbol' => 'евро',
                'format' => 'евро',
                'exchange_rate' => 'евро',
            ],
        ];

        $currency = new Currency();

        foreach ($currencies as $currencyData) {
            $currency->setIsNewRecord(true);
            $currency->id = null;
            $currency->name = $currencyData['name'];
            $currency->icon = $currencyData['icon'];
            $currency->code = $currencyData['code'];
            $currency->code_int = $currencyData['code_int'];
            $currency->symbol = $currencyData['symbol'];
            $currency->format = $currencyData['format'];
            $currency->exchange_rate = $currencyData['exchange_rate'];
            $currency->save(false);
        }
    }

    protected function seedUsers()
    {
        $faker = Factory::create();
        $usersCount = 10;

        for ($i = 0; $i < $usersCount; $i++) {
            $user = new User();
            $user->id = null;
            $user->city_id = 1;
            $user->location_id = 1;
            $user->name = $faker->name();
            $user->email = $faker->email();
            $user->phone = $faker->e164PhoneNumber();
            $user->block = false;
            $user->email_verified_at = date('Y-m-d');
            $user->password = password_hash('12345678', PASSWORD_BCRYPT);
            $user->save(false);
        }

        // admin
        $user = new User();
        $user->id = null;
        $user->city_id = 1;
        $user->location_id = 1;
        $user->name = 'Admin';
        $user->email = 'admin@admin.com';
        $user->phone = $faker->e164PhoneNumber();
        $user->block = false;
        $user->email_verified_at = date('Y-m-d');
        $user->password = password_hash('00000000', PASSWORD_BCRYPT);
        $user->is_admin = true;
        $user->save(false);
    }

    protected function seedUserAds()
    {
        $faker = Factory::create();
        $countUserAds = 10;
        for ($i = 0; $i < $countUserAds; $i++) {
            $userAd = new UserAd();
            $userAd->user_id = rand(1, 10);
            $userAd->category_id = 1;
            $userAd->subcategory_id = 2;
            $userAd->currency_id = 1;
            $userAd->location_id = 1;
            $userAd->city_id = 1;
            $userAd->title = $faker->sentence(3);
            $userAd->slug = $faker->sentence(3);
            $userAd->description = $faker->sentences(rand(3, 6), true);
            $userAd->photo_array = '';
            $userAd->price = rand(1000, 2000);
            $userAd->bargain = 1;
            $userAd->phone_array = json_encode(['380712839943', '380712839944', '380712839945']);
            $userAd->status = 1;
            if ($userAd->save(false)) {
                echo 'success' . PHP_EOL;
            } else {
                echo 'error' . PHP_EOL;
            }
        }
    }

    public function seedUserAdRate()
    {
        $userAds = UserAd::find()->all();
        $users = User::find()->all();

        foreach ($userAds as $userAd) {
            foreach ($users as $user) {
                $userAdRate = new UserAdRate();
                $userAdRate->ad_id = $userAd->id;
                $userAdRate->user_id = $user->id;
                $userAdRate->rate = mt_rand(100, 500) / 100;
                $userAdRate->save(false);

                $userAd->link('rate', $userAdRate);
            }
        }
    }
}
