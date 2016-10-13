<?php
namespace app\services;
use Yii;
use app\models\Tools;
use app\models\Excel;
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
            $sql = "CREATE TABLE example.".$name."(`id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'ID',";
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
                Yii::$app->db->createCommand($sql)
                    ->execute();
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

    /*
     * 获取创建的活动　2016-10-12 23:44
     */
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
                ->orderBy('createtime DESC')
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
        $id = isset($args['id'])?$args['id']:-1;
        if($id == -1||!preg_match('/^\d*$/',$id)){
            return $this->tools->result('',10,0);
        }
        if($userid != ''){
            $row = (new \yii\db\Query())
                ->select(['userid', 'tablename'])
                ->from('activities')
                ->where('id=:id')
                ->addParams([':id' => $id])
                ->one();
            //这里判断下是不是该用户自己创建的活动
            if($row['userid'] != $userid){
                return $this->tools->result('',10,0);
            }
            $count = (new \yii\db\Query())
                ->from('example.'.$row['tablename'])
                ->count();
            $result = (new \yii\db\Query())
                ->from('example.'.$row['tablename'])
                ->limit($limit)
                ->offset($offset)
                ->all();
            $data=[];
            $data['total'] = $count;
            $data['rows'] = $result;
            return $data;
        }else{
            return $this->tools->result('',0,0);
        }
    }

    /*
     * 获取表列　2016-10-12 23:44
     */
    public function getColumn($args){
        $this->tools = new Tools();
        $userid = Yii::$app->user->getId();
        $id = isset($args['id'])?$args['id']:-1;
        if($id == -1||!preg_match('/^\d*$/',$id)){
            return $this->tools->result('',10,0);
        }
        if($userid != ''){
            $row = (new \yii\db\Query())
                ->select(['userid', 'column'])
                ->from('activities')
                ->where('id=:id')
                ->addParams([':id' => $id])
                ->one();
            //这里判断下是不是该用户自己创建的活动
            if($row['userid'] != $userid){
                return $this->tools->result('',10,0);
            }
            $column = explode(',',$row['column']);
            $len = sizeof($column);
            $data=[];
            //$len-1是应为多一个逗号
            for ($i = 0; $i < $len-1; $i++){
                $data[$i] = explode('-',$column[$i]);
            }
            return $this->tools->result($data,1,0);
        }else{
            return $this->tools->result('',0,0);
        }
    }
    /**
     * User: 'lizhengxiang'
     * Date:16-10-13 10:55
     * content：
     */
    public function Export($args){
        $excel = new Excel();

        $data = array(
            array('姓名','标题','文章','价格','数据5','数据6','数据7'),
            array('数据1','数据2','数据3','数据4','数据5','数据6','数据7'),
            array('数据1','数据2','数据3','数据4','数据5','数据6','数据7'),
            array('数据1','数据2','数据3','数据4','数据5','数据6','数据7'),
            array('数据1','数据2','数据3','数据4','数据5','数据6','数据7'),
            array('数据1','数据2','数据3','数据4','数据5','数据6','数据7')
        );

        $excel->download('testcsv.csv', $data);
    }
}