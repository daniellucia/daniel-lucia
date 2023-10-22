<?php

/* 
Template Name: Estrecha
*/

get_header();
?>

	<div class="container-columns">
		<main id="primary" class="site-main slim">

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'page' );

				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; 
			?>

		</main><!-- #main -->
		
	</div>

<?php get_footer();
