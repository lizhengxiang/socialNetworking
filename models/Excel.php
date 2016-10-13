<?php
/**
 * Created by PhpStorm.
 * User: 'lizhengxiang'
 * Date: 16-10-13 上午10:39
 * content：导出Excel
 */

namespace app\models;
use Yii;
class Excel
{
    function download($file,array $data){
        $path = realpath(dirname(__FILE__) . '/../'.'runtime/file/').'/'.$file;
        $fp = fopen($path, 'w');
        //Windows下使用BOM来标记文本文件的编码方式
        fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        foreach ($data as $line) {
            fputcsv($fp, $line);
        }
        fclose($fp);
        $fp = fopen($path, 'r');
        header('Content-Type: application/octet-stream');
        header("Accept-Ranges: bytes");
        header("Accept-Length: ".filesize($path));
        header('Content-Disposition: attachment; filename="'.$file.'"');
        echo fread($fp,filesize($path));
        fclose($fp);exit;
    }
}