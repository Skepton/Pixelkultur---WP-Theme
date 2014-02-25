		<footer class="footer_pixel">

			<div class="wrapper_pixel">

				<p><a class="subscribe_pixel icon-rss" target="_blank" href="<?php bloginfo('rss_url'); ?>">

				</a></p>

				<div class="footertext_pixel">

					<p>All content copyright <a href="<?php bloginfo('url'); ?>"><?php bloginfo('title'); ?></a> &copy; 2013 &bull; All rights reserved.</p>

				</div>

				<div class="footertext_pixel">

					<p>Proudly published with <a href="http://wordpress.org/" target="_blank">Wordpress</a></p>
					<p>Theme: Created by <a href="http://www.antonlantz.nu"> Anton Lantz</a></p>

				</div>

			</div>

		</footer>

		<?php if ( !is_single() ) : ?>
		
		<script type="text/javascript">

			$(document).ready(function(){

				$(window).trigger('resize');

				window.offset  = $('.category_bar').offset().top;

			});

			$(document).scroll(function(){

				if($(window).width() > 690){

					if($(window).scrollTop() >= offset){

						$('.category_bar').css('margin-top', $(window).scrollTop()-offset);

					}else{

						$('.category_bar').css('margin-top', '0px');
					}

				}else{$('.category_bar').css('margin-top', '0px');}

			});

			$(document).on('click', '.older-posts a', function(e){

				e.preventDefault();

				var url = $(this).attr('href');

				$.get(url, function(data){

					$('.pagination_pixel').remove();

					$(data).find(".article_pixel , .pagination_pixel").addClass('hide').appendTo(".main_pixel.headline");

					setTimeout(function() {

						$('.article_pixel , .pagination_pixel').removeClass('hide');$(window).trigger('resize');

					}, 1); 
					
					if($('.older-posts').length>0 && $('.older-posts a').length == 0){

						$('.older-posts').remove();

					}

				});

			});

			$(window).resize(function(){

				$('.image_container img').one('load',function(){

					$(this).attr('height','auto').attr('width','auto');

					var header_height = $(this).height();
					var header_width = $(this).width();
					var parent_height = $(this).parent().parent().outerHeight();
					var parent_width = $(this).parent().parent().width();

					var height_complete = '-'+(header_height-parent_height)/2+'px';
					var width_complete = '-'+(header_width-parent_width)/2+'px';

					if((header_width-parent_width)/2 <= 0){width_complete = '0px';}
					if((header_height-parent_height)/2 <= 0){height_complete = '0px';}

					$(this).css('margin-top',height_complete);
					$(this).css('margin-left',width_complete);

				}).each(function() {

					if(this.complete) $(this).load();

				});

				$('.header_item img').one('load',function(){

					$(this).attr('height','auto').attr('width','auto');

					var header_height = $(this).height();
					var parent_height = $(this).parent().parent().outerHeight();

					var height_complete = '-'+(header_height-parent_height)/2+'px';

					if((header_height-parent_height)/2 <= 0){height_complete = '0px';}

					$(this).css('margin-top',height_complete);
					
				}).each(function() {

					if(this.complete) $(this).load();

				});

			});

		</script>

	<?php elseif (is_single()) : ?>

	<script src="<?php bloginfo('stylesheet_directory'); ?>/js/slabtext.js"></script>

	<script type="text/javascript">

		function slabTextHeadlines() {

			$(".posttitle_pixel").slabText({
				"viewportBreakpoint":380
			});
	
		};

		$(document).ready(function(){

			$(window).trigger('resize');
			
  
		});

		$(window).resize(function(){

			setTimeout(slabTextHeadlines, 100);

			$('.image_container img').on('load',function(){

				$(this).attr('height','auto').attr('width','100%');

				var header_height = $(this).height();
				var header_width = $(this).width();
				var parent_height = $(this).parent().outerHeight();
				var parent_width = $(this).parent().parent().width();

				var height_complete = '-'+(header_height-parent_height)/2+'px';
				var width_complete = '-'+(header_width-parent_width)/2+'px';

				if((header_width-parent_width)/2 <= 0){width_complete = '0px';}
				if((header_height-parent_height)/2 <= 0){height_complete = '0px';}

				$(this).css('margin-top',height_complete);
				$(this).css('margin-left',width_complete);

			}).each(function() {

				if(this.complete) $(this).load();

			});

			$('.postfooter_pixel address').css('height',$('.authorbio_pixel').outerHeight());
			$('.sharepost_pixel').css('height',$('.authorbio_pixel').outerHeight());

		});

	</script>

<?php endif; ?>

	<script type="text/javascript">

			$(document).ready(function(){

				$(window).trigger('resize');

			});

			$(window).resize(function(){

				if($('body').height()<$(window).height()-$('.footer_pixel').height()){

					$('.footer_pixel').css('position','absolute');

				}else{$('.footer_pixel').css('position','relative');}

			});

		$('#search_icon').click(function(e){

			e.preventDefault();

			$('input.menu-item').toggleClass('active_search');

		});

	</script>

	</body>

</html>