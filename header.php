<?php

    // Creating the doctype
    thematic_create_doctype();
    echo " ";
    language_attributes();
    echo ">\n";
    
    // Creating the head profile
    thematic_head_profile();

    // Creating the doc title
    thematic_doctitle();
    
    // Creating the content type
    thematic_create_contenttype();
    
    // Creating the description
    thematic_show_description();
    
    // Creating the robots tags
    thematic_show_robots();
    
    // Creating the canonical URL
    thematic_canonical_url();
    
    // Loading the stylesheet
    thematic_create_stylesheet();
    
    // Creating the internal RSS links
    thematic_show_rss();
    
    // Creating the comments RSS links
    thematic_show_commentsrss();
    
    // Creating the pingback adress
    thematic_show_pingback();
    
    // Enables comment threading
    thematic_show_commentreply();

    // Calling WordPress' header action hook
    wp_head();
    
?>

</head>

<?php if (apply_filters('thematic_show_bodyclass',TRUE)) { ?>
<body <?php 
		global $blog_id; 
		if ( is_main_site() ) { 
			if ( is_front_page() ) { 
				echo 'id="front-page" ';
			}
		} else {
				echo 'id="strand-page" ';
		} ?>class="<?php thematic_body_class() ?>">
<?php }

/**
 * Thematic's action hook for placing content before opening #wrapper 
 * thematic_before(); 
 */
?>

<div id="wrapper" class="hfeed">
	
	<?php thematic_aboveheader(); // action hook for placing content above the theme header ?>

	<div id="header">
		<?php thematic_header(); // action hook creating the theme header ?>
	</div><!-- #header-->

	<?php thematic_belowheader(); // action hook for placing content below the theme header ?>

	<div id="main">