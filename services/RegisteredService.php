<?php
namespace app\services;
use Yii;
use app\models\Tools;
/**
 * @author Bill <lizhengxiang@huoyunren.com>
 */
class RegisteredService
{
    /**
     * 获取省份，学校
     */
    public function searchProvinces($args)
    {
        $this->tools = new Tools();
        $parentid = isset($args['parentid'])? $args['parentid']: 0 ;
        $posts = Yii::$app->db->createCommand('SELECT name, id FROM school WHERE parentid=:parentid')
            ->bindValue(':parentid', $parentid)
            ->queryAll();
        return $this->tools->result($posts,1,0);
    }

    /*
     * 生成用户的id
     * 规则：（1-2）位年的后两位，（3-4）月，（5-8）本月的累计用户数量，（9-10）最后两位随机数
     */
    public function getUserId($num_id){
        $current_month = substr($num_id,2,2);
        if($current_month == 12){
            $current_month = 1;
        }else{
            $current_month += 1;
        }
        $num_id = substr($num_id,4,4) + 1;
        $num = date("ym");
        $month = date("m");
        if($current_month == $month){
            $num_id = 1;
        }
        $num_id = sprintf("%04d", $num_id);
        $time = time();
        $time = substr($time, -2);
        $time = sprintf("%02d", $time);
        return $members_id = $num.$num_id.$time;
    }
    /*
     * 创建用户
     */
    public function Registered($args){
        $this->tools = new Tools();
        $count = (new \yii\db\Query())
            ->from('registered')->where('email=:email', [':email' => $args['email']])->count();
        if(!$count){
            //查询返回最后一条数据，用来生成userid
            $result = (new \yii\db\Query())->select(['userid'])->from('registered')->orderBy('createtime desc')->one();
            $args['userid'] = $this->getUserId($result['userid']);
            $state = Yii::$app->db->createCommand('INSERT INTO registered (provinces,school,email,nickname,userid,birthday) VALUES (:provinces,:school,:email,:nickname,:userid,:birthday)', [
                ':provinces' => $args['provinces'],
                ':school' => $args['school'],
                ':email' => $args['email'],
                ':nickname' => $args['nickname'],
                ':userid' => $args['userid'],
                ':birthday' => $args['year'].'-'.sprintf("%02d",$args['mouth']).'-'.sprintf("%02d",$args['day'])
            ])->execute();
            return $this->tools->result($state,1,0);
        }else{
            throw new \yii\base\UserException('邮箱已经存在',200);
        }
    }

}