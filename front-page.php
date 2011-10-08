<?php 
// calling the header.php
get_header();

	// action hook for placing content above #container
	thematic_abovecontainer(); 
?>

	<?php if ( is_main_site() ) : // Start of main public site ?>
	
		<div id="container">
			<div id="content">
		
			<?php 
			get_sidebar('page-top'); // calling the widget area 'page-top'		
			the_post()
			?>

				<div id="home-banner">&nbsp;</div><!-- end #home-banner -->
					<div class="clearer"></div>
			
					<div id="home-insert">
					<!-- 
 			  		#home-insert encloses the calendar, featured posts and 
					pages ul in 3 columns so it can get its own background, 
					height, etc. 
					-->
					
						<div class="one-third grid_3">
							<div id="calendar-wrap" class="dashed-box">							
								<div id="calendar"><!-- this will be the container box for events, have maroon bg, pad and dashed border -->
									<h2 id="upcoming" class="hide-text">Coming Up</h2><!-- this will be the hidden-text heading with headline image hd_comingup.png -->
									<?php
									/**
									 * The function to call the upcoming events is in 
									 * functions.php These conditional statements just make
									 * it easier to customize the function using custom
								  	 * fields from the WP 'Home' Page.
									 */					
									$thearg = '';
								
									if ( get_post_meta($post->ID, 'upcoming_strand-first', true) ) {
										$first_strand = get_post_meta($post->ID, 'upcoming_strand-first', true);
										$thearg = 'strand_first='.$first_strand.'';
									}
									if ( get_post_meta($post->ID, 'upcoming_strand-second', true) ) {
										$second_strand = get_post_meta($post->ID, 'upcoming_strand-second', true);
										$thearg = $thearg . '&strand_second='.$second_strand.'';
									}
									if ( get_post_meta($post->ID, 'upcoming_title-first', true) ) {
										$first_title = get_post_meta($post->ID, 'upcoming_title-first', true);
										$thearg = $thearg . '&title_first='.$first_title.'';
									}
									if ( get_post_meta($post->ID, 'upcoming_title-second', true) ) {
										$second_title = get_post_meta($post->ID, 'upcoming_title-second', true);
										$thearg = $thearg . '&title_second='.$second_title.'';
									}
									if ( get_post_meta($post->ID, 'upcoming_howmany-first', true) ) {
										$first_howmany = get_post_meta($post->ID, 'upcoming_howmany-first', true);
										$thearg = $thearg . '&howmany_first='.$first_howmany.'';
									}
									if ( get_post_meta($post->ID, 'upcoming_howmany-second', true) ) {
										$second_howmany = get_post_meta($post->ID, 'upcoming_howmany-second', true);
										$thearg = $thearg . '&howmany_second='.$second_howmany.'';
									}																
									if ( get_post_meta($post->ID, 'upcoming_hidedate_first', true) ) {
										if ( get_post_meta($post->ID, 'upcoming_strand-first', true) ) {
											$thearg = $thearg . '&nodate_first=1';
										} else {
											$thearg = 'nodate_first=1';
										}
									}
									if ( get_post_meta($post->ID, 'upcoming_hidedate_second', true) ) {
										if ( get_post_meta($post->ID, 'upcoming_strand-first', true) ) {
											$thearg = $thearg . '&nodate_second=1';
										} else {
											$thearg = 'nodate_second=1';
										}
									}
									
									if ( get_post_meta($post->ID, 'register_url_first', true) ) {
										if ( get_post_meta($post->ID, 'upcoming_strand-first', true) ) {
											$url_first = get_post_meta($post->ID, 'register_url_first', true);
											$thearg = $thearg . '&regurl_first='.$url_first.'';
										} else {
											$thearg = 'regurl_first='.$url_first.'';
										}
									}
									if ( get_post_meta($post->ID, 'register_url_second', true) ) {
										if ( get_post_meta($post->ID, 'upcoming_strand-first', true) ) {
											$url_second = get_post_meta($post->ID, 'register_url_second', true);
											$thearg = $thearg . '&regurl_second='.$url_second.'';
										} else {
											$thearg = 'regurl_second='.$url_second.'';
										}
									}
									
									if ( get_post_meta($post->ID, 'upcoming_twosites', true) ) {
										if ( get_post_meta($post->ID, 'upcoming_strand-first', true) ) {
											$thearg = $thearg . '&two_sites=1';
										} else {
											$thearg = 'two_sites=1';
										}
									}
									if ( get_post_meta($post->ID, 'upcoming_visibility', true) ) {
										if ( get_post_meta($post->ID, 'upcoming_visibility', true) ) {
											$vis = get_post_meta($post->ID, 'upcoming_visibility', true);
											$thearg = $thearg . '&visibility='.$vis.'';
										} elseif ( get_post_meta($post->ID, 'upcoming_strand-first', true) ) {
											$vis = get_post_meta($post->ID, 'upcoming_visibility', true);
											$thearg = $thearg . '&visibility='.$vis.'';
										} else {
											$vis = get_post_meta($post->ID, 'upcoming_visibility', true);
											$thearg = 'visibility='.$vis.'';
										}
									}
								
									eaea_upcoming_events( $thearg ); ?>
																						
								</div><!-- end #calendar -->
							</div><!-- end #calendar-wrap -->
						</div><!-- end one-third -->

						<div class="one-third grid_6">
							<div id="featured">
								<h3>Featured</h3>
															
								<?php 
								/** 
								 * Display random posts, customize with any of the following
								 *
								 * eaea_random_posts( 'howmany=2&fromcat=1&orderby=rand&source_blog=&showthumb=true' );
								 * fromcat is the category id, and source_blog is the networked site's end url (eg warandsociety)
								 */
								eaea_display_posts('howmany=3'); 
								?>
	
							</div><!-- end #featured -->
						</div><!-- end one-third -->

						<div class="one-third last omega grid_3">
							<div id="public-pages">
								<h3>Public Materials</h3>
								<ul id="placeholder" class="placeholder">
									<li class="menu-item menu-item-type-post_type">
										<h4><a href="http://chnm.gmu.edu/tah-loudoun/primary-source-activities/">Primary Source Activities</a></h4>
										<p>Bring history to life for students by using primary sources.<a href="http://unveilinghistory.org/primary-source-activities/">»</a> </p>
									</li>
									<li class="menu-item menu-item-type-post_type">
										<h4><a href="http://chnm.gmu.edu/tah-loudoun/podcasts/">Podcasts</a></h4>
										<p>Listen to podcasts from history teachers.<a href="http://unveilinghistory.org/podcasts/">»</a> </p>
									</li>
									<li class="menu-item menu-item-type-post_type">
										<h4><a href="http://chnm.gmu.edu/tah-loudoun/lessons/">Lessons</a></h4>
										<p>Delve into lessons developed by American history teachers.<a href="http://unveilinghistory.org/lessons/">»</a> </p>
									</li>
									<li class="menu-item menu-item-type-post_type">
										<h4><a href="http://chnm.gmu.edu/tah-loudoun/resources/">Resources</a></h4>
										<p>Explore teaching resources on the subject of American history.<a href="http://unveilinghistory.org/resources/">»</a> </p>					
									</li>
								</ul><!-- end #menu-primary-public-pages -->
							</div><!-- end #public-pages --> 
							
							<div id="learn-more-wrap" class="dashed-box">
								<div id="learn-more">
									<h4 class="knockout">Interested in Participating?</h4>
									<p><a href="<?php bloginfo( 'url' ); ?>/apply/">Apply Now &raquo;</a></p>
								</div><!-- end #learn-more -->								
							</div><!-- end #learn-more-wrap -->
						</div><!-- end one-third last -->
				
					</div><!-- end #home-insert-->
					<div class="clearer"></div>

			</div><!-- #content -->
		</div><!-- #container -->

	
	<?php else : // End main site public home page, Start theme splash pages ?>
	
		<div id="container-splash">
			<h1 id="<?php $h1class = get_bloginfo( 'name' ); echo strtolower(preg_replace( '/\s+/', '', $h1class )); ?>" class="hide-text">War and Society Theme</h1>
			
				<?php if ( is_user_logged_in() ) : // Start gate ?>
					<div class="one-third grid_6">
						<div id="splash-posts">
							<h2>Recent Posts</h2>				
							<?php 
							// eaea_display_posts() is in functions.php
							eaea_display_posts( 'long=1&orderby=asc' ); 
						 
							wp_link_pages("\t\t\t\t\t<div class='page-link'>".__('Pages: ', 'thematic'), "</div>\n", 'number');
							edit_post_link(__('Edit', 'thematic'),'<span class="edit-link">','</span>');
							
							if ( get_post_custom_values('comments') ) {
								thematic_comments_template(); // Add a key/value of "comments" to enable comments on pages!
							}
							?>
						</div><!-- End #splash-posts-->	
					</div><!-- End .one-third grid_6 -->
		
					<div class="one-third grid_3">
						<div id="splash-assignments">	
							<h2>Assignment Topics</h2>
							<ul>
							<?php /* The category list, by ID, in descending order (most recent first) */
								wp_list_categories('orderby=id&order=desc&title_li='); 
							?>
							</ul>
						</div><!-- End #splash-assignments -->
					</div><!-- .one-third grid_3 -->
		
					<div class=".one-third last omega grid_3">
						<div id="splash-schedule">
							<h2>Schedule Highlights</h2>
							<?php 
							/**
							 * The Schedule Content from ScholarPress
							 *
							 * Display the upcoming entries from the ScholarPress
							 * plugin schedule, ordered with the most current first.
							 *
							 */
							/* First get the n upcoming events from the SP database */
							$results = sp_courseware_schedule_get_upcoming_entries( 1 );
							/* Loop through the 3 retrieved events and do the following for each */
							foreach( $results as $result ) : 
								$eventDate  = strtotime($result->schedule_date); 
								// Here is the HTML markup for each individual event.
								?>
								<div class="schedule-entry-<?php echo $result->scheduleID; ?> schedule-entry">
									<p>
										<span class="cal-title"><?php echo $result->schedule_title; // the Title ?></span><br />
										<span class="cal-date"><?php echo date('F d, Y', $eventDate); // the Date ?></span><br />
										<span class="cal-shortdesc"><?php echo $result->schedule_location; // the Location ?></span>
									</p>
									<p><span class="more"><a href="<?php bloginfo('url'); ?>/schedule/">See more events ...</a></span></p>
								</div><!-- end schedule-entry -->
							<?php endforeach; ?>
						</div><!-- End #splash-schedule -->
						
						<?php // Assignments links loop
							$assignment_links = get_post_custom_values('assignment link');
				 			foreach ( $assignment_links as $key => $value ) { 
				 			?>
				 				<h4><?php echo $value; ?></h4>
					 		<?php 
				 			} 
				 		?>
						
					</div><!-- End .one-third last omega grid_3 -->
				
				<?php else : // If user IS NOT logged in ?>
					<div class="one-third grid_6">
						<div id="splash-posts">
							<h2>Please sign in.</h2>
							<?php wp_login_form(); ?>
						</div><!-- End #splash-posts-->
					</div><!-- End .one-third grid_6 -->
				<?php endif; // End gate ?>
			
			<div class="clearer"></div>
		</div><!-- End #container-splash -->
		
	<?php endif; // End theme splash pages ?>

<?php // thematic_belowcontainer(); // action hook for placing content below #container
get_footer(); // calling footer.php ?>