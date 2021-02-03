<div class="small-12 medium-7 large-8 columns">
<div class="TrendsTitle">
        <h3><?php echo __('Most popular') ?></h3>
</div>
<div class="clearfix"></div>
<div class="TrendsBox">
<div class="Trends">
    <?php foreach ($items as $tag) { ?>    
        <a class="TrendEntry" href="<?php echo $this->Html->url(array('controller'=> 'tag', 'action'=> $tag['Tag']['alias'] )) ?>"><?php echo $tag['Tag']['name'] ?></a>
    <?php } ?>
</div>
</div>
</div>