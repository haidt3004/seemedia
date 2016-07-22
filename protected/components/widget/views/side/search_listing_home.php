<style>
    .searchWrapper #advance-search-listing-form > div {
        display: inline;
    }
</style>
<div class="searchWrapper">
    <div class="container">
        <h2><?php echo Yii::t('translation', "I am looking for a"); ?>...</h2>
        <div class="search-container">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                    'action' => Yii::app()->createAbsoluteUrl('listing/search'),
                    'method' => 'get',
                    'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'advance-search-listing-form'),
            ));
            ?>
		<?php
		echo $form->dropDownList($model, 'category_id', $model->getArrCategory(), array(
			'class' => 'select-search',
                        'data-className' => 'select-search',
			'prompt' => 'Select',
			'onChange' => 'listing.onCategoryChangeAdvanceSearch($(this))',
			'data-action' => Yii::app()->createAbsoluteUrl('ajax/oncategorychangeadvancesearch')));
		?>
                <?php echo $form->error($model, 'category_id'); ?>
                <div class="search-for"><?php echo Yii::t('translation', "for my"); ?>...</div>
                <div id="listing-audience">
			<?php $audiences = !empty($model->category_id) ? $model->getAudiencesBaseOnCategory() : array(); ?>
			<?php
			echo $form->dropDownList($model, 'audience', $audiences, array(
			'class' => 'select-search',
                        'data-className' => 'select-search',
			'prompt' => 'Select',
			'onChange' => 'listing.onAudienceChangeAdvanceSearch($(this))',
			'data-action' => Yii::app()->createAbsoluteUrl('ajax/OnAudienceChangeAdvanceSearch')));
			?>
		</div>
                <div class="search-for"><?php echo Yii::t('translation', "for"); ?>...</div>
                <div id="listing-specialty">
			<?php $specialty = !empty($model->audience) ? $model->getArrSpecialtyBaseOnSelectedAudience($model->category_id,$model->audience) : array(); ?>
			<?php echo $form->dropDownList($model, 'specialty', $specialty, array('class' => 'select-search', 'data-className' => 'select-search', 'prompt' => 'Select')); ?>
		</div>
                <input type="submit" class="search-btn2" value="Search">
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>