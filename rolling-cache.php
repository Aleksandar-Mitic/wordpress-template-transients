<?php
//get all asides that are in the category music-gigs
if(false === ($output = get_transient('my-gig-asides-list'))) {
	//rebuild transient
	$gigs = new WP_Query(array(
		'post_status' => 'publish',
		'posts_per_page' => 10,
		'orderby' => 'date',
		'order' => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array(
					'post-format-aside'
				),
				'operator' => 'IN'
			),
			array(
				'taxonomy' => 'category',
				'field' => 'slug',
				'terms' => array(
					'music-gigs'
				),
				'operator' => 'IN'
			)
		)
	));
	
	//create transient's value
	$output = '<div id="music-gigs"><h2>Upcoming gigs</h2><ul>';
	if($gigs->have_posts()) {
		while($gigs->have_posts()) {
			$gigs->the_post();
			$output .= '<li><a href="' . the_permalink() . '"><h3>' . the_title() . '</h3></a>';
			$output .= the_excerpt() . '</li>';
		}
	}
	else {
		$output .= '<li>No upcoming gigs available.</li>';
	}
	$output .= "</ul></div>";
	
	//store transient in WP database; expires in 5 minutes
	set_transient('my-gig-asides-list', $output, 5 * MINUTE_IN_SECONDS);
}
//one way or another, we have a valid value in $output; echo it
echo $output;


//get the music review posts
if(false === ($output = get_transient('my-music-reviews'))) {
	$reviews = new WP_Query(array(
		'post_type' => 'music_reviews',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC'
	));

	$output = '<div id="music-reviews"><h2>Music reviews</h2>';
	if($reviews->have_posts()) {
		while($reviews->have_posts()) {
			$output .= '<div class="music-review">';
			$reviews->the_post();
			$output .= '<a href="' . the_permalink() . '"><h2>' . the_title() . '</h2></a>';
			$output .= the_excerpt();
			$output .= "</div>";
		}
	}
	else {
		$output .= "<p>No venues available.</p>";
	}
	$output .= '</div>';
	
	//this transient lasts 4 hours
	set_transient('my-music-reviews', $output, 4 * HOUR_IN_SECONDS);
}
echo $output;

//get the music review posts
if(false === ($output = get_transient('my-venue-reviews'))) {
	$reviews = new WP_Query(array(
		'post_type' => 'music_venues',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC'
	));

	$output = '<div id="music-venues"><h2>Where to listen</h2>';
	if($reviews->have_posts()) {
		while($reviews->have_posts()) {
			$output .= '<div class="music-venues">';
			$reviews->the_post();
			$output .= '<a href="' . the_permalink() . '"><h2>' . the_title() . '</h2></a>';
			$output .= the_excerpt();
			$output .= "</div>";
		}
	}
	else {
		$output .= "<p>No venues available.</p>";
	}
	$output .= '</div>';
	
	//this transient lasts one day
	set_transient('my-venue-reviews', $output, DAY_IN_SECONDS);
}
echo $output;
?>
