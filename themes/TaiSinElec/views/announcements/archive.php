<div class="mainchild">
    <div class="wrapper clearfix fullwidth">
        <!-- News banner -->
        <?php $this->widget('BannerWidget',array('group_banner_id' => ANNOUNCEMENT_BANNER,'layout' => 'inner_page_banner')); ?>
        <!-- End News banner -->

        <div class="colleft">
            <div class="box-last-news">
                <div class="page-header-left">
                    <?php echo TextMultilangHelper::label('announcement'); ?>
                </div>
                <ul class="submenu">
                    <?php
                    $current_year = date_format(date_create($start_date), "Y");
                    $current_month_active = date_format(date_create($start_date), "n");
                    $current_month = date_format(date_create($start_date), "F");

                    foreach (Announcement::getTimeExist() as $key => $value) { ?>

                        <li class="<?php echo $current_year == $key ? 'active' : ''; ?> <?php echo !$active_month ? 'active-year' : ''; ?>">
                            <a href="<?php echo Yii::app()->createAbsoluteUrl('announcements/archive',array('year' => $key ));?>"><i class="fa fa-caret-right"></i><?php echo $key; ?></a>
                            <ul>
                                <?php foreach ($value as $item) { ?>
                                    <li class="<?php echo ($current_month_active == $item && $current_year == $key && $active_month) ? 'active' : ''; ?>">
                                        <a href="<?php echo Yii::app()->createAbsoluteUrl('announcements/archive',array('year' => $key, 'month' => $item ));?>">
                                            <i class="fa fa-caret-right"></i><?php echo TextMultilangHelper::label(strtolower(DateTime::createFromFormat('!m', $item)->format('F'))); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>

                    <?php } ?>
                </ul>
            </div>

        </div>

        <div class="colright maincontent">
            <div class="t-header-org">
                <?php echo ($active_month) ? $current_year . ' - ' . TextMultilangHelper::label(strtolower($current_month)) : $current_year; ?>
            </div>

            <?php

            $next = TextMultilangHelper::label('next');
            $last = TextMultilangHelper::label('last');
            $first = TextMultilangHelper::label('first');
            $previous = TextMultilangHelper::label('previous');
            $widget = $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'ajaxUpdate' => false,
                'id' => 'news-list-view',
                'loadingCssClass' => false,
                'itemView' => '_item',
                'itemsTagName' => 'div',
                'itemsCssClass' => "",
                'pagerCssClass' => 'bottom-pager',
                'template' => "{items}{pager}",
                'enablePagination' => true,
                'pagerCssClass' => 'pagination-box-top',
                'pager' => array(
                    'maxButtonCount' => 3,
                    'header' => false,
                    'firstPageLabel' => "&laquo; " . $first,
                    'prevPageLabel' => "&lsaquo; " . $previous,
                    'nextPageLabel' => $next . " &rsaquo;",
                    'lastPageLabel' => $last . " &raquo;",
                    'nextPageCssClass' => false,
                    'previousPageCssClass' => false,
                    'cssFile' => false,
                    'selectedPageCssClass' => 'selected',
                    'htmlOptions' => array(
                        'class' => 'pagination',
                        'style' => '',
                        'id' => ''
                    ),
                ),
            ));
            ?>
        </div>
    </div><!-- //wrapper -->
</div>

<?php
Yii::app()->clientScript->registerScript('addClassListNews', "
			$('#news-list-view .list-news-item').last().addClass('noborder');
		");
?>

