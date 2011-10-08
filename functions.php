<?php
/*
 * Child Theme Functions for Everyday Americans, Exceptional Americans. 
 *
 * Modified to _loudoun for EAEA 2011-02-09 by CAR
 * 
 * @since _loudoun References to uh changed to eaea
 * @since _loudoun Call a different stylesheet for cohort splash
 * @since _loudoun Different access and nav menus, change excerpt length, etc.
 *
 * CONTENTS
 * -- Navigation modifications
 * -- Stylesheets and Scripts
 * -- Post / Page mods
 * -- Spring cleaning (cutting some cruft)
 * -- Custom Functions (upcoming events; display posts; login redirect)
 *
 * @ver 0.2.2
 */

/**
 * -------------------------------------------------
 * NAVIGATION modifications to alter the default theme
 * -------------------------------------------------
*/

/**
 * Remove Thematic's default primary navigation (#access) and site title
 *
 * Site title re-added below (@since 0.2.1)
 *
 * @since 0.1.0
 */
function remove_thematic_actions() {
	remove_action('thematic_header','thematic_access',9);
	remove_action('thematic_header','thematic_blogtitle',3);
}
add_action('init', 'remove_thematic_actions');

/*
 * Add our own primary navigation for EAEA
 *
 * This uses the Menu functionality to allow for two custom menus
 * in the header div. Create/edit Menus in the WP Admin area. See
 * http://codex.wordpress.org/Function_Reference/register_nav_menus
 * for details about creating admin menus on the PHP side.
 *
 * @since 0.1.0
 */
// First create our 2 navigation menus
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
			'eaea_public_pages' => __('Primary Public Pages'),
			'eaea_strand_pages' => __('Participant Splash Pages')
		)
	);
}
// Now insert them into the template where we removed Thematic's default
function eaea_childtheme_access() { ?>
	<div id="access">
		<div class="skip-link"><a href="#content" title="<?php _e('Skip navigation to the content', 'thematic'); ?>"><?php _e('Skip to content', 'thematic'); ?></a></div>
		<?php // Call the navigation menus if they exist; parameters and ids/classes can be altered as described in the codex: http://codex.wordpress.org/Function_Reference/wp_nav_menu
			wp_nav_menu( array('theme_location' => 'eaea_strand_pages', 'container_id' => 'strand-pages', 'fallback_cb' => '') );
		?>
	</div><!-- #access -->
<?php 
}
add_action('thematic_header','eaea_childtheme_access',8);


/**
 * -------------------------------------------------
 * STYLESHEET and SCRIPT additions and removals
 * -------------------------------------------------
*/

/**
 * Calls the 960.css stylesheet in the childtheme header
 *
 * @since 0.2.0 Using wp_enqueue_style() instead of thematic's workaround
 */
function eaea_childtheme_style() {
		wp_register_style('eaea_childtheme_stylesheet', get_bloginfo( 'stylesheet_directory' ) . '/960.css');
		wp_enqueue_style('eaea_childtheme_stylesheet');
		
		wp_register_script( 'colorbox', get_bloginfo('stylesheet_directory') . '/js/jquery/jquery.colorbox-min.js', '', '', true );
		wp_register_script( 'tahscript', get_bloginfo( 'stylesheet_directory' ) . '/js/jquery/tah-script.js', array('jquery', 'colorbox'), '', true );
		wp_enqueue_script( 'tahscript' );
		
		wp_register_style( 'colorbox_style', get_bloginfo('stylesheet_directory') . '/css/colorbox/colorbox.css' );
		wp_enqueue_style( 'colorbox_style' );			
}
add_action('wp_print_styles', 'eaea_childtheme_style');

/**
 * Create function to call a different layout css file for cohort splash pages
 *
 * @since 0.2.0 Switched to a simpler conditional test [2011-03-15 by Adam]
 * @since 0.2.0 Switched to using wp_enqueue_style() since its WordPressier
 * @since 0.2.1 STOPPED USING UNTIL LAYOUT CAN BE FIXED

function eaea_cohort_splash_css() {
	// If we're *not* looking at the main blog in the network
	if ( ! is_main_site() ) {
		if ( is_front_page() ) {
			wp_register_style( 'cohort_splash_style', get_bloginfo('template_directory') . '/library/layouts/3c-r-fixed-primary.css' );
			wp_enqueue_style( 'cohort_splash_style' );
		}
	}
}
add_action('wp_print_styles', 'eaea_cohort_splash_css');
*/

/**
 * We're not using dropdown menus so let's get rid of the script in the header
 *
 * @since 0.1.0
 */
function childtheme_remove_scripts() {
    remove_action('wp_head','thematic_head_scripts');
}
add_action('init', 'childtheme_remove_scripts');


/**
 * -------------------------------------------------
 * POST and PAGE modifications to alter the default theme
 * -------------------------------------------------
*/

/**
 * New title
 * 
 * Replace default title (removed above) with custom title (for href tweaks)
 *
 * @since 0.2.1
 */
function eaea_site_title() {
	echo '<div id="blog-title"><span><a href="' . esc_url( get_blogaddress_by_id(1) ) . '" title="Permalink to ' . esc_attr( get_blog_option( 1, 'blogname' ) ) . '" rel="home">' . get_blog_option( 1, 'blogname' ) . '</a></span></div>';
}
add_action('thematic_header','eaea_site_title',3);

/**
 * Filter the excerpt's "[...]" more text to display what we want.
 *
 * The default an unlinked [...] to denote more text at the end of an
 * excerpt. The following filter replaces that with a "More..." link.
 * We can also shorted the excerpt length, if desired.
 *
 * @since 0.1.0
 */
function new_excerpt_more( $more ) {
	global $post;
	return ' <span class="more"><a href="' . get_permalink($post->ID) . '">' . 'more...</a></span>';
}
add_filter('excerpt_more', 'new_excerpt_more');

/**
 * Shorten excerpts on splash pages
 * 
 * From: http://www.transformationpowertools.com/wordpress/automatically-shorten-manual-excerpt
 *
 * @since 0.2.0
 */
function wp_trim_all_excerpt($text) {
	// Creates an excerpt if needed; and shortens the manual excerpt as well
	global $post;
  	if ( '' == $text ) {
  		$text = get_the_content('');
  		$text = apply_filters('the_content', $text);
  		$text = str_replace(']]>', ']]&gt;', $text);
  	}
	$text = strip_shortcodes( $text );
	$text = strip_tags($text); // need this to prevent unclosed hmtl markup breaking layout
	$excerpt_length = apply_filters('excerpt_length', 25);
	$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
	$words = explode(' ', $text, $excerpt_length + 1);
	if (count($words)> $excerpt_length) {
		array_pop($words);
		$text = implode(' ', $words);
		$text = $text . $excerpt_more;
	} else {
		$text = implode(' ', $words);
	}
	return $text;
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wp_trim_all_excerpt');

/*
 * Add support for Featured Images (post thumbnails) and set sizes
 *
 * These can be added on the Edit Post and Edit Page screens in the
 * Admin area. set_post_thumbnail_size defines the default thumbnail
 * size. 1st number = width; 2nd number = height; 'true' tells WP to
 * hard-crop the image to fit the size specified. Delete ', true' to
 * have WP resize the image instead (will retain original aspect ratio).
 * See http://bit.ly/4t2qaq for details.
 *
 * @since 0.1.0
 */
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(100, 100, true);
	add_image_size('single-post-thumbnail', 400, 9999);
}

/**
 * -------------------------------------------------
 * SPRING CLEANING removing thematic cruft
 * -------------------------------------------------
*/

// drop some of the excess dynamic body classes thematic generates
function dont_show_bc_datetime() {
	return FALSE;
}
add_filter('thematic_show_bc_datetime', 'dont_show_bc_datetime');

function dont_show_bc_pagex() {
	return FALSE;
}
add_filter('thematic_show_bc_pagex', 'dont_show_bc_pagex');

function dont_show_thematic_date_classes() {
	return FALSE;
}
add_filter('thematic_date_classes', 'dont_show_thematic_date_classes');


/**
 * -------------------------------------------------
 * CUSTOM FUNCTIONS such as the upcoming events for the front page
 * -------------------------------------------------
*/

/**
 * Function for calling and displaying upcoming events
 *
 * This function pulls upcoming events from the ScholarPress
 * schedule across ANY of the multisite network sites. Just
 * specify the site's /url/ (eg: war-and-society) in the template
 * tag and how many events you want displayed. 
 *
 * The syntax is: eaea_upcoming_events( 'strand_first=url&strand_second=url' );
 *
 * You can also specify how many events are displayed with 'howmany_first=INTEGER'
 * and the <h3> title with 'title_first=new title'
 *
 * @uses ScholarPress plugin
 * @todo Add alternate behavior for is SP Courseware isn't active
 * @since 0.2.0
 */
function eaea_upcoming_events( $args ) { 
	global $wpdb;
	
	$defaults = array(
		'strand_first' => '',
		'strand_second' => '',
		'howmany_first' => (int) 1,
		'howmany_second' => (int) 1,
		'title_first' => '',
		'title_second' => '',
		'two_sites' => false,
		'visibility' => '',
		'nodate_first' => false,
		'nodate_second' => false,
		'regurl_first' => '',
		'regurl_second' => '',
	);
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );
	
	if ( ! function_exists( 'is_plugin_active' ) ) {
		require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	   // Makes sure the plugin is defined before trying to use it
	}
   // Make sure ScholarPress is active, otherwise don't bother				
	if ( is_plugin_active( 'scholarpress-courseware/spcourseware-admin.php' ) ) :
						
		// Switch to first desired strand's site url (eg: 'war-and-society')
		$strand_firstID = get_id_from_blogname($strand_first); // first convert blog name into ID	
		switch_to_blog($strand_firstID); // then switch to it
		
		// Get first upcoming event for the site we've just switched to
		if ( $visibility == 'public' ) :
			$eaeaEvents = sp_courseware_schedule_get_upcoming_entries_by_visibility( $howmany_first, 'public' );
		elseif ( $visibility == 'group' ) :
			$eaeaEvents = sp_courseware_schedule_get_upcoming_entries_by_visibility( $howmany_first, 'group' );
		elseif ( $visibility == 'bylogin' ) :
			if ( !is_user_logged_in() ) {
				// if user not logged in, only show public events
				$eaeaEvents = sp_courseware_schedule_get_upcoming_entries_by_visibility( $howmany_first, 'public' );				
			} else {
				// if user is logged in, show all upcoming events no matter visibility
				$eaeaEvents = sp_courseware_schedule_get_upcoming_entries( $howmany_first );
			}
		else :
			$eaeaEvents = sp_courseware_schedule_get_upcoming_entries( $howmany_first );
		endif;

		// If there are upcoming events, display them
		?>
		<ul>
			<li>
				<h3><?php if ( empty($title_first) ) { bloginfo( 'name' ); } else { echo $title_first; } ?></h3>
				
				<?php if (count($eaeaEvents) > 0) {
					foreach ($eaeaEvents as $event) {						
					?>
						<p>
							<span class="cal-title"><?php echo $event->schedule_title; ?></span><br />
							<?php if ( $nodate_first == false ) { ?><span class="cal-date"><?php echo date('F d, Y', strtotime($event->schedule_date)); ?></span><br /><?php } ?>
							<span class="cal-place"><?php echo $event->schedule_location; ?></span><br />
						</p>
					<?php	
					} // end foreach
				} else { // If SP Courseware lists no upcoming events ?>
					<p><span class="cal-title">There are no upcoming schedule events for <?php bloginfo('name'); ?>.</span></p>
				<?php } ?>
			</li>
			<li class="register"><a href="http://chnm.gmu.edu/tah-loudoun/calendar/" class="more">Event Details</a></li>
			<li class="register"><?php if ( ! empty($regurl_first) ) { ?><a href="<?php echo $regurl_first; ?>">Register for upcoming events</a><?php } ?></li>
		</ul>
		
		<?php 
		// Switch back to current site to reset
		restore_current_blog();
		
		if ( $two_sites == false ) :
			// Switch to next strand url (eg: 'us-history')						
			$strand_secondID = get_id_from_blogname($strand_second); // first convert blog name into ID	
			switch_to_blog($strand_secondID); // then switch to it
						
			// Get first upcoming event for the site we've just switched to
			if ( $visibility == 'public' ) :
				$eaeaEvents = sp_courseware_schedule_get_upcoming_entries_by_visibility( $howmany_second, 'public' );
			elseif ( $visibility == 'group' ) :
				$eaeaEvents = sp_courseware_schedule_get_upcoming_entries_by_visibility( $howmany_second, 'group' );
			elseif ( $visibility == 'bylogin' ) :
				if ( !is_user_logged_in() ) {
					// if user not logged in, only show public events
					$eaeaEvents = sp_courseware_schedule_get_upcoming_entries_by_visibility( $howmany_second, 'public' );				
				} else {
					// if user is logged in, show all upcoming events no matter visibility
					$eaeaEvents = sp_courseware_schedule_get_upcoming_entries( $howmany_second );
				}
			else :
				$eaeaEvents = sp_courseware_schedule_get_upcoming_entries( $howmany_second );
			endif;
			
			// If there are upcoming events, display them
			?>
			<ul>
				<li>
					<h3><?php if ( empty($title_second) ) { bloginfo( 'name' ); } else { echo $title_second; } ?></h3>
					
					<?php if (count($eaeaEvents) > 0) {
						foreach ($eaeaEvents as $event) {
						?>
							<p>
								<span class="cal-title"><?php echo $event->schedule_title; ?></span><br />
								<?php if ( $nodate_second == false ) { ?><span class="cal-date"><?php echo date('F d, Y', strtotime($event->schedule_date)); ?></span><br /><?php } ?>
								<span class="cal-place"><?php echo $event->schedule_location; ?></span><br />
							</p>
						<?php	
						} // end foreach
					} else { // If SP Courseware lists no upcoming events ?>
						<p><span class="cal-title">There are no upcoming schedule events for <?php bloginfo('name'); ?>.</span></p>
					<?php } ?>
				</li>
				<li class="register"><a href="http://chnm.gmu.edu/tah-loudoun/calendar/" class="more">Event Details</a></li>
				<li class="register"><?php if ( ! empty($regurl_second) ) { ?><a href="<?php echo $regurl_second; ?>">Register for upcoming events</a><?php } ?></li>
			</ul>
			<?php
			// Switch back to current site
			restore_current_blog();
		endif; // endif for $two_site check
		
	endif; // endif for SP Courseware conditional test
	
		// Do something here if ScholarPress Courseware plugin is not installed or activated
}

/**
 * Collect and display posts from any category.
 *
 * See the Codex (http://codex.wordpress.org/Template_Tags/get_posts)
 * for details. Change to: get_posts('numberposts=2&cat=5'); to 
 * eliminate the random selection and simply order by most recent.
 * Also, to change the number of Featured posts displayed, change 
 * the numberposts=2 number to desired count.
 *
 * @uses get_posts
 * @since 0.2.0
 */
function eaea_display_posts( $args ) { 
	global $post;
	
	$defaults = array(
		'howmany' => (int) 3, // changed to 3 for design reasons--CR 3.25.11
		'fromcat' => '',
		'orderby' => 'rand',
		'source_blog' => '',
		'showthumb' => true,
		'long' => false,
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );
	
	// Select which blog to pull random posts from
	$sourceID = get_id_from_blogname($source_blog); // first convert blog name into ID	
	switch_to_blog($sourceID); // then switch to it
	
	$kinds = array(
			'post_type' => array( 'lessons', 'post' ),
			'numberposts' => $howmany,
			'category' => $fromcat,
			'orderby' => $orderby
		);
	$featuredposts = get_posts( $kinds ); // Gets the list from the WP database

	foreach( $featuredposts as $post ) : // Loop through the list, and do the following for each post		
		setup_postdata($post); // Get the post data to display
		$alt_avatar_url = get_bloginfo( 'stylesheet_directory' ) . '/images/users/' . get_the_author_meta( 'user_login' ) . '.jpg';

		// The following is what is actually output for each Featured Post

		if ( $long == false ) : ?>
			<div id="post-<?php the_ID(); ?>" class="<?php thematic_post_class() ?>"> 
				<div class="entry-content">
					<?php if ( $showthumb == true ) {
						if ( has_post_thumbnail() ) {
							the_post_thumbnail(); // This is the image thumb, set this on the Edit Post page (default size; set in functions.php)
						} else { // If the Post doesn't specify a Featured Image, then display the following img (chosen arbitrarily) ?>
							<img src="<?php bloginfo('url'); ?>/wp-content/uploads/bill-of-rights_300x300.jpg" alt="" width="100" height="100" />
						<?php } 
					} ?>
					<h2><a id="post-<?php the_ID(); ?>-link" <?php post_class(); ?> href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); // auto-wraps in <p> tags ?>
				</div><!-- end .entry content -->				
			</div><!-- end #post -->
														
		<?php else : ?>
			<div class="recent-post recent-post-<?php the_ID(); ?>">
				<?php if ( $showthumb == true ) {
					echo get_avatar( get_the_author_meta('user_email'), 50, $alt_avatar_url ); /* 50 is the avatar image width in pixels */ ?>
				<?php } ?>
				<h3><a id="post-<?php the_ID(); ?>" <?php post_class(); ?> href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<?php the_excerpt(); /* auto-wraps in <p> tags */ ?>
				<h4 class="meta">Category: <?php the_category(', '); /* the post's Category */ ?></h4>
			</div><!-- end .recent-post -->
						
		<?php endif; ?>
						
	<?php endforeach;

	// Reset the WP main loop
	wp_reset_query();
}

/**
 * Filter WordPress login function redirect
 *
 * Filters the redirect default of the WordPress login function
 * to redirect users to their primary blog homepage.
 *
 * @since 0.2.2
 */
function eaea_login_redirect($redirect_to, $url_redirect_to = '', $user = null) {
	if( $user->ID ) {
		
		$primary_site = get_active_blog_for_user( $user->ID );
		$user = new WP_User( $user->ID );
		
		if ( ! empty( $user->roles ) ) {	
			if ( ! in_array('administrator', $user->roles) ) {
				return $primary_site->siteurl;
			} else {
				return home_url();
			}
		}
	}
}
add_filter('login_redirect', 'eaea_login_redirect', 10, 3);
?>