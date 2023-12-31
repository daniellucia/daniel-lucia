<?php get_header(); ?>

	<div class="container-columns">

		<main id="primary" class="site-main">

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );

				the_post_navigation(
					array(
						'prev_text' => '<span class="nav-title button button-link">%title</span>',
						'next_text' => '<span class="nav-title button button-link">%title</span>',
					)
				);

				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; 
			?>


		</main>

		<?php get_sidebar(); ?>
	</div>
<?php

get_footer();
