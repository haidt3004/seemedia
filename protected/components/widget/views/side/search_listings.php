<div class="search-listing">
	<div class="box-heading">Search <span>Listings</span></div>
	<div class="search-listing-content">
		<?php
		$form = $this->beginWidget('CActiveForm', array(
			'action' => Yii::app()->createAbsoluteUrl('listing/search'),
			'method' => 'get',
//			'enableAjaxValidation' => false,
			'enableClientValidation' => true,
			'clientOptions' => array(
				'validateOnSubmit' => true,
			),
			'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'advance-search-listing-form'),
		));
		?>
		<div class="sl-label"><?php echo Yii::t('translation', "I am looking for a"); ?><span class="star">*</span></div>

		<?php
		echo $form->dropDownList($model, 'category_id', $model->getArrCategory(), array(
			'class' => 'sl-selectbox',
			'prompt' => 'Select',
			'onChange' => 'listing.onCategoryChangeAdvanceSearch($(this))',
			'data-className' => 'sl-selectbox',
			'data-action' => Yii::app()->createAbsoluteUrl('ajax/oncategorychangeadvancesearch')));
		?>
		<?php echo $form->error($model, 'category_id'); ?>
		<div class="sl-label"><?php echo Yii::t('translation', "for my"); ?></div>
		<div id="listing-audience">
			<?php $audiences = !empty($model->category_id) ? $model->getAudiencesBaseOnCategory() : array(); ?>
			<?php
			echo $form->dropDownList($model, 'audience', $audiences, array(
				'class' => 'sl-selectbox',
				'data-className' => 'sl-selectbox',
				'prompt' => 'Select',
				'onChange' => 'listing.onAudienceChangeAdvanceSearch($(this))',
				'data-action' => Yii::app()->createAbsoluteUrl('ajax/OnAudienceChangeAdvanceSearch')));
			?>
		</div>

		<div class="sl-label"><?php echo Yii::t('translation', "for"); ?></div>
		<div id="listing-specialty">
			<?php $specialty = !empty($model->audience) ? $model->getArrSpecialtyBaseOnSelectedAudience($model->category_id, $model->audience) : array(); ?>
			<?php echo $form->dropDownList($model, 'specialty', $specialty, array('class' => 'sl-selectbox', 'prompt' => 'Select')); ?>
		</div>

		<div class="sl-label"><?php echo Yii::t('translation', "specifically on"); ?></div>
		<?php echo $form->textField($model, 'tags', array('class' => 'sl-input', 'maxlength' => 255, 'placeholder' => '')); ?>

		<div class="sl-label">Location</div>
		<div class="sl-label">
			<?php
			echo $form->radioButtonList($model, 'location', $model->getListLocation(), array(
				'data-action' => Yii::app()->createAbsoluteUrl('ajax/onlocationchange'),
				'onChange' => 'listing.onLocationChange($(this))',
				'template' => '{input} {label}&nbsp;&nbsp;&nbsp;&nbsp;',
				'separator' => ''
			));
			?>
		</div>

		<div class="link-btn">
			<a class='inline' href="#modalChooseLocation" >Choose Location</a>
			<?php include '_choose_location_as.php'; ?>
		</div>

		<div class="sl-label">Keyword</div>
		<?php echo $form->textField($model, 'keyword', array('class' => 'sl-input')); ?>
		<input class="sl-search-btn" type="submit" value="Search">
		<?php $this->endWidget(); ?>
	</div>
</div> 