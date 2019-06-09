<?php
namespace app\components;
use Yii;
use yii\web\Controller;
use yii\grid\GridView;


class GridViewReservation extends GridView
{
	public function renderTableFooter()
	{
		// Search column for 'price_per_day'
		$columnPricePerDay = null;
		foreach($this->columns as $column)
		{
			if(get_class($column) == 'yii\grid\DataColumn')
			{
				if($column->attribute == 'customer_id') {
					
				}
			}
		}
		$html = '<tfoot><tr>';
		$html .= '<td colspan="3"><b>Average:</b></td>';
		$html .= '-----------------footer---------';
		$html .= '<td colspan="4"><i>this space is intentionally empty</i></td>';
		$html .= '</tr></tfoot>';
		return $html;
	}
	/* public function renderTableHeader(){
		return '<theader>jj</theader>';
	} */
}
