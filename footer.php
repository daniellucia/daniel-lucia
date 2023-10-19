	
</div>

<?php if (!is_checkout() && !is_cart()): ?>
	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'daniel-lucia' ), 'daniel-lucia', '<a href="http://www.daniellucia.es">Daniel Lucia</a>' ); ?>
		</div>
	</footer>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
