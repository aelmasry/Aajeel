<div class="small-12 medium-7 large-8 columns">
<?php if($this->request->params['controller'] == 'tags' && ($this->request->params['action'] == 'display' || $this->request->params['action'] == 'search')) { ?>
<?php if($this->request->params['action'] == 'search')  { ?>
    <div class="ResultBox">
        <div class="searchIcon"></div>
        <h1 class="ResultTitle"><?php echo $title ?></h1>
    </div>
    <?php }else { ?>
    <div class="ResultBox" style="padding-right: 10px !important;">
        <h1 class="ResultTitle"><?php echo $title ?></h1>
    </div>
    <?php } ?>    
<?php } ?>
<div class="NewsBox">
    <?php 
    $i = 1;
    while (list($key, $articel) = each($articels)) { ?>
        <div class="NewsWrap">
			<div class="NewsDate">
				<a href="<?php echo $this->Html->url(array('controller'=> 'source', 'action'=> $articel['Source']['alias'] )) ?>" title="<?php echo $articel['Source']['name']?>" >
                    <?php if($i <= 1 && $this->request->params['controller'] == 'sources') { ?>
                        <h1><?php echo $articel['Source']['name']?> </h1>
                    <?php }else { ?>
                        <h3><?php echo $articel['Source']['name']?> </h3>
                    <?php } ?>
				</a> &nbsp; <span class="timeclass"><?php echo $this->Html->relativeTime($articel['Article']['publish_up']); ?></span>
			</div>
			<div class="ActionIcons">
				<a class="ShareIcon" data-id="ShareModal<?php echo $articel['Article']['id']; ?>" href="javascript:void(0)" >Share</a>
			</div>
			<div class="clearfix"></div>
			<div class="NewsData">
				<div class="AgancyImg">
					<a href="<?php echo $this->Html->url(array('controller'=> 'source', 'action'=> $articel['Source']['alias'] )) ?>" title="<?php echo $articel['Source']['name'] ?>" >
						<img src="<?php echo $this->request->webroot ?>img/sources/<?php echo $articel['Source']['logo'] ?>" alt="<?php echo $articel['Source']['name'] ?>"/>
					</a>
				</div>
				<div id="ShareModal<?php echo $articel['Article']['id']; ?>" class="reveal-modal small">
					<div class="AgancyImg">
						<img src="<?php echo $this->request->webroot ?>img/sources/<?php echo $articel['Source']['logo'] ?>" alt="<?php echo $articel['Source']['name'] ?>"/>
					</div>
					<div class="NewsTitle">
						<h2><?php echo $articel['Article']['title'] ?></h2>
					</div>
					<div class="clearfix"></div>
					<div class="ShareBox">
						<div class="ShareTitle">
							<div class="ShareIcon right"></div>
							<span><?php echo __('share news by'); ?></span>
						</div>
						<div class="ShareIcons">
							<a class="SharingIcon FB" href="http://www.facebook.com/sharer.php?u=<?php echo Configure::read('App.fullBaseUrl').$this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])) ?>&t=<?php echo $articel['Article']['title'] ?>" rel="nofollow" target="_blank" ><?php echo __('3ajeel').' '.$pageTitle ?></a>
							<a class="SharingIcon TW" 
							href="https://twitter.com/intent/tweet?original_referer=<?php echo Configure::read('App.fullBaseUrl') ?>&text=<?php echo $articel['Article']['title'] ?> &url=<?php echo Configure::read('App.fullBaseUrl').$this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])) ?>" rel="nofollow" target="_blank"><?php echo __('3ajeel').' '.$pageTitle ?></a>
							<a class="SharingIcon GP" href="https://plus.google.com/share?url=<?php echo Configure::read('App.fullBaseUrl').$this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])) ?>" data-href="<?php echo Configure::read('App.fullBaseUrl') ?>" rel="nofollow" target="_blank"><?php echo __('3ajeel').' '.$pageTitle ?></a>
							<a class="SharingIcon IN" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo Configure::read('App.fullBaseUrl').$this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])) ?>&title=<?php echo $articel['Article']['title'] ?>" rel="nofollow" target="_blank"><?php echo __('3ajeel').' '.$pageTitle ?></a>
							<a class="SharingIcon Mail" ref="mailto: ?s=gmail&?subject=<?php echo $articel['Article']['title'] ?>&body=<?php echo $this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])) ?>"><?php echo __('3ajeel').' '.$pageTitle ?></a>
						</div>
					</div>
					<a class="close-reveal-modal">&#215;</a>
				</div>
			   
				<div class="NewsTitle">
					<?php if($i <= 1 && $this->request->params['controller'] != 'tags') { ?>
					<a href="<?php echo $this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'].'-'.$this->Html->cleanString($articel['Article']['title']))) ?>" title="<?php echo $articel['Article']['title'] ?>">
						<h2> <?php echo $articel['Article']['title'] ?></h2>
					</a>
					<?php }else { ?>
					<a href="<?php echo $this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'].'-'.$this->Html->cleanString($articel['Article']['title']))) ?>" title="<?php echo $articel['Article']['title'] ?>">
						<h2><?php echo $articel['Article']['title'] ?></h2>
					</a>
					<?php } ?>
					<div class="clearfix"></div>
					<p class="NewsDesc hide">
						<?php echo mb_substr($articel['Article']['content'],0,255,'UTF-8'); ?>
					</p>
				</div>
				<div class="clearfix"></div>
				<a class="SeeMoreBtn" href="javascript:void(0)" ></a>
				<a class="readMoreBtn" rel="nofollow" href="<?php echo $this->Html->url(array('controller'=> 'article', 'action'=> $articel['Article']['id'].'-'.$this->Html->cleanString($articel['Article']['title']))) ?>" title="<?php echo $articel['Article']['title'] ?>"><?php echo __('Read more')?></a>
				<div class="clearfix"></div>
			</div>
        </div>
        <?php if ($i <= 1) : ?>
        <div class="NewsWrap show-for-large-up" style="text-align:center">
            <ins class="adsbygoogle" 
				style="display:inline-block;width:468px;height:60px"
				data-ad-client="ca-pub-6239639062747677"
				data-ad-slot="5169567140"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
        </div>
		<div class="NewsWrap show-for-small-only" style="text-align:center">
            <ins class="adsbygoogle"
				 style="display:inline-block;width:320px;height:100px"
				 data-ad-client="ca-pub-6239639062747677"
				 data-ad-slot="9616521140"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
        </div>
        <?php
        endif; 
        $i++;
		$lastId = $articel['Article']['id'];
        } ?>
        
</div>
    <div class="animation_image" style="display:none" align="center">
        <img src="<?php echo $this->request->webroot ?>img/ajax-loader.gif">
    </div>
    <p id="pbd-alp-load-posts"><a href="#">شاهد المزيد</a></p>
</div>

<script>
    jQuery(function() {
        var track_load = 2;        //total loaded record group(s)
        var loading  = false;       //to prevents multipal ajax loads
        var data = null;
        $('#pbd-alp-load-posts a').click(function() {
           loading = true; //prevent further ajax loading
//           $(this).html('<img src="<?php echo $this->request->webroot ?>img/ajax-loader.gif">');
            $(this).hide();
            $('.animation_image').show();
           <?php if($this->request->params['controller'] == 'tags' || $this->request->params['controller'] == 'sources' || $this->request->params['controller'] == 'countries' && ($this->request->params['action'] == 'display' || $this->request->params['action'] == 'search')) { ?>
                var alias = "<?php echo $title ?>";
                var lastId = "<?php echo $lastId ?>";
                alias = alias.toLowerCase();
                var regExp = /\s+/g;
                alias = alias.trim();
                alias = alias.replace(regExp,'-');
            <?php if($this->request->params['controller'] == 'countries') { ?>
                data = {'group_no': track_load, 'country': alias, 'lastId':lastId};
            <?php }elseif($this->request->params['controller'] == 'sources') { ?>
                data = {'group_no': track_load, 'source': alias, 'lastId':lastId};
            <?php }elseif($this->request->params['controller'] == 'tags') { ?>
                data = {'group_no': track_load, 'tag': alias, 'lastId':lastId};
            <?php } } else { ?>
                data = {'group_no': track_load, 'lastId':lastId};
            <?php } ?>
            //load data from the server using a HTTP POST request
            $.post('<?php echo $this->Html->url(array('controller' => 'articles', 'action' => 'loadmore')) ?>',data, function(data){
                $(".NewsBox").append(data); //append received data into the element
                //hide loading image
                $('.animation_image').hide(); //hide loading image once data is received
                $('#pbd-alp-load-posts a').show();
                track_load++; //loaded group increment
                loading  = false;
            }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
                    console.log(thrownError); //alert with HTTP error
                    $('.animation_image').hide(); //hide loading image once data is received
                    $('#pbd-alp-load-posts a').show();
                    loading = false;
            });
           return false;
        });
    });
</script>