<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Registered;
use app\services\RegisteredService;
class RegisteredController extends Controller
{
    private $service;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['provinces'],
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->goBack();
                }
            ],
        ];
    }

    public function init()
    {
        $this->service = new RegisteredService();
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
            'components' => [
                'mailer' => [
                    'class' => 'yii\swiftmailer\Mailer',
                ],
            ],
        ];
    }
    
    /*
     * get provinces
     */
    public function actionProvinces(){
        $request = [];
        $request['parentid'] = 0;
        $data = $this->service->searchProvinces($request);
        return $data;

    }

    /*
     * get school
     */
    public function actionGetschool(){
        $request = Yii::$app->request->post();
        $data = $this->service->searchProvinces($request);
        return $data;
    }

    /*
     * 注册
     */
    public function actionRegistered(){
        $request = Yii::$app->request->post();
        //验证输入的规则
        if(preg_match("/^\d*$/",$request['provinces']) && preg_match("/^\d*$/",$request['school']) &&
            preg_match("/^\d*$/",$request['year']) && preg_match("/^\d*$/",$request['mouth']) &&
            preg_match("/^\d*$/",$request['day']) && !empty($request['email'])
            && !empty($request['nickname'])
        ){
            $data = $this->service->Registered($request);
            return $data;
        }else{
            throw new \yii\base\UserException('所有的值不允许为空',1004);
        }
    }
}
