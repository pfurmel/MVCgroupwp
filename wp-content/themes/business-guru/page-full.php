<?php

 /*Template Name: Full Width*/

get_header();
 ?>

	<section id="content">

    	<div class="container clearfix">

			<div class="page-header clearfix">
			
					  <h4 class="title"><?php echo the_title();?></h4>
							<?php  bguru_breadcrumb(); ?>
		
				</div><!--/ .page-header-->

				

			         <?php  if (have_posts()): ?>

							<?php while (have_posts()):the_post();?>

              

						<?php

							$featuredImage = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

							if ( has_post_thumbnail() ) {

								echo '<a class="single-image link-icon" href="'.the_permalink().'">';

									echo '<img src="'.$featuredImage.'" style="width:100%;" />';

								echo '</a>';

							}

						?>				

					

						<?php  the_content('Read the rest of this entry &raquo;'); ?>

				 

		<?php  endwhile; ?>

			


				<section id="comments">

		<?php

			if ( comments_open() || get_comments_number() ) {

				comments_template();

			}

		?>

				</section>

		<?php  endif; ?>
 <div class="divider-half-solid"></div>	
               
			    
   </div>
	</section>

<?php

 get_footer(); ?>