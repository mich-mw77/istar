<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\PhoneBook\models\User */
/* @var $phones array */

$fullName = $model->first_name . ' ' . $model->last_name;
$this->title = 'Редактировать контакт: ' . $fullName;
$this->params['breadcrumbs'][] = ['label' => 'Контакты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $fullName];
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'phones' => $phones,
    ]) ?>

</div>
