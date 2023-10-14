<?php get_header(); ?>

<div class="container-columns">

	<main id="primary" class="site-main">

		<?php woocommerce_content(); ?>
        <?php do_action('woocommerce_custom_after_content'); ?>

    </main>

    <?php get_sidebar(); ?>

</div>

<?php get_footer();
