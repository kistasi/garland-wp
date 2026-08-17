<?php
/**
 * The search form, in Drupal's search-block-form markup.
 *
 * @package Garland
 */

$garland_search_id = 'search-' . wp_unique_id();
?>
<form role="search" method="get" class="search-form search-block-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="form-item form-type-search">
		<label for="<?php echo esc_attr( $garland_search_id ); ?>"><?php esc_html_e( 'Search', 'garland' ); ?></label>
		<input type="search" id="<?php echo esc_attr( $garland_search_id ); ?>" class="form-search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" />
	</div>
	<div class="form-actions">
		<input type="submit" class="form-submit button" value="<?php esc_attr_e( 'Search', 'garland' ); ?>" />
	</div>
</form>
