<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = 'About Us';
?>
<div class="site-about">
    <h1><?= Html::encode($this->params[breadcrumbs][1]) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>
</div>
