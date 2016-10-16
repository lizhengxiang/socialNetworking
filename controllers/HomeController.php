<?php
/**
 * Created by PhpStorm.
 * User: 'lizhengxiang'
 * Date: 16-10-16 下午10:58
 * content：主页，发帖等操作
 */

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\services\HomeService;
class HomeController extends Controller
{
    private $service;

    public function init()
    {
        $this->service = new HomeService();
    }
    /*
     * 创建活动
     */
    public function actionLoginjudge(){
        $data = $this->service->LoginJudge();
        return $data;

    }

}
