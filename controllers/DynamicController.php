<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\services\DynamicService;
class DynamicController extends Controller
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
        $this->service = new DynamicService();
    }

    /*
     * 获取自己发表的动态和别人发表的动态
     */
    public function actionGetdynamic(){
        $request = Yii::$app->request->post();
        $data = $this->service->searchDynamic($request);
        return $data;
    }
    
    /*
     * 点赞，举报，转发接口
     */
    public function actionEvaluation(){
        if (Yii::$app->user->isGuest) {
            $request['code'] = 0;
            $request['status'] = 0;
            return json_encode($request);
        }
        $request = Yii::$app->request->post();
        $data = $this->service->evaluation($request);
        return $data;
    }
}
