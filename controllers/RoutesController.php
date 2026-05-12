<?php

namespace app\controllers;

use app\models\Routes;
use Yii;
use yii\web\Controller;

class RoutesController extends Controller
{
    public function actionIndex()
    {
        // admin видит все маршруты
        if (Yii::$app->user->identity->isAdmin) {

            $items = Routes::find()
                ->orderBy(['id' => SORT_DESC])
                ->all();

        } else {

            // обычный пользователь — только свои
            $items = Routes::find()
                ->where([
                    'user_id' => Yii::$app->user->id
                ])
                ->orderBy(['id' => SORT_DESC])
                ->all();
        }

        return $this->render('index', [
            'items' => $items,
        ]);
    }

    public function actionCreate()
    {
        $model = new Routes();

        if ($model->load(Yii::$app->request->post())) {

            $model->user_id = Yii::$app->user->id ?? 1;
            $model->created_at = date('Y-m-d H:i:s');

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionView($id)
    {
        $route = Routes::findOne($id);

        if (!$route) {
            throw new \yii\web\NotFoundHttpException('Маршрут не найден');
        }

        // защита: пользователь видит только свои маршруты (или admin всё)
        if (!Yii::$app->user->identity->isAdmin &&
            $route->user_id != Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException('Доступ запрещён');
        }

        return $this->render('view', [
            'route' => $route,
        ]);
    }
}