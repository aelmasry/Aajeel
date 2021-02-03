<header id="header">
    <h1 class="hide"><?php echo $articel['Article']['title'] ?></h1>
    <h2 class="hide"><?php echo $articel['Source']['name'] ?> </h2>
    <h3 class="hide"><?php echo __('3ajeel', true) ?> </h3>
    <div class="hide">
        <?php echo $articel['Article']['content'] ?>
    </div>
</header>
<style> 
body {overflow:hidden;}
iframe { background-color: transparent;}
</style>
 <?php 
	/* 
<div class="small-12 medium-12 large-12 columns IframeBarWrap">
   
	<div class="NewsBox">
    <!-- News Data Start -->
    <div class="NewsWrap iframeBar">
        <div id="ShareModal<?php echo $articel['Article']['id']; ?>" class="reveal-modal small">
            <div class="AgancyImg">
                <img src="<?php echo $this->request->webroot ?>img/sources/<?php echo $articel['Source']['logo'] ?>" alt="<?php echo $articel['Source']['name'] ?>"/>
            </div>
            <div class="NewsTitle">
                <h3><?php echo $articel['Article']['title'] ?></h3>
            </div>
            <div class="clearfix"></div>
            <div class="ShareBox">
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
            <a class="ShareIcon" data-id="ShareModal<?php echo $articel['Article']['id']; ?>" href="javascript:void(0)" >Share</a>
        </div>
        
        <!--<div class="clearfix"></div>-->
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
        
    </div>
</div>

</div>
*/ ?>
</div>

    <iframe name="I1" id="floating_iframe" src="<?php echo $articel['Article']['permalink']; ?>" width="100%" height="500" sandbox="allow-forms allow-scripts" frameborder="0" name="I1" >
      المتصفح الخاص بك لا يدعم خاصية فتح المواقع فى ايطار خارجى
    </iframe>
<!--  </div>  -->
