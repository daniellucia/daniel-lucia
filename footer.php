	
</div>

<?php if (!is_checkout() && !is_cart()): ?>
	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<div class="footer-widgets">
				<?php for($i = 1; $i <= (int)NUMBER_SIDEBAR_WIDGETS; $i++): ?>
					<div class="footer-widget">
						<?php dynamic_sidebar('footer-' . $i); ?>
					</div>
				<?php endfor; ?>
			</div>

			<p class="final-words"><?php echo __( '❤️ Hecho con muchas ganas por Daniel Lúcia.', 'daniel-lucia' ); ?></p>

		</div>
	</footer>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
