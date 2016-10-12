<?php
/**
 * Created by PhpStorm.
 * User: 'lizhengxiang'
 * Date: 16-10-11 下午2:34
 * content：老师创建活动
 */

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\services\ActivitiesService;
class ActivitiesController extends Controller
{
    private $service;

    public function init()
    {
        $this->service = new ActivitiesService();
    }
    /*
     * 创建活动
     */
    public function actionCreateactivities(){
        $request = Yii::$app->request->post();
        $data = $this->service->createActivities($request);
        $data = json_encode($data);
        return $data;

    }
    
    public function actionGetactivities(){
        $request = Yii::$app->request->get();
        $data = $this->service->getActivities($request);
        $data = json_encode($data);
        return $data;
    }




}
