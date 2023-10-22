<?php


if (!is_show_sidebar('sidebar-1')) {
	return;
}


?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar('sidebar-1'); ?>
</aside><!-- #secondary -->