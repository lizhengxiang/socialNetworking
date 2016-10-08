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
     * 计算时间差,返回时间差
     */

    public function timeDifference($startdate,$enddate){
        $timediff = $enddate-$startdate;
        $days = intval($timediff/86400);
        if($days>0){
            $timeDifference = $days.'天前';
        }else{
            $remain = $timediff%86400;
            $hours = intval($remain/3600);
            if($hours>0){
                $timeDifference = $hours.'小时前';
            }else{
                $remain = $remain%3600;
                $mins = intval($remain/60);
                if($mins>0){
                    $timeDifference = $mins.'分钟前';
                }else{
                    $secs = $remain%60;
                    $timeDifference = $mins.'秒钟前';
                }
            }
        }
        return $timeDifference;
    }

    /*
     * 封装返回的结果
     * $status＝１表示成功，$status＝０表示未登录，$status＝１0非法操作
     * @todo $status＝１0　要不要将该用户进行退出操作，并锁定该用户30min
     */
    public function result($data,$status,$code){
        $result = [];
        $result['code'] = $code;
        $result['status'] = $status;
        $result['data'] = $data;
        return json_encode($result);
    }

    /*
     *更具id和userid检查该用户有没有权限修改帖子的权限
     * return １表示有权限，0表示没有权限
     */

    public function validateDynamic($id){
        $count = (new \yii\db\Query())
            ->from('dynamic')
            ->where('id=:id and userid=:userid')
            ->addParams([':id' => $id,':userid' => Yii::$app->user->getId()]);
        return $val = $count->count();
    }
}