<?php
namespace app\services;
use Yii;
use app\models\Tools;
/**
 * @author Bill <lizhengxiang@huoyunren.com>
 */
class PersonalService
{
    private $tools;


    /**
     * 获取自己发表的动态
     */
    public function searchDynamic($args)
    {
        $this->tools = new Tools();
        return $this->tools->searchDynamic($args);

    }
    

}