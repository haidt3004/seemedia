<div class="mainchild">

    <div class="wrapper clearfix fullwidth">

        <!-- Documentation banner -->

        <?php $this->widget('BannerWidget',array('group_banner_id' => POLICY_ORG_CHART_BANNER,'layout' => 'inner_page_banner')); ?>

        <!-- End Documentation banner -->



        <div class="maincontent">

            <div class="t-header-org">

                <?php

                $current_year = date_format(date_create($start_date), "Y");

                $current_month = date_format(date_create($start_date), "F");

                echo $current_year . ' - ' . $current_month;

                ?>

            </div>

            <?php

            $widget = $this->widget('zii.widgets.CListView', array(

                'dataProvider' => $dataProvider,

                'ajaxUpdate' => false,

                'id' => 'news-list-view',

                'loadingCssClass' => false,

                'itemView' => '_item',

                'itemsTagName' => 'div',

                'itemsCssClass' => "",

                'pagerCssClass' => 'bottom-pager',

                'template' => "{pager}{items}{pager}",

                'enablePagination' => true,

                'pagerCssClass' => 'pagination-box-top',

                'pager' => array(

                    'maxButtonCount' => 10,

                    'header' => false,

                    'firstPageLabel' => "&laquo; First",

                    'prevPageLabel' => "&lsaquo; Previous",

                    'nextPageLabel' => "Next &rsaquo;",

                    'lastPageLabel' => "Last &raquo;",

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

