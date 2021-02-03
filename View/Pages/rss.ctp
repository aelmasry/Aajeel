<div class="small-12 medium-7 large-8 columns">
<div class="NewsBox">
    <!-- News Data Start -->
    <div class="NewsWrap iframeBar">
        
        <div class="NewsData">
        <div class="NewsTitle">
            <h1> <?php echo __('3ajeel', true); ?> RSS </h1>
            <div class="article fullpage rsspage">
            <ul>
                <?php foreach ($countries as $country) : ?>  
                <li>
                    <a href="<?php echo $this->Html->url(array('controller'=> 'country', 'action'=> $country['Country']['alias'], 'rss')); ?>" target="_blank"><?php echo __('news').' '.$country['Country']['name']; ?> </a>
                    <div class="addToSites">
                        <a href="http://add.my.yahoo.com/rss?url=<?php echo $this->Html->url(array('controller'=> 'country', 'action'=> $country['Country']['alias'], 'rss')); ?>" target="_blank">
                            <img src="<?php echo $this->webroot ?>img/addtomyyahoo.gif" alt="">
                        </a><a href="http://fusion.google.com/add?feedurl=<?php echo $this->Html->url(array('controller'=> 'country', 'action'=> $country['Country']['alias'], 'rss')); ?>" target="_blank">
                            <img src="<?php echo $this->webroot ?>img/addGooGle.gif" alt="">
                        </a><a href="http://www.live.com/?add=<?php echo $this->Html->url(array('controller'=> 'country', 'action'=> $country['Country']['alias'], 'rss')); ?>" target="_blank">
                            <img src="<?php echo $this->webroot ?>img/addtoMsn.gif" alt="">
                        </a>
                        <a href="<?php echo $this->Html->url(array('controller'=> 'country', 'action'=> $country['Country']['alias'], 'rss')); ?>" target="_blank">
                            <img src="<?php echo $this->webroot ?>img/rssBtn.gif" alt="">
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>    
            </ul>


        </div>
        </div>
        </div>
 </div>
 </div>
 </div>
