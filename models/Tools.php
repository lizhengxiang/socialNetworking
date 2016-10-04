<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
class Tools
{
    public function tool($args)
    {
        return $args = new ActiveRecord;
    }

    /*
     * 获取当前用户的动态内容及点赞次数，转发次数，举报次数
     * @todo 获取当前用户的头像等信息，看看会不会影响速度
     */
    public function searchDynamic($args){
        $offset = isset($args['pageNo'])? $args['pageNo']: 1 ;
        $limit = isset($args['pageSize'])? $args['pageSize']: 15;
        unset($args['pageNo']);
        unset($args['pageSize']);
        $userid = isset($args['userid'])?explode(',',$args['userid']):Yii::$app->user->getId();

        return $userid;


    }

}