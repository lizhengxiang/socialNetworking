<?php
namespace app\services;
use Yii;
use app\models\Tools;
use yii\db\ActiveRecord;

/**
 * @author Bill <lizhengxiang@huoyunren.com>
 * 2016-10-06
 */
class DynamicService
{
    private $tools;
    /*
     * 获取自己发表的动态和别人发表的动态
     * 获取当前用户的动态内容及点赞次数，转发次数，举报次数
     * @todo 获取当前用户的头像等信息，看看会不会影响速度
     */
    public function searchDynamic($args)
    {
        $this->tools = new Tools();

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
         * @todo 计算时间有可能会耗时，dai观察看看会不会影响速度
         */
        $user =  Yii::$app->user->getId();
        if(!empty($user)){
            $len = sizeof($result);
            for ($i=0; $i<$len; $i++){
                $dynamicId = $result[$i]['id'];
                $row = (new \yii\db\Query())
                    ->select(['reportNum', 'praise','forwardingNum'])
                    ->from('dynamiclog')
                    ->where(['userid' => $user,'dynamicId'=>$dynamicId])
                    ->one();
                if(!empty($row)){
                    $result[$i]['reportNumTag'] = $row['reportNum'];
                    $result[$i]['praiseTag'] = $row['praise'];
                    $result[$i]['forwardingNumTag'] = $row['forwardingNum'];
                    $startdate=strtotime($result[$i]['createtime']);
                    $enddate=time();
                    $result[$i]['time'] = $this->tools->timeDifference($startdate,$enddate);
                }else{
                    $startdate=strtotime($result[$i]['createtime']);
                    $enddate=time();
                    $result[$i]['time'] = $this->tools->timeDifference($startdate,$enddate);
                    $result[$i]['reportNumTag'] =0;
                    $result[$i]['praiseTag'] = 0;
                    $result[$i]['forwardingNumTag'] =0;
                }
            }
        }else{
            $len = sizeof($result);
            for ($i=0; $i<$len; $i++){
                $startdate=strtotime($result[$i]['createtime']);
                $enddate=time();
                $result[$i]['time'] = $this->tools->timeDifference($startdate,$enddate);
                $result[$i]['reportNumTag'] =0;
                $result[$i]['praiseTag'] = 0;
                $result[$i]['forwardingNumTag'] =0;
            }
        }
        $request['code'] = 0;
        $request['status'] = 1;
        $request['data'] = $result;
        return $request;
    }


    /*
     * 处理点赞等操作
     */
    public function doEevaluation($args){
        //检查该用户是否第一次操作
        $count = (new \yii\db\Query())
            ->from('dynamiclog')
            ->where('dynamicId=:dynamicId and userid=:userid')
            ->addParams([':dynamicId' => $args['id'],':userid' => Yii::$app->user->getId()]);
        if($args['type'] == 1){
            $count->andWhere('praise=1');
        }
        $count->all();
        var_dump($count);exit();
    }
    /*
     * 点赞，举报，转发
     */
    public function evaluation($args){
        if($args['arg']=='like' && preg_match('/^\d*$/',$args['id'])){
            //更具id和类型来操作更新数据 type=1表示点赞
            $args['type'] = 1;
            $this->doEevaluation($args);
            return $args;
        }else{
            //表示该用户在做非法操作，暂时status=10表示非法操作
            //@todo 考虑要不要对非法操作用户非法操作一天达到多少次，锁定该用户的账号30min
            $request['code'] = 0;
            $request['status'] = 10;
            return json_encode($request);
        }
    }

}