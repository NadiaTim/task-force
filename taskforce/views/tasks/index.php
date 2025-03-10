<?php

/** 
 * @var $this yii\web\View 
 * @var Task[] $task
 */

use yii\helpers\Html;
use yii\web\View;

$this->title = 'Новые задания';
?>
<main class="main-content container">
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>
        <?php
        if ($tasks):
            foreach ($tasks as $task): ?>
                <div class="task-card">
                    <div class="header-task">
                        <a href="#" class="link link--block link--big"><?= Html::encode($task->task); ?></a>
                        <?php if ($task->price): ?>
                            <p class="price price--task"><?= $task->price; ?> ₽</p>
                        <?php endif; ?>
                    </div>
                    <p class="info-text"><span class="current-time"><?= Yii::$app->formatter->asRelativeTime($task->date_public); ?></span></p>
                    <p class="task-text"><?= Html::encode($task->discription); ?></p>
                    <div class="footer-task">
                        <?php if ($task->id_address): ?>
                            <p class="info-text town-text"><?php $task->address; ?></p>
                        <?php endif; ?>
                        <?php foreach ($task->categories as $category): ?>
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
            <ul class="pagination-list">
                <li class="pagination-item mark">
                    <a href="#" class="link link--page"></a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="link link--page">1</a>
                </li>
                <li class="pagination-item pagination-item--active">
                    <a href="#" class="link link--page">2</a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="link link--page">3</a>
                </li>
                <li class="pagination-item mark">
                    <a href="#" class="link link--page"></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="right-column">
        <div class="right-card black">
            <div class="search-form">
                <form>
                    <h4 class="head-card">Категории</h4>
                    <div class="form-group">
                        <div class="checkbox-wrapper">
                            <label class="control-label" for="сourier-services">
                                <input type="checkbox" id="сourier-services" checked>
                                Курьерские услуги</label>
                            <label class="control-label" for="cargo-transportation">
                                <input id="cargo-transportation" type="checkbox">
                                Грузоперевозки</label>
                            <label class="control-label" for="translations">
                                <input id="translations" type="checkbox">
                                Переводы</label>
                        </div>
                    </div>
                    <h4 class="head-card">Дополнительно</h4>
                    <div class="form-group">
                        <label class="control-label" for="without-performer">
                            <input id="without-performer" type="checkbox" checked>
                            Без исполнителя</label>
                    </div>
                    <h4 class="head-card">Период</h4>
                    <div class="form-group">
                        <label for="period-value"></label>
                        <select id="period-value">
                            <option>1 час</option>
                            <option>12 часов</option>
                            <option>24 часа</option>
                        </select>
                    </div>
                    <input type="submit" class="button button--blue" value="Искать">
                </form>
            </div>
        </div>
    </div>
</main>