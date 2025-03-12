<?php

/** 
 * @var $this yii\web\View 
 * @var Task[] $models
 * @var Task $task
 * @var Category[] $categories
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Новые задания';
?>

<main class="main-content container">
    <div class="left-column">

        <h3 class="head-main head-task">Новые задания</h3>
        <?php
        if ($models):
            foreach ($models as $model): ?>
                <div class="task-card">
                    <div class="header-task">
                        <a href="#" class="link link--block link--big"><?= Html::encode($model->task); ?></a>
                        <?php if ($model->price): ?>
                            <p class="price price--task"><?= $model->price; ?> ₽</p>
                        <?php endif; ?>
                    </div>
                    <p class="info-text"><span class="current-time">
                            <?= Yii::$app->formatter->asRelativeTime($model->date_public); ?>
                        </span></p>
                    <p class="task-text"><?= Html::encode($model->discription); ?></p>
                    <div class="footer-task">
                        <?php if ($model->id_address): ?>
                            <p class="info-text town-text"><?php $model->address; ?></p>
                        <?php endif; ?>
                        <?php foreach ($model->categories as $category): ?>
                            <p class="info-text category-text"><?= $category->name_category; ?></p>
                        <?php endforeach; ?>
                        <a href="#" class="button button--black">Смотреть Задание</a>
                    </div>
                </div>
            <?php endforeach;
        else: ?>
            <h4 class="head-task">Нет новых заданий</h4>
        <?php endif; ?>

        <div class="pagination-wrapper">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'prevPageCssClass' => 'pagination-item mark',
                'nextPageCssClass' => 'pagination-item mark',
                'pageCssClass' => 'pagination-item',
                'activePageCssClass' => 'pagination-item--active',
                'linkOptions' => ['class' => 'link link--page'],
                'options' => ['class' => 'pagination-list'],
                'nextPageLabel' => '',
                'prevPageLabel' => '',
                'maxButtonCount' => 5
            ]); ?>
        </div>
    </div>
    <div class="right-column">
        <div class="right-card black">
            <div class="search-form">
                <?php $form = ActiveForm::begin(); ?>
                <h4 class="head-card">Категории</h4>

                <div class="checkbox-wrapper">
                    <?= Html::activeCheckboxList(
                        $task,
                        'id_category',
                        array_column($categories, 'name_category', 'id_category'),
                        [
                            'tag' => NULL,
                            'itemOptions' => ['labelOptions' => ['class' => 'control-label']]
                        ]
                    ) ?>
                    <!-- <label class="control-label" for="сourier-services">
                                <input type="checkbox" id="сourier-services" checked>
                                Курьерские услуги</label>
                            <label class="control-label" for="cargo-transportation">
                                <input id="cargo-transportation" type="checkbox">
                                Грузоперевозки</label>
                            <label class="control-label" for="translations">
                                <input id="translations" type="checkbox">
                                Переводы</label> -->
                </div>
                <h4 class="head-card">Дополнительно</h4>
                <?= $form->field($task, 'is_without_executor')
                    ->checkbox(['labelOptions' => ['class' => 'control-label']]); ?>
                <?= $form->field($task, 'is_without_location')
                    ->checkbox(['labelOptions' => ['class' => 'control-label']]); ?>
                <!-- <label class="control-label" for="without-performer">
                            <input id="without-performer" type="checkbox" checked>
                            Без исполнителя
                        </label> 
                        <label class="control-label" for="without-location">
                            <input id="without-location" type="checkbox" checked>
                            Без исполнителя
                        </label> 
                        -->
                <h4 class="head-card">Период</h4>
                <?=
                $form->field($task, 'filter_period', ['template' => '{input}'])->dropDownList([
                    3600 => 'За последний час',
                    86400 => 'За сутки',
                    604800 => 'За неделю'
                ], ['prompt' => 'Выбрать']);
                ?>
                <input type="submit" class="button button--blue" value="Искать">
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</main>