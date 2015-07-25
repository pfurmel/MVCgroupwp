<?php

 /*Template Name: Right Sidebar*/

get_header(); ?>

	<section id="content" class="sbr">

    	<div class="container clearfix">

			<div class="page-header clearfix">
			
			<h4 class="title"><?php echo the_title();?></h4>
					<?php  bguru_breadcrumb(); ?>

			</div><!--/ .page-header-->

			<div id="main" class="twelve columns">

				<article class="entry clearfix">

					<?php  if (have_posts()): ?>
			
					<?php 
			
				        while (have_posts()):
			
							the_post();
						
							?>

                	<div class="entry-title">

						<h2 class="title"><?php  the_title(); ?></h2>

					</div><!--/ .entry-title-->

					<div class="preloader">

						<?php

							$featuredImage = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

							if ( has_post_thumbnail() ) {

								echo '<a class="single-image link-icon" href="'.the_permalink().'">';

									echo '<img src="'.$featuredImage.'" style="width:100%;" />';

								echo '</a>';

									}
		
						 ?>				

					</div><!--/ .preloader-->

					<div class="entry-body">

						<?php  the_content('Read the rest of this entry &raquo;'); ?>
						
						<div class="author-about">

							<div class="author-entry">

								<h5>About the Author</h5>

                                <div class="author-thumb">

                                    <div class="bordered">

                                        <div class="avatar">

                                            <?php  echo get_avatar( $post->post_author, 80 ); ?>

                                        </div>

                                    </div><!--/ .bordered-->

						  		</div><!--/ .author-thumb-->

                                				<h6><?php  the_author_meta('display_name'); ?></h6>

								<p><?php  the_author_meta('description'); ?></p>

							</div><!--/ .author-entry-->

					  </div><!--/ .about-author-->
						
						
				  </div><!--/ .entry-body-->

	           	<?php  endwhile; ?>

				</article><!--/ .entry-->

				<section id="comments">

					<?php
			
						if ( comments_open() || get_comments_number() ) {
			
							comments_template();
			
						}
			
					?>
			
							</section>
			
					<?php  endif; ?>

                 <div class="divider-half-solid"></div>

			</div><!--/ #main-->

			<?php  get_sidebar(); ?>

		 </div><!--/ .container-->

	</section><!--/ #content-->

<?php

 get_footer(); ?>