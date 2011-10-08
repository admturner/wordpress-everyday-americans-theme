<?php
/**
 * Template Name: Participant Splash Page
 * 
 * A custom page template for the Participant Splash Pages.
 *
 * @package WordPress
 * @subpackage ThematicChild_UnveilingHistory
 * @since 0.1.0
 */

    // calling the header.php
    get_header();

    // action hook for placing content above #container
    thematic_abovecontainer();

?>


	<div id="container">
		<div id="content">		

<?php // Check if the user is logged in when we're on cohort pages
// ADAM: MOVE THIS TO THE header.php FILE AND SET UP TO CALL ON <ALL> COHORT PAGES
if ( is_user_logged_in() ) : ?>

			<h1><?php bloginfo(description); ?></h1>		

			<h3 class="sans-serif">RECENT POSTS:</h3>
			
            <?php
        
            // calling the widget area 'page-top'
            get_sidebar('page-top');

            the_post();
        
            ?>
            
			<div id="post-<?php the_ID(); ?>" class="<?php thematic_post_class() ?>">
            
                <?php 
                /* THIS USED TO CALL THE PAGE TITLE, ETC. It has been moved up one level and is now called directly rather than using Thematic's filter. */
                // creating the post header
                //thematic_postheader();
                ?>
                
				<div class="entry-content">
					
					<?php if ( is_front_page() && is_page_template('page-theme-splash.php') ) : 
						/*ADAM: I change the above to page-theme-splash.php from page-cohort-splash.php  CR 2.10.2011*/						
						/*
						 * Display the 5 most recent posts in the participant's Blog
						 *
						 * See the Codex (http://codex.wordpress.org/Template_Tags/get_posts)
						 * for details. To change the number of Featured posts displayed,  
						 * change the numberposts=5 number to desired count.
						 *
						 * @uses get_posts
						 * @since 0.1.0
						 */
						global $post;
						$posts = get_posts('numberposts=5'); // Gets the list from the WP database
						foreach( $posts as $post ) : // Loop through the list, and do the following for each post
							setup_postdata($post); // Get the post data to display
							?>
							<div>
								<h3><a id="post-<?php the_ID(); ?>" <?php post_class(); ?> href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<?php the_excerpt(); // auto-wraps in <p> tags ?>
								<h4>Category: <?php the_category(', '); ?></h4>
							</div>
						<?php endforeach; ?>
        				        				
					<?php 
					/*
						// No Content need on Participant Splash Pages 
						the_content();
					*/
					
					endif; // End of the Page-checking, continue as usual 
                    
                    wp_link_pages("\t\t\t\t\t<div class='page-link'>".__('Pages: ', 'thematic'), "</div>\n", 'number');
                    
                    edit_post_link(__('Edit', 'thematic'),'<span class="edit-link">','</span>') ?>

				</div>
			</div><!-- .post -->

        <?php if ( get_post_custom_values('comments') ) {
            thematic_comments_template(); // Add a key/value of "comments" to enable comments on pages!
        }
        ?>

		</div><!-- #content -->
	</div><!-- #container -->


<?php 

    // action hook for placing content below #container
    thematic_belowcontainer();

    // Calling the standard sidebar
    thematic_sidebar();
    
else : // If the user isn't logged in: ?>

<h2>Please sign in</h2>
<?php // ADAM: We will only have 2 "cohort" pages actually theme pages: War & Society and U.S. History--so change these accordingly CR
if ( is_front_page() ) :
	if ( is_page('Middle School Teachers Cohort') ) {
		wp_login_form('redirect=http://unveilinghistory.org/middle1/');
	} elseif ( is_page('High School Teachers Cohort') ) {
		wp_login_form('redirect=http://unveilinghistory.org/high1/');
	} else {
		wp_login_form('redirect=http://unveilinghistory.org/elementary1/');
	}
else :
	wp_login_form();
endif;

endif; // END <IS USER LOGGED IN> CHECK
    
    // calling footer.php
    get_footer();

?>