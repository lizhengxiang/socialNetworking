<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\services\PersonalService;
class PersonalController extends Controller
{
    private $service;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup','provinces'],
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
        $this->service = new PersonalService();
    }

    /*
     * 获取自己发表的动态
     */
    public function actionDynamic(){
        $request = Yii::$app->request->post();
        $data = $this->service->searchDynamic($request);
        $data = json_encode($data);
        return $data;
    }

}
