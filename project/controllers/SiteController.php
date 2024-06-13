<?php

namespace app\controllers;

use app\models\ObjectObjectPosition;
use app\models\ObjectObjectRegion;
use app\models\Objects;
use app\models\ObjectPosition;
use app\models\ObjectRegion;
use Yii;
use yii\db\Exception;
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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

    // Контроллер страницы с картой
    /**
     * @throws Exception
     */
    public function actionMap()
    {
        $objects = new Objects();
        $pos = new ObjectPosition();
        $reg = new ObjectRegion();
        $obj_reg = new ObjectObjectRegion();
        $obj_pos = new ObjectObjectPosition();
        $nextIdObject = $objects::find()->max('id') + 1;
        if($objects->load(Yii::$app->request->post()) && $obj_reg->load(Yii::$app->request->post()) && $obj_pos->load(Yii::$app->request->post())) {
            $isValid = $objects->validate();
            if ($isValid) {
                $objects->save();
                $obj_pos->object_id = $nextIdObject;
                $isValid = $obj_pos->validate() && $isValid;
                $obj_reg->object_id = $nextIdObject;
                $isValid = $obj_reg->validate() && $isValid;

                if ($isValid) {
                    $obj_reg->save();
                    $obj_pos->save();

                    $objects = new Objects();
                    $obj_reg = new ObjectObjectRegion();
                    $obj_pos = new ObjectObjectPosition();

                    return $this->render('map', ['objects' => $objects, 'pos' => $pos, 'reg' => $reg, 'objReg' => $obj_reg, 'objPos' => $obj_pos]);
                }
            }
        }
        return $this->render('map', ['objects' => $objects, 'pos' => $pos, 'reg' => $reg, 'objReg' => $obj_reg, 'objPos' => $obj_pos]);
    }
}
