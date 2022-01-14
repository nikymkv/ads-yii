<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Объявления автора';

?>
<div class="user-ad-index">
    <h3>Объявления продавца</h3>
    <?php foreach ($models as $model) { ?>
        <article class="obyava-rows-items">
            <a href="<?php echo Url::toRoute(['site/view', 'id' => $model->id]) ?>">
                <div class="d-flex">
                    <div class="obyava-rows-icon-wrap">
                        <img src="<?php echo count($model->getPhotoArray() ?? [])
                                        ? Yii::getAlias('@web/' . $model->getPhotoArray()[0])
                                        : Yii::getAlias('@web/images/noimage.png') ?>" alt="<?php echo $model->title ?>" class="obyava-rows-icon">
                    </div>
                    <div class="obyava-rows-title">
                        <h5><?php echo $model->title ?></h5>
                        <p><?php echo $model->category->name ?></p>
                        <p class="obyava-rows-date"><?php echo $model->created_at ?></p>
                    </div>
                    <div class="obyava-rows-price">
                        <?php echo $model->price ?> <?php echo $model->currency->name ?></p>
                        <?php if ($model->bargain) { ?>
                            <p>Возможен торг</p>
                        <?php } ?>
                    </div>
                </div>
            </a>
        </article>
    <?php } ?>

    <section class="pagination">
        <div class="pagination-wrap">
            <?php echo LinkPager::widget([
                'pagination' => $pages,
                'prevPageLabel' => false,
                'nextPageLabel' => false,
                // 'activePageCssClass' => 'pagination-btn pagination-btn-active',
                'linkOptions' => ['class' => 'pagination-btn'],
                'maxButtonCount' => 3,
            ]); ?>
        </div>
    </section>

</div>