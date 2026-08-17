<?php
/**
 * The "Highlighted" and "Help" regions, printed above the main content.
 *
 * Port of the corresponding section of page.html.twig, which orders them
 * highlighted, then the #main-content anchor, then help. Every template that
 * opens the content area includes this part directly after its page-title
 * block, so the anchor lives here rather than being repeated in each one.
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

<a id="main-content"></a>

<?php if ( is_active_sidebar( 'help' ) ) : ?>
	<div class="region region-help">
		<?php dynamic_sidebar( 'help' ); ?>
	</div>
<?php endif; ?>
