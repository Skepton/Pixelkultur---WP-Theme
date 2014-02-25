<?php

/*
Template Name: Search Page
*/

global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();

foreach($query_args as $key => $string) {
	$query_split = explode("=", $string);
	$search_query[$query_split[0]] = urldecode($query_split[1]);
} // foreach

$search = new WP_Query($search_query);

get_header(); ?> 

<div class="wrapper_pixel">

	<aside class="category_bar">

		<?php

			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => 0,
				'orderby'                  => 'cat_name',
				'order'                    => 'ASC',
				'hide_empty'               => 1,
				'hierarchical'             => 0,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false 

			);

			$categories = get_categories($args);

			echo '<ul class="main_categories"><h2>Kategorier:</h2>';

			foreach ($categories as $category) {

				echo '<a href="'.get_category_link($category->cat_ID).'"><li>'.$category->cat_name.'</li></a>';

				$childcategories = get_categories('child_of=' . $category->cat_ID . '&hide_empty=1');

				if(!empty($childcategories)){

					echo '<ul class="child_categories">';

					foreach ($childcategories as $childcategory) {

						echo '<a href="'.get_category_link($childcategory->cat_ID).'"><li>'.$childcategory->cat_name.'</li></a>';

					}

					echo '</ul>';

				}

			}

			echo '</ul>';

		?>

	</aside>

	<main class="main_pixel headline" role="main">

		<h1>Sökresultat för '<?php the_search_query(); ?>'</h1>

		<?php if ( ! have_posts() ) : ?>
				<h1>Not Found</h1>
					<p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post</p>
		<?php endif; ?>
		  
		<?php while ( have_posts() ) : the_post(); 
		$index = 1;

		$review = get_post_meta(get_the_ID(),'Review score')[0];

		if( !empty($review) && $review >= 0){

			$review_box = '';

			for($j=1; $j<=9; $j++){

				if($j <= 9-$review){

					$review_box = $review_box.'<div class="empty"></div>';

				}else{

					$review_box = $review_box.'<div class="full"></div>';

				}

			}

		}

		?>

			<article class="article_pixel <?php echo 'item'.$index; ?>" role="article" itemscope itemtype="http://schema.org/Article">

				<?php 

					if(!in_category('Uncategorized')){

						if(in_category('spel')){

							$icon_string = '<p class="icon-gamepad"></p>';

						}else if(in_category('film-tv')){

							$icon_string = '<p class="icon-video"></p>';

						}else if(in_category('teknik-prylar')){

							$icon_string = '<p class="icon-laptop"></p>';

						}

					}

				?>

				<div class="image_container">

					<div class="container"><?php if($review>=0){echo $review_box; unset($review); unset($review_box);}  ?> </div>

					<a href="<?php the_permalink(); ?>">

						<?php if ( has_post_thumbnail() ) {

							the_post_thumbnail();

						} ?>

					</a>

				</div>

				<div class="post_container <?php if ( has_post_thumbnail() ) { echo 'small';} ?>">

					<?php if($icon_string){ echo $icon_string;} ?>

					<header class="postheader_pixel">

						<div class="post_info">

							<time class="date_pixel" datetime="<?php the_date('Y-m-d H:m'); ?>" itemprop="datePublished">

								<span class="icon-clock"></span>

									<?php the_time('F j, Y'); ?>

							</time>

							<?php if(in_category('Nyheter')){echo '<a href="'.get_category_link($childcategory->cat_ID).'" class="cat_type">Nyhet - </a>';}else if(in_category('Recensioner')){echo  '<a href="'.get_category_link($childcategory->cat_ID).'" class="cat_type">Recension - </a>';} ?>

						</div>

						<h1 class="posttitle_pixel" itemprop="headline">
							<a href="<?php the_permalink(); ?>" rel="bookmark">

								<?php the_title(); ?>

							</a>
						</h1>

					</header>

					<div class="postcontent_pixel" itemprop="articleBody">
						<p>

							<?php 

								$excerpt = substr(get_the_excerpt(), 0,260);

								if(strlen($excerpt) == 260){$excerpt = $excerpt.'...';}

								echo $excerpt;

							?>

						</p>

					</div>

					<div class="text_fade"></div>

				</div>

			</article>

		<?php $index++; endwhile; ?> 

		<div class="pagination_pixel">

			<?php if ( $wp_query->max_num_pages > 1 ) : ?>  

				<nav class="pagination" role="pagination">

					<div class="older-posts"><?php next_posts_link('Older Posts'); ?></div>

				</nav> 

			<?php else: ?> 

				<nav class="pagination" role="pagination">
					
					<div class="page-number"><p>No newer/older posts</p></div>  

				</nav>

			<?php endif; ?>

		</div>

	</main>

</div>
  
<?php get_footer(); ?> 