<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin
 * Date: 02.08.2018
 * Time: 14:57
 */

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */
/* @var $addedTransactions int */
/* @var $sentEmails int */

?>

<h2>Выберите excel-файл для загрузки</h2>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'excelFile')->fileInput() ?>

<button>Submit</button>

<?php ActiveForm::end() ?>


<?php if ($addedTransactions): ?>
<h3>Проведено транзакций: <?= $addedTransactions ?></h3>
<h3>Отправлено писем: <?= $sentEmails ?></h3>
<?php endif ?>