<?php

namespace app\controllers;

use app\models\City;

class CityController extends \yii\web\Controller
{
    public function actionGetByLocationId($id)
    {
        $cities = City::find()
            ->select(['id', 'name'])
            ->where('location_id=:location', [':location' => $id])
            ->orderBy('name ASC')
            ->all();

        return $this->asJson($cities);
    }

}
