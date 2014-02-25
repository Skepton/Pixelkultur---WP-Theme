<?php get_header(); ?> 

<main class="main_pixel post" role="main">

	<?php if ( ! have_posts() ) : ?>
			<h1>Not Found</h1>
				<p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post</p>
	<?php endif; 

	 while ( have_posts() ) : the_post(); 

	 	if ( has_post_thumbnail() ) : ?>

			<div class="image_container">

				<?php the_post_thumbnail('header-image'); ?>

				<div id="trampezium"></div>

			</div>

		<?php endif; ?>

		<article class="article_pixel" role="article" itemscope itemtype="http://schema.org/Article">

			<header class="postheader_pixel">

				<h1 class="posttitle_pixel" itemprop="headline">

					<?php the_title(); ?>

				</h1>

				<div class="article_info">

					<p class="author"> Skriven Av: <span><?php the_author(); ?></span> </p>

					<time class="date_pixel" datetime="<?php the_date('Y-m-d H:m'); ?>" itemprop="datePublished">
						
						<span class="icon-clock"></span>

							<?php the_time('F j, Y'); ?>

					</time>

				</div>

			</header>

			<div class="postcontent_pixel" itemprop="articleBody">

				<?php the_content(); ?>

				<?php

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
				<?php if(!empty($review) && $review >= 0) : ?>

				<div class="review_box"><p> Betyg: </p><div class="container"><?php echo $review_box; unset($review); unset($review_box);  ?> </div></div>

				<?php endif; ?>


			</div>

			<footer class="postfooter_pixel">

				<address itemscope itemtype="http://schema.org/Person">

					<p class="footer_header">Author:</p>

					<h4 class="authorname_pixel">
						<span itemprop="author">

						<?php the_author(); ?>

						</span>
					</h4>

					<div class="authorbio_pixel">

						<p class="footer_header">Bio:</p>

						<p><?php the_author_description(); ?> </p>

					</div>

				</address>

				<?php comments_template(); ?>

				<div class="sharepost_pixel">

					<?php

						$clean = true;
						$title = the_title('','',false);

					?>

					<p class="footer_header">Share:</p>

					<a class="share_pixel icon-twitter" target="_blank" href="http://twitter.com/share?text=<?php echo $title; ?>&url=<?php the_permalink(); ?>"></a>
					<a class="share_pixel icon-facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>"></a>
					<a class="share_pixel icon-gplus" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"></a>

				</div>

			</footer>

		</article>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?> 