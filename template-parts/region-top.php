<?php
/**
 * The "Highlighted" and "Help" regions, printed above the main content.
 *
 * Port of the corresponding section of page.html.twig.
 *
 * @package Garland
 */

?>
<?php if ( is_active_sidebar( 'highlighted' ) ) : ?>
	<div id="highlighted">
		<div class="region region-highlighted">
			<?php dynamic_sidebar( 'highlighted' ); ?>
		</div>
	</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'help' ) ) : ?>
	<div class="region region-help">
		<?php dynamic_sidebar( 'help' ); ?>
	</div>
<?php endif; ?>
