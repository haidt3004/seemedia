<div class="onefourth">
    <div class="home-search-head"><?php echo Yii::t('translation', "Most Popular Searches"); ?></div>
</div>
<div class="threefourthslast">
    <ul class="search-topics">
        <?php 
        foreach ($list_most_search as $val) {
            $link = url('listing/search', array('Listings[category_id]' => $val->category_id, 'Listings[audience]' => $val->audience_id, 'Listings[specialty]' => $val->specialty_id));
            $name = $val->getSpecName() . " " . $val->getCateName() . " for " . $val->getAudienceName();
        ?>
            <li><a href="<?php echo $link; ?>"><?php echo $name; ?></a></li>
        <?php } ?>
    </ul>
</div>