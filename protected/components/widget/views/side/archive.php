<div class="sidebar">
	<div class="box-heading"><?php echo ($this->myController == "video" ? "Gallery" : "Articles"); ?> <span>Archive</span></div>
	<ul class="sidenav">
		<?php $listYears = $model->getYearList(); ?>
		<?php foreach ($listYears as $itemY): ?>

			<li class="<?php echo ($year == $itemY->year) ? 'selected' : ''; ?>">
				<a href="<?php echo Yii::app()->createAbsoluteUrl($myController . '/list', array('year' => $itemY->year)); ?>"><?php echo $itemY->year; ?> (<?php echo $model->countPostInYear($itemY->year); ?>)</a>
				<?php if ($year == $itemY->year): ?>
					<ul>
						<?php $listMonthOfYear = $model->getMonthListOfYear($itemY->year); ?>
						<?php foreach ($listMonthOfYear as $itemM): ?>
							<li>
								<a href="<?php echo Yii::app()->createAbsoluteUrl($myController . '/list', array('year' => $itemY->year, 'month' => $itemM->month)); ?>"><?php echo $itemM->month; ?> (<?php echo $model->countPostOfMonthInYear($year,$itemM->month); ?>)</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
