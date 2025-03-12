<?php

namespace app\controllers;

use app\models\Task;
use app\models\Category;
use yii\web\Controller;
use yii\data\Pagination;

class TasksController extends Controller
{

    /**
     * Displays Tasks.
     *
     * @return string
     */
    public function actionIndex()
    {
        //создаем модель
        $task = new Task();
        //передаем данные из формы
        $task->load(\Yii::$app->request->post());

        //определяем список всех категорий
        $categories = Category::find()->all();

        //Формируем запрос
        $tasksQuery = $task->getTaskListQuery();

        //реализуем пагинацию
        $countQuery = clone $tasksQuery;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 1,
            'pageSizeParam' => false
        ]);

        //выводим список всех записей
        $tasks = $tasksQuery->offset($pages->offset)
            ->limit($pages->limit)
            ->all();


        return $this->render('index.php', [
            'models' => $tasks,
            'task' => $task,
            'categories' => $categories,
            'pages' => $pages
        ]);
    }
}
