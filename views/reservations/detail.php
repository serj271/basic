<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Customer;
use app\models\Reservation;

$urlReservationsByCustomer = Url::to(['reservations/ajax-drop-down-list-by-customerid']);
$this->registerJs( <<< EOT_JS
	$(document).on('change', '#reservation-customer_id', function(ev) {
		$('#detail').hide();
		var customerId = $(this).val();
		$.get(
			'{$urlReservationsByCustomer}',
			{ 'customer_id' : customerId },
			function(data) {
				data = '<option value="">--- choose</option>'+data;
				$('#reservation-id').html(data);
			}
		)
		ev.preventDefault();
	});
	$(document).on('change', '#reservation-id', function(ev) {
		$(this).parents('form').submit();
		ev.preventDefault();
	});
EOT_JS
);
?>
<h1>reservation/detailDependentDropdown</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<div class="customer-form">
	<?php $form = ActiveForm::begin(['enableAjaxValidation' => false,
		'enableClientValidation' => false, 'options' => ['data-pjax' => '']]); ?>
	<?php $customers = Customer::find()->all(); ?>
	<?= $form->field($model, 'customer_id')->dropDownList(ArrayHelper::map( $customers,
		'id', 'nameAndSurname'), [ 'prompt' => '--- choose' ]) ?>
	<?php $reservations = Reservation::findAll(['customer_id' => $model->customer_id]);	?>
	<?= $form->field($model, 'id')->label('Reservation ID')->dropDownList(ArrayHelper::map( $reservations, 'id', function($temp, $defaultValue) {
	$content = sprintf('reservation #%s at %s', $temp->id, date('Y-m-d H:i:s',
		strtotime($temp->reservation_date)));
	return $content;
	}), [ 'prompt' => '--- choose' ]); ?>
	<div id="detail">
		<?php if($showDetail) { ?>
		<hr />
		<h2>Reservation Detail:</h2>
		<table>
			<tr>
			<td>Price per day</td>
			<td><?php echo $model->price_per_day ?></td>
			</tr>
		</table>
		<?php } ?>
	</div>
	<?php ActiveForm::end(); ?>
</div>
