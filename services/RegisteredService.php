<?php
namespace app\services;
use Yii;
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
        $parentid = isset($args['parentid'])? $args['parentid']: 0 ;
        return $posts = Yii::$app->db->createCommand('SELECT name, id FROM school WHERE parentid=:parentid')
            ->bindValue(':parentid', $parentid)
            ->queryAll();
    }

}