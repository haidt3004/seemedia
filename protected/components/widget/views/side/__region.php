<?php

echo Chtml::checkBoxList('Listings[region]', $model->region, $model->getRegionsBaseOnLocation(), array(
	'data-action' => Yii::app()->createAbsoluteUrl('ajax/onregionchange'),
	'onChange' => 'listing.onRegionChange($(this))', 'template' => '<li>{input} {label}</li>',
	'separator' => ''
));
