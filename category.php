<?php

    // calling the header.php
    get_header();

    // action hook for placing content above #container
    thematic_abovecontainer();

?>

		<div id="container">
		
			<?php thematic_abovecontent(); ?>
		
			<div id="content">
	
	            <?php
	        
	            // displays the page title
	            thematic_page_title();
	
	            // create the navigation above the content
	            thematic_navigation_above();
				
					if ( ! is_main_site() ) : // If we're on a Strand site 
						if ( ! is_user_logged_in() ) { // If user isn't logged in display login form
							?>
							<div class="one-third grid_6">
								<div id="splash-posts">
									<h2>Please sign in.</h2>
									<?php wp_login_form(); ?>
								</div><!-- End #splash-posts-->
							</div><!-- End .one-third grid_6 -->
							<?php 
						} else { // If user is logged in proceed as usual
						
							// action hook for placing content above the category loop
							thematic_above_categoryloop();

/*							
							// Put sticky posts first
							$category = get_the_category();
							$sticky = get_option( 'sticky_posts' );
							
							$args = array(
								'posts_per_page'      => 1,
								'post__in'            => $sticky,
								'cat'                 => $category,
								'ingore_sticky_posts' => 1
							);
							
							query_posts( $args );
							
								// The Sticky Loop
								while (have_posts()) : the_post();
									thematic_abovepost();
									?>
									
										<div id="post-<?php the_ID();
										echo '" ';
										if (!(THEMATIC_COMPATIBLE_POST_CLASS)) {
											post_class();
											echo '>';
										} else {
											echo 'class="';
											thematic_post_class();
											echo '">';
										}
					     					thematic_postheader(); ?>
										
											<div class="entry-content">
												<?php thematic_content(); ?>
											</div><!-- .entry-content -->
										
											<?php thematic_postfooter(); ?>	
										</div><!-- #post -->
									<?php 
								endwhile; // end posts loop
							
								// Reset Query
								wp_reset_query();
*/
							
	            		/* Now display the non-sticky posts as usual */
	            		// action hook creating the category loop
	            		thematic_categoryloop();
	            		
	            		// action hook for placing content below the category loop
	            		thematic_below_categoryloop();
						
						} // End is_user_logged_in() check
						
					else : // If it is the Main Site, proceed as usual
						
						// action hook for placing content above the category loop
	            	thematic_above_categoryloop();
	
	            	// action hook creating the category loop
	            	thematic_categoryloop();

	            	// action hook for placing content below the category loop
	            	thematic_below_categoryloop();
    	   		
    	   		endif; // Stop checking for Main Site
					
	            // create the navigation below the content
	            thematic_navigation_below();
	            
	            ?>
	
			</div><!-- #content -->
			
			<?php thematic_belowcontent(); ?> 
			
		</div><!-- #container -->

<?php 

    // action hook for placing content below #container
    thematic_belowcontainer();

    // calling the standard sidebar 
    thematic_sidebar();

    // calling footer.php
    get_footer();

?>