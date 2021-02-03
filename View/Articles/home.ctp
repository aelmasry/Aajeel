<div class="NewsBox">
<?php while (list($key, $articel) = each($articels)) { ?>
<div class="NewsWrap">
<!--    <div class="ActionIcons">
        <a class="ShareIcon" data-reveal-id="ShareModal" href="javascript:void(0)" data-reveal>Share</a>
    </div>
    <div class="clearfix"></div>-->
    <div class="NewsData">
        <div class="AgancyImg">
            <a href="<?php echo $this->Html->url(array('controller'=> 'source', 'action'=> $articel['Source']['alias'] )) ?>" >
                <img src="<?php echo $this->request->webroot ?>img/sources/<?php echo $articel['Source']['logo'] ?>" alt="<?php echo $articel['Source']['name'] ?>"/>
            </a>
        </div>
        <div class="NewsTitle">
                <a href="<?php echo $this->Html->url(array('controller'=> 'source', 'action'=> $articel['Source']['alias'] )) ?>" >
                    <?php echo $articel['Source']['name']?> 
                </a> &nbsp; <span class="timeclass"><?php //echo $this->Html->relativeTime($articel['Article']['created']); ?></span>
                <h3><?php echo $articel['Article']['title'] ?></h3>
                <div class="clearfix"></div>
                <p class="NewsDesc hide">
                    <?php echo mb_substr($articel['Article']['content'],0,255,'UTF-8'); ?>
                </p>
        </div>
        <div class="clearfix"></div>
        <div class="ActionIcons">
            <a class="ShareIcon" data-reveal-id="ShareModal" href="javascript:void(0)" data-reveal>Share</a>
        </div>
        <!--<a class="SeeMoreBtn" href="javascript:void(0)"></a>-->
        <div class="ActionIcons">
            <a class="ShareIcon" data-reveal-id="ShareModal" href="javascript:void(0)" data-reveal>Share</a>
        </div>

        <a class="readMoreBtn" href="<?php echo $articel['Article']['permalink'] ?>"><?php echo __('Read more') ?></a>
        <div class="clearfix"></div>
    </div>
</div>
<?php } ?>

<div id="results"></div>
<div class="animation_image" style="display:none" align="center">
<img src="<?php echo $this->request->webroot ?>img/ajax-loader.gif">
</div>
<script>
$(document).ready(function() {
    var track_load = 10;        //total loaded record group(s)
    var loading  = false;       //to prevents multipal ajax loads
    
    $(window).scroll(function() { //detect page scroll
        
        if($(window).scrollTop() + $(window).height() == $(document).height())  //user scrolled to bottom of the page?
        {
            track_load = track_load + 10; //loaded group increment
            loading = true; //prevent further ajax loading
            $('.animation_image').show(); //show loading image

            //load data from the server using a HTTP POST request
            $.post('<?php echo $this->Html->url(array('controller'=> $this->request->params['controller'], 'action'=> 'loadMore'))?>',{'group_no': track_load}, function(data){

                $("#results").append(data); //append received data into the element

                //hide loading image
                $('.animation_image').hide(); //hide loading image once data is received
            }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
                $('.animation_image').hide(); //hide loading image
            });
        }
        
         console.debug(track_load);
    });
});
</script>