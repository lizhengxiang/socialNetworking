<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4" style="margin-top: 20%">
                <?php $form = ActiveForm::begin(['id' => 'contact-form'] ); ?>
                    <div class="form-group">
                        <input  class="form-control" id="exampleInputEmail1" placeholder="用户名">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="密码">
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-5">
                            <?= Html::submitButton('登陆', ['class' => 'btn btn-primary', 'name' => 'login-login']) ?>
                        </div>
                        <div class="col-lg-offset-1 col-lg-5">
                            <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'login-about']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>
