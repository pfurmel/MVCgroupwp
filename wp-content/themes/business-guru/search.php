<?php
 get_header(); ?>
	<section id="content">
     	<div class="menu-shadow"></div>
		<div class="container clearfix">
	       <div class="page-header clearfix">
			     <h4 class="title">
				  <?php  printf(__('Search Results for: %s', 'business_guru') , get_search_query()); ?>
				 </h4>
				 
            </div>
			<div id="main" class="twelve columns">
				<?php  if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				
			
					<?php
						$featuredImage = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
?>
					<article class="entry clearfix">
					
						<div class="entry-title">
							<h2 class="title"><a href="<?php  the_permalink(); ?>"><?php  the_title(); ?></a></h2>
						</div>
						
				     <div class="preloader">
						<?php
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
	</section><!--/ #content-->
<?php
 get_footer(); ?>