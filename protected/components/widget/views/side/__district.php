<?php

echo Chtml::checkBoxList('Listings[district]', $model->district, $model->getArrDistrictBaseOnRegions(), array(
	'template' => '<li>{input} {label}</li>',
	'separator' => ''));
