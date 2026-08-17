<?php
/**
 * Shown when a listing has no results.
 *
 * @package Garland
 */

?>
<div class="node no-results">
	<div class="content clearfix">
		<?php if ( is_search() ) : ?>
			<p><?php esc_html_e( 'Your search yielded no results.', 'garland' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'There is currently no content to display.', 'garland' ); ?></p>
		<?php endif; ?>
	</div>
</div>
