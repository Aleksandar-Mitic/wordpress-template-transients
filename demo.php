<?php
if(false === ($output = get_transient('date-night-restaurants'))) {
	$output = "";
	$query = new WP_Query(array(
		'post_type' => 'restaurant_review',
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => 'star_rating',
				'value' => array(4, 5),
				'compare' => 'IN'
			),
			array(
				'key' => 'has_value',
				'value' => 1
			)
		),
		'orderby' => 'title',
		'order' => 'DESC'
	));

	if($query->have_posts()) {
		$output = "<ul>";
		while($query->have_posts()) {
			$query->the_post()
			$output .= '<li><a href="' . the_permalink() . '">' . the_title . '</a> (' . get_post_meta(get_the_ID(), 'star_rating', true) . ' stars)</li>';
		}
		$output .= "</ul>";
	}
	else {
		$output = "<ul><li>No date night restaurants found.</li></ul>";
	}
	set_transient('date-night-restaurants', $output, 4 * HOUR_IN_SECONDS);
}

echo $output;
?>
