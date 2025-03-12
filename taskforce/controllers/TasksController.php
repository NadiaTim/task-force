<?php

namespace app\controllers;

use app\models\Category;
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
        //создаем модель
        $task = new Task();
        //передаем данные из формы
        $task->load(\Yii::$app->request->post());

        //определяем список всех категорий
        $categories = Category::find()->all();

        //Формируем запрос
        $tasksQuery = $task->getTaskListQuery();
        //реализуем пагинацию

        //выводим список всех записей
        $tasks = $tasksQuery->all();


        return $this->render('index.php', ['models' => $tasks, 'task' => $task, 'categories' => $categories]);
    }
}
