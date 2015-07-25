<?php
	include (TEMPLATEPATH . '/options.php');
	
	function bguru_setup_theme_function() 
{
	
	global $content_width;
	
	 if ( ! isset( $content_width ) ) 
	 {
	$content_width = 700;
	 }
	
	add_theme_support('post-thumbnails');
	
	add_theme_support( 'automatic-feed-links' );	
}

add_action( 'after_setup_theme', 'bguru_setup_theme_function' );

/* Register Primary Menu */

	function bguru_register_menu()
	{
		register_nav_menu('primary-menu', __('Primary Menu', 'business_guru'));
	}

	add_action('init', 'bguru_register_menu');
	
/* Add Special theme classes to nav menu */

   add_filter('nav_menu_css_class' , 'bguru_nav_class' , 10 , 2);

   function bguru_nav_class($classes, $item){
		
		if( in_array('current-menu-item', $classes) ){
			$classes[] = 'current-menu-item';			
		}

		return $classes;
	}
/**
 * Register widgetized area and update sidebar with default widgets.
 */
	function bguru_widgets_init()  
{
		register_sidebar(array(     
		'name' => 'Three Widget Container',     
		'id'   => 'container-one-widget',   
		'description'   => 'Three Widget Container Area',     
		'before_widget' => '<div class="one-third column">',  
		'after_widget'  => '</div>',      
		'before_title'  => '<h6>',       
		'after_title'   => '</h6>'  
		));
		register_sidebar(array(  
		'name' => 'Four Widget Container', 
		'id'   => 'container-two-widget',  
		'description'   => 'Four Widget Container Area',  
		'before_widget' => '<div class="four columns">',   
		'after_widget'  => '</div>',      
		'before_title'  => '<h6>',      
		'after_title'   => '</h6>'  
		));
		register_sidebar(array(
        'name' => 'Five Widget Container',  
		'id'   => 'container-three-widget', 
		'description'   => 'Five Widget Container Area',
        'before_widget' => '<div class="three columns">',
        'after_widget'  => '</div>',  
		'before_title'  => '<h6>',    
		'after_title'   => '</h6>'  
		));
		register_sidebar(array(   
		'name' => 'Six Widget Container',    
		'id'   => 'container-four-widget',    
		'description'   => 'Six Widget Container Area' ,      
		'before_title'  => '<h4 class="content-title">',      
		'after_title'   => '</h4>' 
		));
		register_sidebar(array(     
		'name' => 'Footer Widgets',       
		'id'   => 'footer-widgets',    
		'description'   => 'Footer Widgets Area',   
		'before_widget' => '<div class="four columns"> <div class="widget widget_text">',     
		'after_widget'  => '</div></div>',      
		'before_title'  => '<h3 class="widget-title">',   
		'after_title'   => '</h3>'   
		));
		
		register_sidebar(array(
		'name' => __('Right Hand Sidebar', 'business_guru') ,
		'id' => 'sidebar',
		'description' => __('Widgets in this area will be shown on the right-hand side.', 'business_guru') ,
		'before_title' => '<h2>',
		'after_title' => '</h2>',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>'
		));
}
		add_action( 'widgets_init', 'bguru_widgets_init');

/* PAGE NAVIGATION */	

if ( ! function_exists( 'bguru_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 * Based on paging nav function from Twenty Fourteen
 */

function bguru_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 3,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&larr; Previous', 'businessguru' ),
		'next_text' => __( 'Next &rarr;', 'businessguru' ),
		'type'      => 'list',
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		
			<?php echo $links; ?>
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;

/*-------------------------------------------------*/
/*	Load stylesheet and scripts dynamically
/*-------------------------------------------------*/ 
	
  function bguru_scripts() 
 {
	wp_enqueue_style('style-css', get_stylesheet_uri());
	
	wp_enqueue_style('blue-css', get_stylesheet_directory_uri() . '/css/skins/blue.css');
	
	wp_enqueue_style('skeleton-css', get_stylesheet_directory_uri() . '/css/skeleton.css');
	
	wp_enqueue_style('layout-css', get_stylesheet_directory_uri() . '/css/layout.css');
	
	wp_enqueue_style('font-awesome-css', get_stylesheet_directory_uri() . '/css/font-awesome.css');
	
	wp_enqueue_style('nilvo-slider-css', get_stylesheet_directory_uri() . '/js/nivo-slider/css/nivo-slider.css');
	
	wp_enqueue_script('modernizr-js', get_stylesheet_directory_uri() . '/js/jquery.modernizr.js');
	
	wp_enqueue_script('jquery-min','https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');

	wp_enqueue_script('nivo-slider', get_stylesheet_directory_uri() . '/js/nivo-slider/js/jquery.nivo.slider.js');

	wp_enqueue_script('easing-js', get_stylesheet_directory_uri() . '/js/jquery.easing.1.3.min.js');

	wp_enqueue_script('cycle-js', get_stylesheet_directory_uri() . '/js/jquery.cycle.all.min.js');

	wp_enqueue_script('config-js', get_stylesheet_directory_uri() . '/js/config.js');

	wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/js/custom.js');
}

add_action( 'wp_enqueue_scripts', 'bguru_scripts' );
		

	function bguru_breadcrumb() 
	{
		echo '<ul class="breadcrumbs">';
		
		if (!is_home()) 
		{
			echo '<li class="home"><a href="';
			echo home_url();
			echo '">';
			echo 'Home';
			echo "</a></li>";
			
			if (is_category() || is_single()) 
			{
				echo '<li>';
				$category = get_the_category(); 
				if($category[0]){
				echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';
				}
					
				if (is_single()) {
				echo "</li><li>";
				the_title();
				echo '</li>';
				}

			}

			elseif (is_page()) {
			echo '<li class="current">';
			echo the_title();
			echo '</li>';
			}

		}

		elseif (is_tag()) {
			single_tag_title();
		}

		elseif (is_day()) {
			echo"<li>Archive for ";
			the_time('F jS, Y');
			echo'</li>';
		}

		elseif (is_month()) {
			echo"<li>Archive for ";
			the_time('F, Y');
			echo'</li>';
		}

		elseif (is_year()) {
			echo"<li>Archive for ";
			the_time('Y');
			echo'</li>';
		}

		elseif (is_author()) {
			echo"<li>Author Archive";
			echo'</li>';
		}

		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
			echo "<li>Blog Archives";
			echo'</li>';
		}

		elseif (is_search()) {
			echo"<li>Search Results";
			echo'</li>';
		}

		echo '</ul>';
	}

	
 function bguru_theme_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		?>
<li <?php  comment_class(); ?> id="li-comment-<?php  comment_ID()  ?>">
<article>
<div class="comment-author vcard">
<?php  echo get_avatar( $comment, 64 ); ?>
<?php  printf(__('<cite class="fn">%s</cite>  <span class="says">says:</span>'), get_comment_author_link())  ?>
</div>
<?php  if ($comment->comment_approved == '0') : ?>
<em><?php  _e('Your comment is awaiting moderation.', 'business_guru')  ?></em>
<br />
<?php  endif; ?>
<div class="comment-meta commentmetadata"><a href="<?php  echo htmlspecialchars(get_comment_link( $comment->comment_ID ))  ?>">
<?php  printf(__('%1$s at %2$s', 'business_guru'), get_comment_date(),get_comment_time())  ?></a><?php  edit_comment_link(__('(Edit)', 'business_guru'),'  ','')  ?></div>
<?php  comment_text()  ?>
<?php  if($args['max_depth']!=$depth) { ?>
<div class="reply">
<?php  comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'])))  ?>
</div>
<?php  } ?>
</article>
<?php
 }


/* CUSTOM EXCERPTS */
	
function bguru_excerptlength_aside($length) {
    return 15;
}
	
function bguru_excerptlength_archive($length) {
    return 15;
}
function bguru_excerptlength_index($length) {
    return 15;
}


function bguru_excerpt($length_callback='', $more_callback='') {
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}

class bguru_recent_post extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_recent_entries', 'description' => "Your site&#8217;s most recent Posts.");
		$control_ops = array( 'width' => 200, 'height' =>250 ); 
		parent::WP_Widget( false, $name = __( 'BG Recent Posts', 'business' ), $widget_ops, $control_ops);
		$this->alt_option_name = 'widget_recent_entries';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_recent_posts', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] :  'Recent Posts';

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );
			global $post;
		if ($r->have_posts()) :
?>
<?php if ( $title ) echo $before_title . $title . $after_title; ?>
	 
 <?php while ( $r->have_posts() ) : $r->the_post(); ?>
		
	<div class="item">
		<?php $featuredImage = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
			<div class="img-container">
			  <a href="<?php the_permalink();?>" class="single-image link-icon">
				<img src="<?php echo $featuredImage;?>" alt="Photo" />
				</a>
			</div>
			     <h6 class="title"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h6>
                  <div class="entry-body"><?php bguru_excerpt('bguru_excerptlength_index', '');?></div>
				  <a class="button default color" href="<?php the_permalink();?>">Read More</a>
	</div>
			
		<?php endwhile; ?>
		
		
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_recent_posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of posts to show</label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>">Display post date?</label></p>
<?php
	}
}

function bg_widgets_init() {
register_widget('bguru_recent_post');
do_action( 'widgets_init' );
}

add_action('init', 'bg_widgets_init', 1);
?>