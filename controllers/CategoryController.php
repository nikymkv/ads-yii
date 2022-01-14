<?php

namespace app\controllers;

use app\models\Category;

class CategoryController extends \yii\web\Controller
{
    public function actionGetByParentId(int $id)
    {
        $categories = Category::find()
            ->select(['id', 'name'])
            ->where('parent_id=:id', [':id' => $id])
            ->orderBy('name ASC')
            ->all();

        return $this->asJson($categories);
    }

}
