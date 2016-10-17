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

    public function Posting($args){
        $this->tools = new Tools();
        $userid = Yii::$app->user->getId();
        if($userid != ''){
            $data=Yii::$app->db->createCommand('insert INTO dynamic(pic1,pic2,pic3,pic4,content,userid) VALUES (:pic1,:pic2,:pic3,:pic4,:content,:userid)',[
                ':userid' => Yii::$app->user->getId(),':content'=>isset($args['count'])?$args['count']:'',':pic1'=>isset($args['data'][0])?$args['data'][0]:'',':pic2'=>isset($args['data'][1])?$args['data'][1]:'',':pic3'=>isset($args['data'][2])?$args['data'][2]:'',':pic4'=>isset($args['data'][3])?$args['data'][3]:''
            ])->execute();
            return $this->tools->result($data,1,0);
        }else{
            return $this->tools->result('',0,0);
        }
    }

    
}