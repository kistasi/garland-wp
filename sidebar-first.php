<?php
/**
 * Garland's "Sidebar first" region.
 *
 * @package Garland
 */

if ( ! is_active_sidebar( 'sidebar-first' ) ) {
	return;
}
?>
<div id="sidebar-first" class="sidebar">
	<div class="region region-sidebar-first">
		<?php dynamic_sidebar( 'sidebar-first' ); ?>
	</div>
</div>
