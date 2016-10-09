<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\services\PersonalService;
class PersonalController extends Controller
{
    /**
     * @author Bill <lizhengxiang@huoyunren.com>
     * 2016-10-08 23:01
     */

    private $service;
    
    public function init()
    {
        $this->service = new PersonalService();
    }

    /*
     * @author Bill <lizhengxiang@huoyunren.com>
     * 2016-10-08 23:21
     * 获取自己自己或别人的基本信息
     */
    public function actionGetuserinformation(){
        $request = Yii::$app->request->post();
        $data = $this->service->GetUserInformation($request);
        return $data;
    }

    /*
     * @author Bill <lizhengxiang@huoyunren.com>
     * 2016-10-09 17:26
     * 给主页点赞
     */
    public function actionThumbup(){
        $request = Yii::$app->request->post();
        $data = $this->service->thumbUp($request);
        return $data;
    }

}
