<?php

use kartik\date\DatePicker;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\PhoneBook\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Контакты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать контакт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'summary' => "",
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'first_name',
            'last_name',
            'email:email',
            'date_of_birth',
            [
                'attribute' => 'date_of_birth',
                'value' => 'date_of_birth',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_of_birth',
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-m-d'
                    ]
                ]),
                'format' => 'html',
            ],
            [
                'attribute' => 'searchPhone',
                'label' => 'Номера',
                'filter' => Html::input('text', 'UserSearch[searchPhone]', $searchModel->searchPhone, ['class' => 'form-control']),
                'value' => function ($model) {
                    $userPhones = $model->userPhones;
                    $phoneString = '';
                    foreach ($userPhones as $key => $userPhone) {
                        $phoneString .= $userPhone->phone;
                        if (array_key_last($userPhones) !== $key) {
                            $phoneString .= ', ';
                        }
                    }

                    return $phoneString;
                },
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>

</div>
