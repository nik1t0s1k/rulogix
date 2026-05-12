<?php

namespace app\controllers;

use app\models\ProfileForm;
use app\models\Routes;
use app\models\Signup;
use app\models\Transport;
use app\models\Warehouse;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'profile'],
                'rules' => [
                    [
                        'actions' => ['logout', 'profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    public function actionSignup()
    {
        $model = new Signup();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->goBack();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionProfile()
    {
        $model = new ProfileForm();
        $user = Yii::$app->user->identity;

        $model->loadFromUser($user);

        if ($model->load(Yii::$app->request->post()) && $model->save($user)) {
            Yii::$app->session->setFlash('success', 'Профиль обновлён');
            return $this->refresh();
        }

        return $this->render('profile', [
            'model' => $model,
            'user' => $user,
        ]);
    }
    public function actionDashboard()
    {
        $userId = Yii::$app->user->id;

        // admin видит всё
        $transportQuery = Transport::find();
        $warehouseQuery = Warehouse::find();
        $routesQuery = Routes::find();

        if (!Yii::$app->user->identity->isAdmin) {
            $transportQuery->where(['user_id' => $userId]);
            $warehouseQuery->where(['user_id' => $userId]);
            $routesQuery->where(['user_id' => $userId]);
        }

        $stats = [
            'transport' => $transportQuery->count(),
            'warehouse' => $warehouseQuery->count(),
            'routes' => $routesQuery->count(),

            // активные заказы
            'active_orders' => (clone $transportQuery)
                ->andWhere(['status' => 'in_transit'])
                ->count(),
        ];

        return $this->render('dashboard', [
            'stats' => $stats,
            'user' => Yii::$app->user->identity,
        ]);
    }
    public function actionAnalytics()
    {
        // admin видит аналитику по всем перевозкам
        if (Yii::$app->user->identity->isAdmin) {

            $total = Transport::find()->count();

            $pending = Transport::find()
                ->where(['status' => 'pending'])
                ->count();

            $inTransit = Transport::find()
                ->where(['status' => 'in_transit'])
                ->count();

            $delivered = Transport::find()
                ->where(['status' => 'delivered'])
                ->count();

        } else {

            // обычный пользователь только свои данные
            $userId = Yii::$app->user->id;

            $total = Transport::find()
                ->where(['user_id' => $userId])
                ->count();

            $pending = Transport::find()
                ->where([
                    'user_id' => $userId,
                    'status' => 'pending'
                ])
                ->count();

            $inTransit = Transport::find()
                ->where([
                    'user_id' => $userId,
                    'status' => 'in_transit'
                ])
                ->count();

            $delivered = Transport::find()
                ->where([
                    'user_id' => $userId,
                    'status' => 'delivered'
                ])
                ->count();
        }

        return $this->render('analytics', [
            'total' => $total,
            'pending' => $pending,
            'inTransit' => $inTransit,
            'delivered' => $delivered,
        ]);
    }

}

