<?php

namespace app\commands;

use yii\web\Controller;

class AutopilotController extends Controller
{
    public function actionRun()
    {
        $engine = new \app\services\DispatchEngine();

        $engine->execute([
            'action' => 'auto_assign'
        ]);

        $engine->execute([
            'action' => 'optimize_queue'
        ]);

        return "OK";
    }
}