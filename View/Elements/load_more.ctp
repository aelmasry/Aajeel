<?php $i = 1;
while (list(, $articel) = each($articels)) { ?>
<div class="NewsWrap">
 <div class="NewsDate">
     <a href="<?php echo $this->Html->url(array('controller' => 'source', 'action' => $articel['Source']['alias'])) ?>" title="<?php echo $articel['Source']['name'] ?>">
                <?php echo $articel['Source']['name'] ?> 
            </a> &nbsp; <span><?php echo $this->Html->relativeTime($articel['Article']['publish_up']); ?></span>
            </div>

        <div class="ActionIcons">
            <a class="ShareIcon" data-id="ShareModal<?php echo $articel['Article']['id']; ?>" href="javascript:void(0)" ><?php echo __('Share'); ?></a>
        </div>
        <div class="clearfix"></div>
    <div class="NewsData">
        <div class="AgancyImg">
            <a href="<?php echo $this->Html->url(array('controller' => 'source', 'action' => $articel['Source']['alias'])) ?>" title="<?php echo $articel['Source']['name'] ?>" >
                <img src="<?php echo $this->request->webroot ?>img/sources/<?php echo $articel['Source']['logo'] ?>" alt="<?php echo $articel['Source']['name'] ?>"/>
            </a>
        </div>
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
                    <a class="SharingIcon TW" href="https://twitter.com/intent/tweet?original_referer=<?php echo Configure::read('App.fullBaseUrl') ?>&text=<?php echo $articel['Article']['title'] ?> &url=<?php echo Configure::read('App.fullBaseUrl').$this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])) ?>" rel="nofollow" target="_blank">Twitter</a>
                    <a class="SharingIcon GP" href="https://plus.google.com/share?url=<?php echo Configure::read('App.fullBaseUrl').$this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])) ?>" data-href="<?php echo Configure::read('App.fullBaseUrl') ?>" rel="nofollow" target="_blank">Google+</a>
                    <a class="SharingIcon IN" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo Configure::read('App.fullBaseUrl').$this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])) ?>&title=<?php echo $articel['Article']['title'] ?>" rel="nofollow" target="_blank">LinkedIn</a>
                    <a class="SharingIcon Mail" ref="mailto: ?s=gmail&?subject=<?php echo $articel['Article']['title'] ?>&body=<?php echo $this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])) ?>">Email</a>
                </div>
            </div>
            <a class="close-reveal-modal">&#215;</a>
        </div>

        <div class="NewsTitle">
            <a href="<?php echo $this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'].'-'.$this->Html->cleanString($articel['Article']['title']))) ?>" title="<?php echo $articel['Article']['title'] ?>">
                <h2><?php echo $articel['Article']['title'] ?></h2>
            </a>
            <div class="clearfix"></div>
            <p class="NewsDesc hide">
                <?php echo mb_substr($articel['Article']['content'], 0, 255, 'UTF-8'); ?>
            </p>
        </div>
        <div class="clearfix"></div>
        <a class="SeeMoreBtn" href="javascript:void(0)" ></a>
        <a rel="nofollow" class="readMoreBtn" href="<?php echo $this->Html->url(array('controller' => 'article', 'action' => $articel['Article']['id'].'-'.$this->Html->cleanString($articel['Article']['title']))) ?>" title="<?php echo $articel['Article']['title'] ?>"><?php echo __('More') ?></a>
        <div class="clearfix"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).off('click','.ShareIcon').on('click','.ShareIcon',function(e) {
                    //e.preventDefault();
                    var ModalId = $(this).attr('data-id');
                    ModalId = '#'+ModalId;
                    //alert(ModalId);
                    $(ModalId).foundation('reveal', 'open');
               });

    $(document).off('click','.close-reveal-modal').on('click','.close-reveal-modal',function(e) {
                    var ModalId = $(this).parent('.reveal-modal').attr('id');
                    ModalId = '#'+ModalId;
                    $(ModalId).removeClass('open').removeAttr('style');
                    $('.reveal-modal-bg').removeAttr('style');


           });

</script>
<?php } ?>