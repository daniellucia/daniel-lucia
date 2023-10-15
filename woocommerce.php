<?php get_header(); ?>

<div class="container-columns">

	<main id="primary" class="site-main">

		<?php woocommerce_content(); ?>

        <?php if (is_product()): ?>
            <?php do_action('woocommerce_custom_after_content'); ?>
        <?php endif; ?>

    </main>

    <?php get_sidebar(); ?>

</div>

<?php get_footer();
