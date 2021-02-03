<div class="small-12 medium-7 large-8 columns">
    <div class="NewsBox">
        <!-- News Data Start -->
        <div class="NewsWrap">

            <div id="ShareModal" class="reveal-modal small">
                <div class="ShareBox">
                    <div class="AgancyImg">
                        <img src="<?php echo $this->request->webroot ?>img/sources/<?php echo $articel['Source']['logo'] ?>" alt="<?php echo $articel['Source']['name'] ?>"/>
                    </div>
                    <div class="NewsTitle">
                        <h3><?php echo $articel['Article']['title'] ?></h3>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"></div>
                    <div class="ShareTitle">
                        <div class="ShareIcon right"></div>
                        <span><?php echo __('share news by'); ?></span>
                    </div>
                    <div class="ShareIcons">
                        <a class="SharingIcon FB" href="http://www.facebook.com/sharer.php?u=<?php echo Configure::read('App.fullBaseUrl').$this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])) ?>&t=<?php echo $articel['Article']['title'] ?>" rel="nofollow" target="_blank" >Facebook</a>
                        <a class="SharingIcon TW" 
                        href="https://twitter.com/intent/tweet?original_referer=<?php echo Configure::read('App.fullBaseUrl') ?>&text=<?php echo $articel['Article']['title'] ?> &url=<?php echo Configure::read('App.fullBaseUrl').$this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])) ?>" rel="nofollow" target="_blank">Twitter</a>
                        <a class="SharingIcon GP" href="https://plus.google.com/share?url=<?php echo Configure::read('App.fullBaseUrl').$this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])) ?>" data-href="<?php echo Configure::read('App.fullBaseUrl') ?>" rel="nofollow" target="_blank">Google+</a>
                        <a class="SharingIcon IN" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo Configure::read('App.fullBaseUrl').$this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])) ?>&title=<?php echo $articel['Article']['title'] ?>" rel="nofollow" target="_blank">LinkedIn</a>
                        <a class="SharingIcon Mail" ref="mailto: ?s=gmail&?subject=<?php echo $articel['Article']['title'] ?>&body=<?php echo $this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])) ?>">Email</a>
                    </div>
                </div>
                <a class="close-reveal-modal">&#215;</a>
            </div>
            <div class="ActionIcons">
                <a class="ShareIcon" data-id="ShareModal" href="javascript:void(0)" >Share</a>
            </div>
            <div class="NewsData">
                <div class="AgancyImg">
                    <img src="<?php echo $this->request->webroot ?>img/sources/<?php echo $articel['Source']['logo'] ?>" alt="<?php echo $articel['Source']['name'] ?>"/>
                </div>
                <div class="NewsTitle">
                    <a href="<?php echo $this->Html->url(array('controller'=> 'source', 'action'=> $articel['Source']['alias'] )) ?>" title="<?php echo $articel['Source']['name']?> ">
                        <?php echo $articel['Source']['name']?> 
                    </a> &nbsp; <span><?php echo $this->Html->relativeTime($articel['Article']['publish_up']); ?></span>
                    <h1><?php echo $articel['Article']['title'] ?></h1>
                </div>
                <!--<div class="clearfix"></div>-->
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div id="content">
                <?php echo $articel['Article']['content'] ?>
                <p>&nbsp;</p><p>&nbsp;</p>
                <p style="float: left"> <a class="readMoreBtn" target="_black" href="<?php echo $articel['Article']['permalink'] ?>">الخبر من المصدر</a> </p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            </div>
            
        </div>
        
    </div>
    
</div>
