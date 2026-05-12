<?php

namespace app\controllers;

use Yii;
use app\models\Transport;
use yii\web\Controller;
use yii\filters\AccessControl;

class TransportController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->identity->isAdmin) {

            $items = Transport::find()
                ->orderBy(['id' => SORT_DESC])
                ->all();

        } else {

            $items = Transport::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->orderBy(['id' => SORT_DESC])
                ->all();
        }
        return $this->render('index', [
            'items' => $items
        ]);
    }
    public function actionCreate()
    {
        $model = new Transport();

        if ($model->load(Yii::$app->request->post())) {

            $model->user_id = Yii::$app->user->id;
            $model->status = 'pending';

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionChangeStatus($id, $status)
    {
        $model = Transport::findOne($id);

        if (!$model || $model->user_id != Yii::$app->user->id) {
            throw new \yii\web\NotFoundHttpException();
        }

        if (!array_key_exists($status, Transport::statusList())) {
            throw new \yii\web\BadRequestHttpException('Invalid status');
        }

        $model->status = $status;
        $model->save(false);

        return $this->redirect(['index']);
    }
    public function actionKanban()
    {
        // admin видит всё
        if (Yii::$app->user->identity->isAdmin) {

            $items = Transport::find()
                ->orderBy(['id' => SORT_DESC])
                ->all();

        } else {

            // обычный пользователь только свои перевозки
            $items = Transport::find()
                ->where([
                    'user_id' => Yii::$app->user->id
                ])
                ->orderBy(['id' => SORT_DESC])
                ->all();
        }

        $grouped = [
            'pending' => [],
            'assigned' => [],
            'in_transit' => [],
            'delivered' => [],
            'cancelled' => [],
        ];

        foreach ($items as $item) {

            // защита если status пустой или неизвестный
            if (!isset($grouped[$item->status])) {
                $grouped[$item->status] = [];
            }

            $grouped[$item->status][] = $item;
        }

        return $this->render('kanban', [
            'grouped' => $grouped
        ]);
    }
    public function actionKanbanData()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $items = \app\models\Transport::find()
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $grouped = [];

        foreach ($items as $item) {
            $grouped[$item->status][] = [
                'id' => $item->id,
                'title' => $item->title,
                'from' => $item->from_address,
                'to' => $item->to_address,
                'status' => $item->status,
            ];
        }

        return $grouped;
    }
}