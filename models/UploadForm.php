<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $name = md5(rand(1,100).time()).'.'.$this->imageFile->extension;
            $this->imageFile->saveAs('uplo/' . $name);
            return '/uplo/'.$name;
        } else {
            return false;
        }
    }
}