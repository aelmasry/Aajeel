<!DOCTYPE html>
<html xml:lang="ar" lang="ar">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title><?php echo $title_for_layout; ?></title>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
		  (adsbygoogle = window.adsbygoogle || []).push({
			google_ad_client: "ca-pub-6239639062747677",
			enable_page_level_ads: true
		  });
		</script>
        <base href="<?php echo $this->Html->url( null, true ); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="utkB_-KyLWy_4CEE43y5--6TwFZ0Qw-IgJTmP6cMd8g" />
        <meta name="robots" content="index,follow">
        <meta http-equiv="content-language" content="ar" />
        <link rel="schema.dc" href="http://purl.org/dc/elements/1.1/" />
		<link rel="schema.dcterms" href="http://purl.org/dc/terms/" />
		<meta name="dc.language" content="ar" />
		<meta name="dc.publisher" content="<?php echo __('3ajeel', true) ?>" />
		<meta name="dc.identifier" content="<?php echo $this->Html->url( null, true ); ?>" />
        <?php if($this->params['controller'] == 'countries' && $this->params['action'] == 'display') : ?>
            <link rel="alternate" type="application/rss+xml" title="<?php echo __('3ajeel', true) ?>" href="<?php echo $this->Html->url( null, true ).'/rss' ?>"/>
        <?php else: ?>
            <link rel="alternate" type="application/rss+xml" title="<?php echo __('3ajeel', true) ?>" href="http://www.3ajeel.com/rss"/>
        <?php endif; ?>
        <?php 
            echo $this->Html->meta('keywords', $keywords);
            echo $this->Html->meta('description', $description);
//            echo $this->Html->meta('rights', __('3ajeel', true));
//            echo $this->Html->meta('HandheldFriendly', true);
            echo $this->Html->meta('icon');
            echo $this->Html->css(array('normalize', 'foundation.min', 'main'));
            echo $this->Html->script(array('vendor/modernizr-2.7.1.min', 'vendor/jquery-1.10.2.min'));
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
        ?>
        <link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/droid-arabic-kufi" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/droid-arabic-naskh" rel="stylesheet" type="text/css"/>
        <!--[if lt IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!--<link href="<?php echo $this->Html->url( null, true ); ?>" rel="canonical">-->
		<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>-->
		
    </head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=488046461259664";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="off-canvas-wrap">
    <div class="inner-wrap">
        <nav class="tab-bar TopBarStyle contain-to-grid fixed" data-topbar data-options="is_hover: false">
                <div class="LogoWrap hide-for-medium-down">
                        <div class="row">
                            <a href="<?php echo FULL_BASE_URL; ?>" title="<?php echo __('3ajeel', true) ?> logo" >
                                <img class="HeaderBigLogo right" src="<?php echo $this->webroot ?>img/logo_big.png" alt="عاجل اخر الاخبار فى مصر والوطن العربى" title="<?php echo __('3ajeel', true) ?>"/>
                            </a>
                            <div class="TopAd left hide-for-small-only">
<!-- 3ajeel top banner -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-6239639062747677"
     data-ad-slot="6569235140"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
                            </div>
                        </div>
                    </div>
                <section class="right-small hide-for-large-up MenuStyle">
                        <a class="right-off-canvas-toggle menu-icon" ><span></span></a>
                </section>
                <div class="row topRow">
                        <div class="hide-for-medium-down right">
                            <ul class="MainNav right">
                            <?php
							$m=0;	
							$sm = 0;
							foreach ($countries as $country) : 
								if($m <= 6) {?>    
									<li><a href="<?php echo $this->Html->url(array('controller'=> '/', 'action'=> $country['Country']['alias'])); ?>"><?php if(isset($alias) && $alias == $country['Country']['alias'] ) { echo "<h1>".$country['Country']['name']."</h1>"; }else { echo $country['Country']['name']; } ?></a></li>
								<?php }else { 
									if($sm == 0) { ?>
									<li>
										<a class="dropdown-toggle menu-icon"><span></span></a>
										<ul class="dropdown-menu">
									<?php } ?>
											<ol><a href="<?php echo $this->Html->url(array('controller'=> '/', 'action'=> $country['Country']['alias'])); ?>"><?php if(isset($alias) && $alias == $country['Country']['alias'] ) { echo "<h1>".$country['Country']['name']."</h1>"; }else { echo $country['Country']['name']; } ?></a></ol>
								
								<?php	
								$sm++;
								} ?>
                            <?php 
							$m++;
							endforeach; 
							if($sm >= 1) ?>
								</ul>
								</li>
							</ul>
                        </div>
                        <a class="hide-for-large-up right" id="HeaderLogoSmall" href="<?php echo $this->Html->url(array('controller'=> '/', 'action'=>'/')); ?>" style="">
							 <?php echo __('3ajeel', true) ?> 
						</a>
						<a class="Search left"><?php echo __('search') ?></a>
                        <div class="SearchBox hide">
                            <form action="<?php echo $this->Html->url(array('controller'=> '/', 'action'=>'search')); ?>"  method="get">
                                <div class="searchIcon"></div>
                                <input name="q" type="text" placeholder="<?php echo __('search box') ?>" class="SearchBar" />
                            </form>
                        </div>
                </div>

        </nav>
        <aside class="right-off-canvas-menu SideMenu">
            <ul class="off-canvas-list">
                <?php foreach ($countries as $country) : ?>    
                    <li><a href="<?php echo $this->Html->url(array('controller'=> '/', 'action'=> $country['Country']['alias'])); ?>"><?php echo $country['Country']['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </aside>
        <section class="main-section">
            <div class="row">
                <?php //echo $this->Session->flash(); ?>
                <?php echo $this->fetch('content'); ?>
				<?php 
				$articleView = ($this->request->params['controller'] == 'articles' && $this->request->params['action'] == 'iframe');
				if(!$articleView){ 
				?>
				<div class="small-12 medium-5 large-4 columns hide-for-small-only">
					<?php echo $this->element('left-slide'); ?>
				</div>
                <?php } ?>
            </div>
        </section>
        <div class="clearfix"></div>
        <footer>
                <div class="row">
                        <div class="small-12 medium-12 large-12 columns">
                            <p>عاجل .. موقع واحد يجمع لك كل مواقع الوطن العربي  من كل دولة على حده في موقع واحد </p>
                            <nav>
                                <?php foreach ($countries as $country) : ?>    
                                    <a class="footerLink" href="<?php echo $this->Html->url(array('controller'=> '/', 'action'=> $country['Country']['alias'])); ?>"><?php echo $country['Country']['name']; ?></a>&nbsp;
                                <?php endforeach; ?>
                            </nav>
                             <p>  جميع حقوق النشر محفوظة لمصادر الأخبار المذكورة وتتحمل هذه المصادر المسؤولية الكاملة عن صحة الأخبار </p>
                            <nav>
                                <a class="footerLink" href="<?php echo FULL_BASE_URL ?>/about"><?php echo __('About 3ajeel', true); ?></a> |
                                <!--<a class="footerLink middleLink" href=""><?php echo __('terms', true); ?></a>-->
                                <a class="footerLink" href="<?php echo FULL_BASE_URL ?>/contact"><?php echo __('contact us', true); ?></a>
                            </nav>
                        </div>
                </div>
            
        </footer>
</div>
</div>
<script src="webroot/js/vendor/foundation.min.js"></script>
<script src="webroot/js/vendor/foundation.reveal.js"></script>
<script>
	$(function() {
		// Dropdown toggle
		$('.dropdown-toggle').click(function(){
		  $(this).next('.dropdown-menu').toggle();
		});

		$(document).click(function(e) {
		  var target = e.target;
		  if (!$(target).is('.dropdown-toggle') && !$(target).parents().is('.dropdown-toggle')) {
			$('.dropdown-menu').hide();
		  }
		});

	});
	
    $(document).delegate(this, "ready", function() {
        $(document).foundation();
    });
    $('.ShareIcon').on('click',function(e) {
                    //e.preventDefault();
                    var ModalId = $(this).attr('data-id');
                    ModalId = '#'+ModalId;
                    //alert(ModalId);
                    $(ModalId).foundation('reveal', 'open');

               });
     $('.close-reveal-modal').on('click',function(e) {
                    var ModalId = $(this).parent('.reveal-modal').attr('id');
                    ModalId = '#'+ModalId;
                   $(ModalId).removeClass('open').removeAttr('style');
                   $('.reveal-modal-bg').removeAttr('style');

           });

</script>

<script src="<?php echo $this->request->webroot ?>js/plugins.js"></script>
<script src="<?php echo $this->request->webroot ?>js/main.js?45435345345"></script>

<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"Ani4m1aQibl0fn", domain:"3ajeel.com",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=Ani4m1aQibl0fn" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript -->
<!--- Google Analytics   --->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49903225-1', 'auto');
  ga('send', 'pageview');
  ga('push', 'setReferrerUrl', document.referrer); 
  ga('push', 'trackPageView'); 

</script>
<!--- Google Analytics   --->

</body>
</html>
