<?php get_header(); ?>

<main id="primary" class="site-main">

	<div class="home-widgets">
		<?php dynamic_sidebar('home'); ?>
	</div>

	<div class="home-widgets">
		<?php dynamic_sidebar('after-home'); ?>
	</div>

	<?php
	while (have_posts()) :
		the_post();

		get_template_part('template-parts/content', 'home');

	endwhile;
	?>
	<div class="container-columns">
		<div class="home-latest-post">

			<h5 class="widget-title"><?php echo __('Últimos Posts', 'daniel-lucia'); ?></h5>

			<?php

			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 5,
				'orderby' => 'date',
				'order' => 'DESC'
			);

			$latest_posts = new WP_Query($args);

			if ($latest_posts->have_posts()) :
				while ($latest_posts->have_posts()) : $latest_posts->the_post();

					get_template_part('template-parts/content', get_post_type());

				endwhile;
				wp_reset_postdata();
			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;

			?>
		</div>

		<?php get_sidebar(); ?>
	</div>

</main>

<?php

get_footer();
