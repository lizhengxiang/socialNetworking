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
     * 查看有没有登陆
     */
    public function actionLoginjudge(){
        $data = $this->service->LoginJudge();
        return $data;

    }

    /**
     * 发帖子
     */
    public function actionPosting()
    {
        $request = Yii::$app->request->post();
        $data = $this->service->Posting($request);
        return $data;
    }

}
