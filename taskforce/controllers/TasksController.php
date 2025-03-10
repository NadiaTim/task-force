<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Task;

class TasksController extends Controller
{

    /**
     * Displays Tasks.
     *
     * @return string
     */
    public function actionIndex()
    {
        $tasks = Task::find()
            ->filterWhere(['id_status' => 1])
            ->With('categories', 'address')
            ->addOrderBy(['date_public' => SORT_DESC])
            ->all();


        return $this->render('index.php', ['tasks' => $tasks]);
    }
}
