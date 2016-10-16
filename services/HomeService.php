<?php

namespace app\services;
use Yii;
use app\models\Tools;
use app\models\Excel;
use yii\db\ActiveRecord;
/**
 * Created by PhpStorm.
 * User: 'lizhengxiang'
 * Date: 16-10-16 下午11:00
 * content：主页，发帖等操作
 */

class HomeService
{
    private $tools;
    
    /*
     * 判断登陆　2016-10-12 23:44
     */
    public function LoginJudge(){
        $this->tools = new Tools();
        $userid = Yii::$app->user->getId();
        if($userid != ''){
            //表示当前用户已经
            return $this->tools->result(1,1,0);
        }else{
            return $this->tools->result(0,1,0);
        }
    }


    
}