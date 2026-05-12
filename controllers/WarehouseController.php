<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Warehouse;

class WarehouseController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->identity->isAdmin) {

            // admin видит все склады
            $items = Warehouse::find()
                ->orderBy(['id' => SORT_DESC])
                ->all();

        } else {

            // обычный пользователь только свои
            $items = Warehouse::find()
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
        $model = new Warehouse();

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
}