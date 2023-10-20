<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package daniel-lucia
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php daniel_lucia_post_thumbnail(); ?>

	<header class="entry-header">

		<?php if (!is_single()): ?>
			<?php the_title('<h5 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h5>'); ?>
		<?php else: ?>
			<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
		<?php endif; ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'daniel-lucia'),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post(get_the_title())
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__('Pages:', 'daniel-lucia'),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->


	<?php
	if ('post' === get_post_type()) :
	?>
		<footer class="entry-footer">
			<div class="entry-meta">
				<?php
				daniel_lucia_posted_on();
				daniel_lucia_posted_by();
				?>
			</div><!-- .entry-meta -->
		</footer><!-- .entry-footer -->
	<?php endif; ?>


</article><!-- #post-<?php the_ID(); ?> -->