<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\PhoneBook\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $phones \app\modules\PhoneBook\models\UserPhone */
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'form']); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_birth')->widget(DatePicker::classname(), [
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-m-d'
        ]
    ])
    ?>

    <div id="phones">
        <div id="div_phone_0"><label class="control-label" for="user-date_of_birth">Номер</label>
            <input pattern="([+])?[0-9]{10,12}" id="phone_0" class="form-control" type="tel"
                   name="User[newPhones][0]" required>
            <a onclick="deletePhoneInput(0)" class="deletePhoneInput">Удалить</a>
        </div>
    </div>

    <div class="form-group">
        <?= Html::button(' Добавить номер', ['class' => 'btn btn-success', 'onclick' => 'addInput();']) ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>

<script>
    let phoneId = 0;
    let phones = [];

    $(document).ready(function () {
        phones = <?php echo json_encode($phones); ?>;

        phones.forEach(element => {
            if (phoneId !== 0) {
                addInput();
            }
            $("#phone_" + phoneId).val(element);
            phoneId++;
        });
    })

    function addInput() {
        let input = '<div id="div_phone_' + phoneId + '">' +
            '<label class="control-label" for="user-date_of_birth">Номер</label>' +
            '<input pattern="([+])?[0-9]{10,12}" id="phone_' + phoneId + '" class="form-control"  type="tel" name="User[newPhones][' + phoneId + ']"/>' +
            '<a onclick="deletePhoneInput(' + phoneId + ')" class="deletePhoneInput" >Удалить</a>' +
            '</div>';

        $("#phones").append(input);
    }

    function deletePhoneInput(phoneId) {
        $("#div_phone_" + phoneId).remove();
    }
</script>
