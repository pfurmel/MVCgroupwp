<?php
/**
 * The Header for our theme.
 */
 ?>

<!DOCTYPE html>
 
<html <?php language_attributes(); ?>>
 
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width">
	<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">


   <?php  if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

   <?php wp_head();?>
   
</head>
<body <?php body_class('wide color body_class'); ?>>
<div id="wrapper">
  <header id="header">
        <div class="container">
		<?php
	$options=get_option('bguru_options');
	?>
			<div class="eight columns">
				<?php	
			
	$bguru_logo_image = $options['bguru_logo'];
	
	if (!empty($bguru_logo_image)) {
		echo '<div id="logo"><a href="' . home_url() . '"><img src="' . $bguru_logo_image . '" width="218" alt="logo" /></a></div><!--/ #logo-->';
	} else {
		echo '<div id="logo"><a href="' . home_url() . '"><h1>'. get_bloginfo('name') . '</h1></a></div><!--/ #logo-->';
	}

	?>
			</div><!--/ .columns-->
			<div class="eight columns">
				<div class="widget widget_contacts">
					<ul class="social-icons">
						<?php
	$bguru_social_vimeo = $options['bguru_vimeo'];
	
	if (!empty($bguru_social_vimeo)) {
		echo '<li class="vimeo"><a target="_blank" href="'.$bguru_social_vimeo.'">Vimeo</a></li>';
	}

	?>
						<?php
	$bguru_social_skype = $options['bguru_skype'];
	
	if (!empty($bguru_social_skype)) {
		echo '<li class="skype"><a target="_blank" href="'.$bguru_social_skype.'">Skype</a></li>';
	}

	?>
						<?php
	$bguru_social_dribbble = $options['bguru_dribbble'];
	
	if (!empty($bguru_social_dribbble)) {
		echo '<li class="dribble"><a target="_blank" href="'.$bguru_social_dribbble.'">Dribbble</a></li>';
	}

	?>
						<?php
	$bguru_social_youtube = $options['bguru_youtube'];
	
	if (!empty($bguru_social_youtube)) {
		echo '<li class="youtube"><a target="_blank" href="'.$bguru_social_youtube.'">Youtube</a></li>';
	}

	?>
						<?php
	$bguru_social_twitter = $options['bguru_twitter'];
	
	if (!empty($bguru_social_twitter)) {
		echo '<li class="twitter"><a target="_blank" href="'.$bguru_social_twitter.'">Twitter</a></li>';
	}

	?>
						<?php
	$bguru_social_facebook = $options['bguru_facebook'];
	
	if (!empty($bguru_social_facebook)) {
		echo '<li class="facebook"><a target="_blank" href="'.$bguru_social_facebook.'">Facebook</a></li>';
	}

	?>
						<?php
	$bguru_social_feed = $options['bguru_feed'];
	
	if (!empty($bguru_social_feed)) {
		echo '<li class="rss"><a target="_blank" href="'.$bguru_social_feed.'">Feed</a></li>';
	}

	?>
					</ul><!--/ .social-icons -->	
				</div>
			</div><!--/ .columns-->
		</div><!--/ .container--> 
			<div class="clear"></div>
		<div class="menu-container clearfix">																																																																																						
			<div class="container">
				<div class="sixteen columns">
					<nav id="navigation" class="navigation clearfix">
						<?php
					wp_nav_menu(array('theme_location' => 'primary-menu',
					 'menu' => 'Main Nav Menu',
					 'menu_class' => 'menu',
					 'container' => false,
					 'items_wrap' => '<div class="menu"><ul>%3$s</ul></div>'
					 )); ?>
					</nav><!--/ .navigation-->
					<div class="search-wrapper">						
						<?php get_search_form(); ?>
					</div><!--/ .search-wrapper--> 		
				</div><!--/ .columns-->
			</div><!--/ .container--> 
		</div><!--/ .menu-container-->	
    </header><!--/ #header-->