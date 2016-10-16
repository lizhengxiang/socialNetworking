<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\Tools;
class LoginController extends Controller
{
    private $Tools;
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

    public function init()
    {
        $this->Tools = new tools();
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->Tools->result('已登陆',1,0);
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->Tools->result('登陆成功',1,0);
        }
        return $this->Tools->result('',1,0);
    }
}
