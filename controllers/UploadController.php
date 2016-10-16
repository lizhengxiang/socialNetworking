<?php
/**
 * Created by PhpStorm.
 * User: 'lizhengxiang'
 * Date: 16-10-16 下午10:14
 * content：　上传图片
 */

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\UploadForm;
use yii\web\UploadedFile;

class UploadController extends Controller
{
    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($name = $model->upload()) {
                // 文件上传成功
                return $name;
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
}
