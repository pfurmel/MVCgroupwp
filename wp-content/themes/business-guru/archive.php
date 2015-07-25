<?php
 get_header(); ?>
	<div id="content">	
			
				<div class="container clearfix">
					<div class="page-header clearfix">	
				
					<?php  bguru_breadcrumb(); ?>								
					</div><!--/ .page-header-->
				
				<div id="main" class="twelve columns">			
																
					<?php  if (have_posts()) : ?>
					<?php while (have_posts()) : the_post(); ?>		
					<article class="entry clearfix">
					
								<div class="entry-title">	
									<h2 class="title"><?php  the_title(); ?></h2>
								</div><!--/ .entry-title-->
								
								<div class="preloader">
									<?php
										$featuredImage = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
										if ( has_post_thumbnail() ) {
											echo '<a class="single-image link-icon" href="'.get_the_permalink().'">';
												echo '<img src="'.$featuredImage.'" alt="Post image"/>';
											echo '</a>';
										}
									?>
								</div>
									
								<div class="entry-meta">
										<span class="date"><?php  the_time('M - j - Y'); ?></span>

										<span class="author">By <?php  the_author_posts_link(); ?></span>

										<span class="tag"><?php the_tags(); ?></span>
										
										<span class="comments"><a href="#"><?php echo get_comments_number();?> Comments</a></span>
					            </div>
									 
								<div class="entry-body">
									
										<?php bguru_excerpt('bguru_excerptlength_index', ''); ?>
										<a class="button default color" href="<?php  the_permalink(); ?>">Read More</a>
										
								</div><!--/ .entry-body-->
							
					</article>
							<?php  endwhile; ?>			
																		
										<?php bguru_paging_nav();?> 									
									<?php  else : ?>									
										<h1 class="title">Not Found</h1>
										<p>Sorry, but you are looking for something that isn't here.</p>
										
									<?php  endif; ?>
							
						<div class="divider-half-solid"></div>
				</div><!--/ #main-->			
					<?php  get_sidebar(); ?>
						
			</div><!--/ .container-->
			
	</div><!--/ #content-->
<?php
 get_footer(); ?>