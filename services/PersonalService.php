<?php
namespace app\services;
use Yii;
use app\models\Tools;
use yii\db\ActiveRecord;

/**
 * @author Bill <lizhengxiang@huoyunren.com>
 * 2016-10-08 23:01
 */
class PersonalService
{
    private $tools;
    /*
     * 获取自己自己或别人的基本信息
     * return 基本信息＋该用户是否是自己（否则返回有没有关注）
     */
    public function GetUserInformation($args)
    {
        $this->tools = new Tools();

        $userid = isset($args['userid'])?$args['userid']:Yii::$app->user->getId();
        if(preg_match('/^\d*$/',$userid)){
            //根据用户userid查找该用户的基本信息
            
        }elseif ($userid == null){
            //如果$userid == null则表示该用户没有登陆，应该提示该用户登陆
            return $this->tools->result('',0,0);
        }
        //表示该用户在做非法操作
        return $this->tools->result('',10,0);
    }
    

}