<?php


if (!is_active_sidebar('sidebar-1')) {
	return;
}
if (is_checkout() || is_cart()) {
	return;
}


?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar('sidebar-1'); ?>
</aside><!-- #secondary -->