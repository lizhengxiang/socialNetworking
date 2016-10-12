<?php
namespace app\services;
use Yii;
use app\models\Tools;
use yii\db\ActiveRecord;
/**
 * Created by PhpStorm.
 * User: 'lizhengxiang'
 * Date: 16-10-11 下午2:41
 * content：活动相关模块
 */

class ActivitiesService
{
    private $tools;

    public function createActivities($args)
    {
        $this->tools = new Tools();
        $userid = Yii::$app->user->getId();
        if($userid != null){
            $tag = 0;
            //列名称
            $columnName = '';
            $name = 'a'.md5(rand(1,100).time());
            $authorization = md5($name);
            $sql = "CREATE TABLE ".$name."(`id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'ID',";
            foreach ($args as $key => $value){
                if($tag % 2 == 0){
                    if('' == $value){
                        //表示字段名不能为空
                        return $this->tools->result('',5,0);
                    }
                    $sql =$sql.$key." char(100) NOT NULL DEFAULT '' COMMENT '".$value."',";
                    $columnName = $columnName.$key.'-'.$value.',';
                }
                $tag++;
            }
            $sql = $sql." PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='活动表';";
            $activitiesname = "活动测试";
            //开启事物，万一一个表插入成功，另一个表不成功怎么办，字段名称用逗号隔开
            $tr = Yii::$app->db->beginTransaction();
            try {
                /*Yii::$app->db->createCommand($sql)
                    ->execute();*/
                Yii::$app->db->createCommand('insert INTO activities(userid,tablename,activitiesname,`column`,`authorization`) VALUES (:userid,:tablename,:activitiesname,:colum,:autho)',[
                    ':userid' => $userid,':tablename' => $name,':activitiesname' => $activitiesname,':colum' => $columnName,'autho'=>$authorization
                ])->execute();
                $tr->commit();
                return $this->tools->result('',1,0);
            } catch (Exception $e) {
                $tr->rollBack();
            }
        }else{
            return $this->tools->result('',0,0);
        }
    }

    public function getActivities($args){
        $this->tools = new Tools();
        $userid = Yii::$app->user->getId();
        $offset = isset($args['offset'])?$args['offset']:0;
        $limit = isset($args['limit'])?$args['limit']:10;
        if(!preg_match('/^\d*$/',$offset) || !preg_match('/^\d*$/',$limit)){
            return $this->tools->result('',10,0);
        }
        if($userid != ''){
            $count = (new \yii\db\Query())
                ->select(['id', 'activitiesname','authorization','authorization','createtime','deleted'])
                ->from('activities')
                ->where(['userid'=>$userid])
                ->count();
            $result = (new \yii\db\Query())
                ->select(['id', 'activitiesname','authorization','authorization','createtime','deleted'])
                ->from('activities')
                ->limit($limit)
                ->offset($offset)
                ->where(['userid'=>$userid])
                ->all();
            $data=[];
            $data['total'] = $count;
            $data['rows'] = $result;
            return $data;
        }else{
            return $this->tools->result('',0,0);
        }
    }

    //获取报名详情
    public function Getdetails($args){
        $this->tools = new Tools();
        $userid = Yii::$app->user->getId();
        $offset = isset($args['offset'])?$args['offset']:0;
        $limit = isset($args['limit'])?$args['limit']:10;
        if(!preg_match('/^\d*$/',$offset) || !preg_match('/^\d*$/',$limit)){
            return $this->tools->result('',10,0);
        }
        if($userid != ''){
            $count = (new \yii\db\Query())
                ->select(['id', 'activitiesname','authorization','authorization','createtime','deleted'])
                ->from('activities')
                ->where(['userid'=>$userid])
                ->count();
            $result = (new \yii\db\Query())
                ->select(['id', 'activitiesname','authorization','authorization','createtime','deleted'])
                ->from('activities')
                ->limit($limit)
                ->offset($offset)
                ->where(['userid'=>$userid])
                ->all();
            $data=[];
            $data['total'] = $count;
            $data['rows'] = $result;
            return $data;
        }else{
            return $this->tools->result('',0,0);
        }
    }
    
    public function getColumn($args){
        
    }

}