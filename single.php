<?php

    // calling the header.php
    get_header();

    // action hook for placing content above #container
    thematic_abovecontainer();

?>

		<div id="container">
			
			<?php thematic_abovecontent(); ?>
			
			<div id="content">
				
			<?php if ( ! is_main_site() ) : // If we're on a Strand site 
				
				if ( is_user_logged_in() ) : // Start gate
				
    	        the_post();
    	        
    	        // create the navigation above the content
					thematic_navigation_above();
		
    	        // calling the widget area 'single-top'
    	        get_sidebar('single-top');
		
    	        // action hook creating the single post
    	        thematic_singlepost();
				
    	        // calling the widget area 'single-insert'
    	        get_sidebar('single-insert');
		
    	        // create the navigation below the content
					thematic_navigation_below();
		
    	        // calling the comments template
    	        thematic_comments_template();
		
    	        // calling the widget area 'single-bottom'
    	        get_sidebar('single-bottom');
				
				else : // If user IS NOT logged in ?>
					<div class="one-third grid_6">
						<div id="splash-posts">
							<h2>Please sign in.</h2>
							<?php wp_login_form(); ?>
						</div><!-- End #splash-posts-->
					</div><!-- End .one-third grid_6 -->
				<?php endif; // End gate
			
			else : // If it is the Main Site
				  the_post();
    	        
    	        // create the navigation above the content
					thematic_navigation_above();
		
    	        // calling the widget area 'single-top'
    	        get_sidebar('single-top');
		
    	        // action hook creating the single post
    	        thematic_singlepost();
				
    	        // calling the widget area 'single-insert'
    	        get_sidebar('single-insert');
		
    	        // create the navigation below the content
					thematic_navigation_below();
		
    	        // calling the comments template
    	        thematic_comments_template();
		
    	        // calling the widget area 'single-bottom'
    	        get_sidebar('single-bottom');
    	   
    	   endif; // Stop checking for Main Site ?>
			
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