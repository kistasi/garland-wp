<?php
/**
 * Garland's "Sidebar second" region.
 *
 * @package Garland
 */

if ( ! is_active_sidebar( 'sidebar-second' ) ) {
	return;
}
?>
<div id="sidebar-second" class="sidebar">
	<div class="region region-sidebar-second">
		<?php dynamic_sidebar( 'sidebar-second' ); ?>
	</div>
</div>
