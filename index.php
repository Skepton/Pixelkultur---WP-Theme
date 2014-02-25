<?php get_header(); ?> 

<div class="wrapper_pixel">

<header class="featured_pixel" role="featured">

	<?php

		$category_string = get_query_var('category_name');

		$cat_header = 'category__and';


		if(strrpos($category_string, 'recensioner') !== false || strrpos($category_string, 'nyheter') !== false){

			$categories = explode(',', $category_string);

			$category_IDs = array();

			foreach (array_slice($categories,1) as $category) {

				array_push($category_IDs, get_category_by_slug( $category )->cat_ID);
				
			}

			$category = implode(', ', $category_IDs);

			$cat_header = 'category';

		}else if(is_category()){

			$cat = get_category_by_path(get_query_var('category_name'),false);

			$category = array(get_cat_ID( 'featured' ),$cat->cat_ID);

		}else{
			
			$category = array(get_cat_ID( 'featured' ));

		}

		$args = array(

			'posts_per_page'	=> 4,
			'offset'			=> 0,
			$cat_header 		=> 	$category,
			'orderby'			=> 'post_date',
			'order'				=> 'DESC',
			'include'			=> '',
			'exclude'			=> '',
			'meta_key'			=> '',
			'meta_value'		=> '',
			'post_type'			=> 'post',
			'post_mime_type'	=> '',
			'post_parent'		=> '',
			'post_status'		=> 'publish',
			'suppress_filters'	=> true 

		);

		$posts_array = get_posts( $args );
		$index = 1;

		$size = sizeof($posts_array);

		foreach ( $posts_array as $post ) : setup_postdata( $post );
		
			if ( has_post_thumbnail() )  :

				?>

				<article class="header_item <?php if($size == 1 && $index == 1 || $size == 3 && $index == 3 ){echo 'item'.'5';}else{echo 'item'.$index;} ?>">

					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('header-image'); ?></a>

					<h2 itemprop="headline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

				</article>

				<?php 

			endif;
			$index++;
		endforeach; 
		wp_reset_postdata();

	?>

</header>

</div>

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

				echo '<a href="'.get_category_link($category->cat_ID).'" class="'.strtolower($category->slug).'"><li>'.$category->cat_name.'</li></a>';

				$childcategories = get_categories('child_of=' . $category->cat_ID . '&hide_empty=1');

				if(!empty($childcategories)){

					echo '<ul class="child_categories">';

					foreach ($childcategories as $childcategory) {

						echo '<a href="'.get_category_link($childcategory->cat_ID).'"><li>'.$childcategory->cat_name.'</li></a>';

					}

					echo '</ul>';

				}

			}

			

		?>

		<div class="all_categories">
			<a href="<?php bloginfo('url'); ?>/category/recensioner/" class="recensioner"><li>Alla Recensioner</li></a>
			<a href="<?php bloginfo('url'); ?>/category/nyheter/" class="nyheter"><li>Alla Nyheter</li></a>
		</div>

		<?php echo '</ul>'; ?>

	</aside>

	<main class="main_pixel headline" role="main">

		<h1>Senaste Nytt 

			<?php

			$category_string = get_query_var('category_name');

			if(is_category()){

				if( strpos($category_string, 'nyheter') !== false){echo ' - Nyheter';}
				else if( strpos($category_string, 'recensioner') !== false){echo ' - '.'Recensioner';}
				else{$category = get_category( get_query_var( 'cat' ) ); echo ' - '.$category->cat_name;}

			} 
			
		?></h1>

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

					<div class="triangle"></div>

					<?php if($icon_string){ echo $icon_string;} ?>

					<header class="postheader_pixel">

						<div class="post_info">

							<time class="date_pixel" datetime="<?php the_date('Y-m-d H:m'); ?>" itemprop="datePublished">

								<span class="icon-clock"></span>

									<?php the_time('F j, Y'); ?>

							</time>

							<?php

								$deep_id = wp_get_post_categories($post->ID);

								if(in_category('Nyheter')){echo '<a href="'.get_category_link(max($deep_id)).'" class="cat_type">Nyhet</a>';}else if(in_category('Recensioner')){echo  '<a href="'.get_category_link(max($deep_id)).'" class="cat_type">Recension</a>';} 

							?>

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
					
					<div class="page-number"><p>Inga äldre artiklar finns.</p></div>  

				</nav>

			<?php endif; ?>

		</div>

	</main>

</div>
	
<?php get_footer(); ?> 