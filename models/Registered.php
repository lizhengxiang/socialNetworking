<?php
namespace app\models;

use yii\db\ActiveRecord;

class Registered extends ActiveRecord
{

    public function rules()
    {
        return[
            [['provinces', 'school','email','nickname','year','mouth','day'], 'required'],
            ['email', 'email'],

        ];
    }
}
