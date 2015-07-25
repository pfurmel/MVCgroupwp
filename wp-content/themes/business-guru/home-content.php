<?php
/*Template Name: Home Page*/
 get_header(); ?>
	<div class="slider">    		
	<?php
	$options=get_option('bguru_options');
	$bguru_slide1_image = $options['bguru_slide_one_image'];
	$bguru_slide2_image = $options['bguru_slide_two_image'];
	$bguru_slide3_image = $options['bguru_slide_three_image'];
	if (!empty($bguru_slide1_image)) {
		echo '<div id="slider" class="nivoSlider">';
		echo '<img src="'.$bguru_slide1_image.'" alt="" title="#slidercaption1" />';
		
		if (!empty($bguru_slide2_image)) {
			echo '<img src="'.$bguru_slide2_image.'" alt="" title="#slidercaption2" />';
		}

		
		if (!empty($bguru_slide3_image)) {
			echo '<img src="'.$bguru_slide3_image.'" alt="" title="#slidercaption3" />';
		}

		echo '</div>';
	}

	?>
	<?php
	$bguru_slide1_heading = $options['bguru_slide_one_heading'];
	$bguru_slide2_heading = $options['bguru_slide_two_heading'];
	$bguru_slide3_heading = $options['bguru_slide_three_heading'];
	$bguru_slide1_text = $options['bguru_slide_one_text'];
	$bguru_slide2_text = $options['bguru_slide_two_text'];
	$bguru_slide3_text = $options['bguru_slide_three_text'];
	
	if (!empty($bguru_slide1_image)) {
		echo '<div id="slidercaption1" class="nivo-html-caption1">';
		
		if (!empty($bguru_slide1_heading)) {
			echo '<div class="big-text">'.$bguru_slide1_heading.'</div>';
		}

		
		if (!empty($bguru_slide1_text)) {
			echo '<b>'.$bguru_slide1_text.'</b>';
		}

		echo '</div>';
		
		if (!empty($bguru_slide2_image)) {
			echo '<div id="slidercaption2" class="nivo-html-caption2">';
			
			if (!empty($bguru_slide2_heading)) {
				echo '<div class="big-text">'.$bguru_slide2_heading.'</div>';
			}

			
			if (!empty($bguru_slide2_text)) {
				echo '<b>'.$bguru_slide2_text.'</b>';
			}

			echo '</div>';
		}

		
		if (!empty($bguru_slide3_image)) {
			echo '<div id="slidercaption3" class="nivo-html-caption3">';
			
			if (!empty($bguru_slide3_heading)) {
				echo '<div class="big-text">'.$bguru_slide3_heading.'</div>';
			}

			
			if (!empty($bguru_slide3_text)) {
				echo '<b>'.$bguru_slide3_text.'</b>';
			}

			echo '</div>';
		}

	}

	?>
	</div><!--/ .slider-->
	<section id="content">
		<div class="container">
		<?php
	$bguru_slogan_head = $options['bguru_slogan_heading'];
	$bguru_slogan_desc = $options['bguru_slogan_description'];
	echo '<div class="slogan">';
	
	if (!empty($bguru_slogan_head)) {
		echo '<h2>'.$bguru_slogan_head.'</h2>';
	}

	
	if (!empty($bguru_slogan_desc)) {
		echo '<b>'.$bguru_slogan_desc.'</b>';
	}

	echo '</div>';
	?>
		<div>
			<?php  if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('container-one-widget') )  ?>
		</div>
		<div class="divider-half-solid"></div>
		<div>
			<?php  if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('container-two-widget') )  ?>
		</div>
		<div class="divider-half-solid"></div>
		<div>
			<?php  if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('container-three-widget') )  ?>
		</div>
		<div class="divider-solid"></div>
		
			<div>
				<?php  if (have_posts()) : ?>
				<?php 
				if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('container-four-widget') ) 
				?>
			
			<?php  else : ?>
				<h1 class="title">Not Found</h1>
				<p>Sorry, but you are looking for something that isn't here.</p>
			<?php  endif; ?>
			</div>
		</div><!--/ .container-->
	</section><!--/ #content-->
<?php
 get_footer(); ?>