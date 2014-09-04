<?php
if(current_user_can('read')) {
	if(false === ($output = get_transient('my-insider-news'))) {
		$blurbs = new WP_Query(array(
			'post_status' => 'publish',
			'posts_per_page' => 5,
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
						'insiders'
					),
					'operator' => 'IN'
				)
			)
		));
		
		echo '<ul>';
		if($blurbs->have_posts()) {
			while($blurbs->have_posts()) {
				$blurbs->the_post();
				echo '<li><a href="' . the_permalink() . '"><h3>' . the_title() . '</h3></a>';
				echo the_excerpt() . '</li>';
			}
		}
		else {
			echo '<li>No insider information today.</li>';
		}
		echo '</ul>';
		
		//transient will last a half-hour
		set_transient('my-insider-news', $output, 30 * MINUTE_IN_SECONDS);
	}
	echo $output;
}
?>
