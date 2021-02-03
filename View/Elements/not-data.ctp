<?php if($this->request->params['controller'] == 'tags' && ($this->request->params['action'] == 'display' || $this->request->params['action'] == 'search')) { ?>
<div class="small-12 medium-7 large-8 columns">
<div class="ResultBox">
    <?php if($this->request->params['action'] == 'search')  { ?>
        <div class="searchIcon"></div>
        <p> <?php echo __('search results') ?> <span class="ResultTitle"><?php echo $title ?></span></p>
    <?php }else { ?>
        <p><span class="ResultTitle"><?php echo $title ?>  </span></p>
    <?php } ?>    
</div>
<?php } ?>
<div class="ResultBox">
    
    <!-- banner 468 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:468px;height:60px"
     data-ad-client="ca-pub-6239639062747677"
     data-ad-slot="4137349941"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
            <p><span class="ResultTitle"><?php echo __('bad link'); ?> </span></p>
                
            
            
            <!-- banner 468 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:468px;height:60px"
     data-ad-client="ca-pub-6239639062747677"
     data-ad-slot="4137349941"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
    
</div>
</div>   