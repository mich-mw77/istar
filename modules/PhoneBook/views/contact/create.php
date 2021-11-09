<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\PhoneBook\models\User */
/* @var $phones array */

$this->title = 'Создать контакт';
$this->params['breadcrumbs'][] = ['label' => 'Контакты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'phones' => $phones,
    ]) ?>

</div>
