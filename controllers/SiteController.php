<?php

namespace app\controllers;

use app\models\EntryForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\base\action;
use yii\di\ServiceLocator;
use yii\caching\FileCache;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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

    public function run(){
        return "Hello World";
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        //throw new \yii\web\HttpException(500);
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

   public function actionForward(){
       return $this->redirect('http://socialnetworking.com');
   }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }



    public function actionContact()
    {
        $model = new ContactForm();
        echo $model->getAttributeLabel('firstName');
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionTest()
    {
        $redis = Yii::$app->redis;
        $redis->set('k','v');
        var_dump($redis->get('k'));exit;
        return $this->render('test');
    }

    public function actionHello($message = 'lizehngxiang'){
        return json_encode($message);
        return $this->render('say', ['message' => $message[0]]);
    }

    public function actionEntry(){
        $key = Yii::$app->getSecurity()->generateRandomString(10);
        $model = new EntryForm();
        //var_dump(Yii::$app->request->post());exit();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            return $this->render('entry-confirm', ['model' => $model]);
        }else{
            return $this->render('entry', ['model' => $model]);
        }
    }
}
