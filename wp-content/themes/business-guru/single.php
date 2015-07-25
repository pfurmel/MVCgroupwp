<?php

 get_header(); ?>

	<section id="content" class="sbr">

    	<div class="menu-shadow"></div>

		<div class="container clearfix">

			<div class="page-header clearfix">
					<h4 class="title"><?php  the_title(); ?></h4>
					<?php  bguru_breadcrumb(); ?>

			</div><!--/ .page-header-->

			<div id="main" class="twelve columns">

				<article class="entry clearfix">

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php  if (have_posts()): ?>

		<?php 

	while (have_posts()):

	the_post();

	?>

                	<div class="entry-title">

						<h2 class="title"><?php  the_title(); ?></h2>

					</div><!--/ .entry-title-->

					<div class="preloader">

						<a class="single-image link-icon" href="<?php  the_permalink()  ?>">

							<?php the_post_thumbnail('large'); ?>

						</a>					

					</div><!--/ .preloader-->

					<div class="entry-meta">

						<span class="date"><?php  the_time('M - j - Y'); ?></span>

						<span class="author">By <?php  the_author_posts_link(); ?></span>

						<span class="tag"><?php  the_category(','); ?></span>
						
						<span class="comments"><a href="#"><?php echo get_comments_number();?> Comments</a></span>
					</div><!--/ .entry-meta-->

					<div class="entry-body">

						<?php  the_content('Read the rest of this entry &raquo;'); ?>

						<?php wp_link_pages('before=<div id="page-links">&after=</div>'); ?>

					

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

					</div>

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