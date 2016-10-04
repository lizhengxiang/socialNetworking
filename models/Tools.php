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
        $rows = (new \yii\db\Query())
            ->select(['dynamic.id','dynamic.userid','content',
                'pic1','pic2','pic3','pic4','dynamic.createtime','praise','forwardingNum','reportNum','registered.headPortrait','registered.backgroundImage',
                'registered.motto','registered.nickname','registered.birthday','registered.gender','school.name as school'])
            ->from('dynamic')
            ->join('LEFT JOIN', 'registered', 'registered.userid = dynamic.userid')
            ->join('LEFT JOIN', 'school', 'registered.school = school.id');
        $rows->where('dynamic.deleted=0');
        if(isset($userid)){
            $rows->andWhere(['dynamic.userid'=>$userid]);
        }
        $result = $rows ->offset($offset-1)->limit($limit)->all();

        /*
         * 这里需要处理该用户有没有登陆判断有没有对动态操作AND动态发表离当前时间
         * @todo 计算时间有可能会耗时，带观察看看会不会影响速度
         */
        if(!empty(Yii::$app->user->getId())){
            $len = sizeof($result);
            $user = Yii::$app->user->getId();
            for ($i=0; $i<$len; $i++){
                $dynamicId = $result[$i]['id'];
                $row = (new \yii\db\Query())
                    ->select(['reportNum', 'praise','forwardingNum'])
                    ->from('dynamiclog')
                    ->where(['userid' => $user,'dynamicId'=>$dynamicId])
                    ->one();
                if(!empty($row)){
                    $result[$i]['reportNum'] = $row['reportNum'];
                    $result[$i]['praise'] = $row['praise'];
                    $result[$i]['forwardingNum'] = $row['forwardingNum'];
                    $startdate=strtotime($result[$i]['createtime']);
                    $enddate=time();
                    $timediff = $enddate-$startdate;
                    $days = intval($timediff/86400);
                    if($days>0){
                        $result[$i]['time'] = $days.'天前';
                    }else{
                        $remain = $timediff%86400;
                        $hours = intval($remain/3600);
                        if($hours>0){
                            $result[$i]['time'] = $hours.'小时前';
                        }else{
                            $remain = $remain%3600;
                            $mins = intval($remain/60);
                            if($mins>0){
                                $result[$i]['time'] = $mins.'分钟前';
                            }else{
                                $secs = $remain%60;
                                $result[$i]['time'] = $mins.'秒钟前';
                            }
                        }
                    }
                }else{
                    $startdate=strtotime($result[$i]['createtime']);
                    $enddate=time();
                    $timediff = $enddate-$startdate;
                    $days = intval($timediff/86400);
                    if($days>0){
                        $result[$i]['time'] = $days.'天前';
                    }else{
                        $remain = $timediff%86400;
                        $hours = intval($remain/3600);
                        if($hours>0){
                            $result[$i]['time'] = $hours.'小时前';
                        }else{
                            $remain = $remain%3600;
                            $mins = intval($remain/60);
                            if($mins>0){
                                $result[$i]['time'] = $mins.'分钟前';
                            }else{
                                $secs = $remain%60;
                                $result[$i]['time'] = $mins.'秒钟前';
                            }
                        }
                    }
                    $result[$i]['reportNum'] =0;
                    $result[$i]['praise'] = 0;
                    $result[$i]['forwardingNum'] =0;
                }
            }
        }else{
            $len = sizeof($result);
            for ($i=0; $i<$len; $i++){
                $startdate=strtotime($result[$i]['createtime']);
                $enddate=time();
                $timediff = $enddate-$startdate;
                $days = intval($timediff/86400);
                if($days>0){
                    $result[$i]['time'] = $days.'天前';
                }else{
                    $remain = $timediff%86400;
                    $hours = intval($remain/3600);
                    if($hours>0){
                        $result[$i]['time'] = $hours.'小时前';
                    }else{
                        $remain = $remain%3600;
                        $mins = intval($remain/60);
                        if($mins>0){
                            $result[$i]['time'] = $mins.'分钟前';
                        }else{
                            $secs = $remain%60;
                            $result[$i]['time'] = $mins.'秒钟前';
                        }
                    }
                }
                $result[$i]['reportNum'] =0;
                $result[$i]['praise'] = 0;
                $result[$i]['forwardingNum'] =0;
            }
        }
        return $result;
    }

}