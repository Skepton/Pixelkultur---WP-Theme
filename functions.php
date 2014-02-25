<?php
function themepixel_time_ago() {
 
	global $post;
 
	$date = get_post_time('G', true, $post);
 
	/**
	 * Where you see 'themepixel' below, you'd
	 * want to replace those with whatever term
	 * you're using in your theme to provide
	 * support for localization.
	 */ 
 
	// Array of time period chunks
	$chunks = array(
		array( 60 * 60 * 24 * 365 , __( 'år', 'themepixel' ), __( 'år', 'themepixel' ) ),
		array( 60 * 60 * 24 * 30 , __( 'månad', 'themepixel' ), __( 'månader', 'themepixel' ) ),
		array( 60 * 60 * 24 * 7, __( 'vecka', 'themepixel' ), __( 'veckor', 'themepixel' ) ),
		array( 60 * 60 * 24 , __( 'dag', 'themepixel' ), __( 'dagar', 'themepixel' ) ),
		array( 60 * 60 , __( 'timme', 'themepixel' ), __( 'timmar', 'themepixel' ) ),
		array( 60 , __( 'minut', 'themepixel' ), __( 'minuter', 'themepixel' ) ),
		array( 1, __( 'sekund', 'themepixel' ), __( 'sekunder', 'themepixel' ) )
	);
 
	if ( !is_numeric( $date ) ) {
		$time_chunks = explode( ':', str_replace( ' ', ':', $date ) );
		$date_chunks = explode( '-', str_replace( ' ', '-', $date ) );
		$date = gmmktime( (int)$time_chunks[1], (int)$time_chunks[2], (int)$time_chunks[3], (int)$date_chunks[1], (int)$date_chunks[2], (int)$date_chunks[0] );
	}
 
	$current_time = current_time( 'mysql', $gmt = 0 );
	$newer_date = strtotime( $current_time );
 
	// Difference in seconds
	$since = $newer_date - $date;
 
	// Something went wrong with date calculation and we ended up with a negative date.
	if ( 0 > $since )
		return __( 'någon gång', 'themepixel' );
 
	/**
	 * We only want to output one chunks of time here, eg:
	 * x years
	 * xx months
	 * so there's only one bit of calculation below:
	 */
 
	//Step one: the first chunk
	for ( $i = 0, $j = count($chunks); $i < $j; $i++) {
		$seconds = $chunks[$i][0];
 
		// Finding the biggest chunk (if the chunk fits, break)
		if ( ( $count = floor($since / $seconds) ) != 0 )
			break;
	}
 
	// Set output var
	$output = ( 1 == $count ) ? '1 '. $chunks[$i][1] : $count . ' ' . $chunks[$i][2];
 
 
	if ( !(int)trim($output) ){
		$output = '0 ' . __( 'sekunder', 'themepixel' );
	}
 
	$output .= __(' sedan', 'themepixel');
 
	return $output;
}

function slabtext_the_title($title){

	global $clean;
	
	if ( strlen($title) == 0 ){return;}

	if(strpos($title, ' / ') == true && is_single() && $clean == false){

		$title = '<span class="slabtext">'.$title.'</span>';

		$title = str_replace(' / ', '</span><span class="slabtext"> ', $title);
		$title = str_replace('  ', ' ', $title);

	}else if(strpos($title, ' / ') == true){$title = str_replace(' / ', ' ', $title);}
	
	$title = $before . $title . $after;
	
	if($echo)
	echo $title;
	else
	return $title;

}

function search_url_rewrite_rule() {

	if ( is_search() && !empty($_GET['s'])) {

		wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
		exit();

	}

}

function disqus_embed($disqus_shortname) {

	global $post;

	$clean = true;
	$title = the_title('','',false);

	wp_enqueue_script('disqus_embed','http://'.$disqus_shortname.'.disqus.com/embed.js');

	echo '<div id="disqus_thread" class="entry-content"></div>
	<script type="text/javascript">
		var disqus_shortname = "'.$disqus_shortname.'";
		var disqus_title = "'.$title.'";
		var disqus_url = "'.get_permalink($post->ID).'";
		var disqus_identifier = "'.$disqus_shortname.'-'.$post->ID.'";
	</script>';

}

function disqus_count($disqus_shortname) {

	wp_enqueue_script('disqus_count','http://'.$disqus_shortname.'.disqus.com/count.js');
	echo '<a href="'. get_permalink() .'#disqus_thread"></a>';

}

function getLowestCategory(){

	$postCategories = get_the_category();
	for ($I = 0;$I<sizeof($postCategories);$I++)
	{
		//this is a top level category
		if ($postCategories[$I])
		{
			continue;
		}
		for ($J=0;J<sizeof($postCategories);$J++)
		{
			//if another category lists it as its parent, it cannot be the lowest category 
			if (strcmp($postCategories[$I]->name,$postCategories[$J]->category_parent)==0)
			break;
		}
		//at this point, no other cateogry says it's its parent, therefore it must be the lowest one
		die($postCategories[$I]->slug) ;
	}
}

function combined_categories($query) {
	$catnames = $query->get('category_name');
	if ($catnames == 'recensioner') {
		$query->set('category_name', $catnames . ',film-tv-recension,spel-recension,teknik-prylar-recension');
	}
	else if ($catnames == 'nyheter') {
		$query->set('category_name', $catnames . ',film-tv-nyhet,spel-nyhet,teknik-prylar-nyhet');
	}
}

add_action('pre_get_posts', 'combined_categories');
add_action('template_redirect', 'search_url_rewrite_rule');
add_filter('the_time', 'themepixel_time_ago');
add_filter('the_title', 'slabtext_the_title');
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 600, 400, true );
add_image_size( 'header-image', 1000, 400, 'true' );


?>