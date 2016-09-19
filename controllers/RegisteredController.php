<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Registered;
use app\services\RegisteredService;
class RegisteredController extends Controller
{
    private $service;

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
        ];
    }
    
    /*
     * get provinces
     */
    public function actionProvinces(){
        $request = [];
        $request['parentid'] = 0;
        $data = $this->service->searchProvinces($request);
        $data = json_encode($data);
        return $data;

    }

    /*
     * get school
     */
    public function actionGetschool(){
        $request = Yii::$app->request->post();
        $data = $this->service->searchProvinces($request);
        $data = json_encode($data);
        return $data;

    }

    /*
     * 注册
     */
    public function actionRegistered(){
        $model = new Registered();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $request = Yii::$app->request->post();
            $data = $this->service->searchProvinces($request);
            $data = json_encode($data);
            return $data;
        }else{
            throw new \yii\base\UserException('不允许为空',1004);
        }
    }
}
