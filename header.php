<!DOCTYPE html>
<html>

	<head>

		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title><?php bloginfo('name'); ?> <?php wp_title(" / ",true); ?></title>
		<meta name="description" content="<?php bloginfo('description'); ?>" />

		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/normalize.css" />

		<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery-2.0.3.js"></script>

		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700,800|Exo+2:400,100,200,300,500,600,700,800' rel='stylesheet' type='text/css'>

		<meta name="HandheldFriendly" content="True" />
		<meta name="MobileOptimized" content="320" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	</head>

<body>

	<div role='menu' class="header_pixel">

		<div class="wrapper_pixel">

			<div class="title_pixel">

				<a href="<?php bloginfo('url'); ?>"><h1 class="blogtitle_pixel">

						<?php bloginfo('title'); ?>

				</h1></a>

			</div>

			<div class="menu-div">

				<ul class="inline-list menu-list">

					<li><a href="<?php bloginfo('url'); ?>/wp-admin/" class="menu-item" title="Publicera"><i class="icon-pencil"></i></a></li>
					<li><a href="<?php bloginfo('url'); ?>/category/spel/" class="menu-item" title="Spel"><i class="icon-gamepad"></i></a></li>
					<li><a href="<?php bloginfo('url'); ?>/category/film-&-tv/" class="menu-item" title="Film & Tv"><i class="icon-video"></i></a></li>
					<li><a href="<?php bloginfo('url'); ?>/category/teknik-&-prylar/" class="menu-item" title="Teknik & Prylar"><i class="icon-laptop"></i></a></li>
					<li><a id="search_icon" href="" class="menu-item" title="Teknik & Prylar"><i class="icon-search"></i></a></li>
					
					<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">

							<li><input class="menu-item" type="text" value="<?php the_search_query(); ?>" name="s" placeholder="Sök här!" />

					</form>

				</ul>

			</div>

		</div>

	</div>