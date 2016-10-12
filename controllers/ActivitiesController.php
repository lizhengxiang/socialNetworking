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

    //按用户获取创建的活动
    public function actionGetactivities(){
        $request = Yii::$app->request->get();
        $data = $this->service->getActivities($request);
        $data = json_encode($data);
        return $data;
    }

    //获取列
    public function actionColumn(){
        $request = Yii::$app->request->get();
        $data = $this->service->getColumn($request);
        $data = json_encode($data);
        return $data;
    }
    //获取报名数据
    public function actionGetdetails(){
        $request = Yii::$app->request->get();
        $data = $this->service->Getdetails($request);
        $data = json_encode($data);
        return $data;
    }


}
