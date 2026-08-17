<?php
/**
 * Garland template tags.
 *
 * These stand in for the Drupal blocks and preprocess functions the original
 * theme relied on: site branding, breadcrumbs, the "submitted" byline, the
 * comment markup and pager.
 *
 * @package Garland
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Site branding.
 *
 * Port of templates/block--system-branding-block.html.twig. Falls back to the
 * theme's own logo.svg when no custom logo has been set, which is what a fresh
 * Drupal install of Garland showed.
 */
function garland_branding() {
	?>
	<div id="logo-floater">
		<div id="branding"><strong><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php if ( has_custom_logo() ) : ?>
				<?php
				$logo_id = get_theme_mod( 'custom_logo' );
				$logo    = wp_get_attachment_image_src( $logo_id, 'full' );
				?>
				<img src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" />
			<?php else : ?>
				<img src="<?php echo esc_url( get_theme_file_uri( 'logo.svg' ) ); ?>" width="89" height="89" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" />
			<?php endif; ?>
			<span><?php bloginfo( 'name' ); ?></span>
			<?php if ( get_bloginfo( 'description', 'display' ) ) : ?>
				<span id="site-slogan"><?php bloginfo( 'description' ); ?></span>
			<?php endif; ?>
		</a></strong></div>
	</div>
	<?php
}

/**
 * Print the breadcrumb trail.
 */
function garland_breadcrumb() {
	// Built from escaped values in garland_get_breadcrumb().
	echo garland_get_breadcrumb(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Build the breadcrumb trail.
 *
 * Replaces Drupal's breadcrumb block with an equivalent for WordPress's
 * hierarchy: home, then the ancestors of the current page/term/post. Returns
 * an empty string when there is nothing to show, which is what header.php
 * checks before drawing the breadcrumb bar at all.
 *
 * @return string Markup, or '' when there is no trail.
 */
function garland_get_breadcrumb() {
	if ( is_front_page() ) {
		return '';
	}

	$crumbs = array(
		'<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'garland' ) . '</a>',
	);

	if ( is_singular() ) {
		$post = get_queried_object();

		if ( is_post_type_hierarchical( $post->post_type ) ) {
			foreach ( array_reverse( get_post_ancestors( $post ) ) as $ancestor ) {
				$crumbs[] = '<a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a>';
			}
		} elseif ( 'post' === $post->post_type ) {
			$categories = get_the_category( $post->ID );
			if ( ! empty( $categories ) ) {
				$crumbs[] = '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
			}
		}

		$crumbs[] = esc_html( get_the_title( $post ) );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();

		if ( ! empty( $term->parent ) ) {
			foreach ( array_reverse( get_ancestors( $term->term_id, $term->taxonomy ) ) as $ancestor_id ) {
				$ancestor = get_term( $ancestor_id, $term->taxonomy );
				$crumbs[] = '<a href="' . esc_url( get_term_link( $ancestor ) ) . '">' . esc_html( $ancestor->name ) . '</a>';
			}
		}

		$crumbs[] = esc_html( single_term_title( '', false ) );
	} elseif ( is_search() ) {
		/* translators: %s: search query. */
		$crumbs[] = esc_html( sprintf( __( 'Search for "%s"', 'garland' ), get_search_query() ) );
	} elseif ( is_author() ) {
		$crumbs[] = esc_html( get_the_author() );
	} elseif ( is_archive() ) {
		$crumbs[] = esc_html( wp_strip_all_tags( get_the_archive_title() ) );
	} elseif ( is_404() ) {
		$crumbs[] = esc_html__( 'Page not found', 'garland' );
	} elseif ( is_home() ) {
		$crumbs[] = esc_html( get_the_title( get_option( 'page_for_posts' ) ) );
	}

	// The last crumb is the current page and is not a link in Garland.
	array_pop( $crumbs );

	if ( empty( $crumbs ) ) {
		return '';
	}

	$markup  = '<nav class="breadcrumb" role="navigation" aria-labelledby="system-breadcrumb">';
	$markup .= '<h2 id="system-breadcrumb" class="visually-hidden">' . esc_html__( 'Breadcrumb', 'garland' ) . '</h2>';
	$markup .= '<ol>';
	foreach ( $crumbs as $crumb ) {
		// Crumb strings are escaped as they are built above.
		$markup .= '<li>' . $crumb . '</li>';
	}
	$markup .= '</ol></nav>';

	return $markup;
}

/**
 * The "submitted" byline: Garland printed "date — author".
 */
function garland_submitted() {
	if ( 'post' !== get_post_type() ) {
		return;
	}
	?>
	<span class="submitted">
		<?php echo esc_html( get_the_date() ); ?> &mdash;
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="username"><?php echo esc_html( get_the_author() ); ?></a>
	</span>
	<?php
}

/**
 * Post links: categories, tags and the read-more link, as Garland's node links.
 */
function garland_entry_links() {
	$links = array();

	if ( ! is_singular() ) {
		$links[] = '<li class="node-readmore"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . esc_html__( 'Read more', 'garland' ) . '</a></li>';
	}

	$categories = get_the_category_list( ', ' );
	if ( $categories && 'post' === get_post_type() ) {
		$links[] = '<li class="node-categories">' . esc_html__( 'Posted in', 'garland' ) . ' ' . $categories . '</li>';
	}

	$tags = get_the_tag_list( '', ', ' );
	if ( $tags && ! is_wp_error( $tags ) ) {
		$links[] = '<li class="node-tags">' . esc_html__( 'Tagged', 'garland' ) . ' ' . $tags . '</li>';
	}

	if ( comments_open() || get_comments_number() ) {
		ob_start();
		comments_popup_link(
			__( 'Add new comment', 'garland' ),
			__( '1 comment', 'garland' ),
			__( '% comments', 'garland' )
		);
		$links[] = '<li class="comment-comments">' . ob_get_clean() . '</li>';
	}

	if ( empty( $links ) ) {
		return;
	}

	echo '<div class="links"><ul class="links inline">';
	// Each item is built from escaped values or core link helpers.
	echo implode( '', $links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '</ul></div>';
}

/**
 * Render a single comment in Garland's markup.
 *
 * Port of templates/comment.html.twig. The zebra class is added by
 * garland_comment_classes() on the comment_class filter.
 *
 * @param WP_Comment $comment Comment.
 * @param array      $args    wp_list_comments() args.
 * @param int        $depth   Nesting depth.
 */
function garland_comment( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
	?>
	<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment' ); ?>>
		<div class="comment-body">

			<?php // Avatar and byline share a flex row; see .comment-meta in css/garland.css. ?>
			<div class="comment-meta">
				<?php echo get_avatar( $comment, 48 ); ?>

				<span class="submitted">
					<?php
					printf(
						/* translators: 1: comment date, 2: comment author. */
						esc_html__( '%1$s &mdash; %2$s', 'garland' ),
						esc_html( get_comment_date() ),
						wp_kses_post( get_comment_author_link() )
					);
					?>
				</span>
			</div>

			<div class="content">
				<?php if ( '0' === $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'garland' ); ?></p>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
		</div>

		<div class="links">
			<ul class="links inline">
				<?php
				$reply = get_comment_reply_link(
					array_merge(
						$args,
						array(
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
							'before'     => '<li class="comment-reply">',
							'after'      => '</li>',
							'reply_text' => __( 'Reply', 'garland' ),
						)
					)
				);
				echo $reply; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				edit_comment_link( __( 'Edit', 'garland' ), '<li class="comment-edit">', '</li>' );
				?>
				<li class="comment-permalink">
					<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>"><?php esc_html_e( 'Permalink', 'garland' ); ?></a>
				</li>
			</ul>
		</div>
	<?php
	// The closing tag is emitted by Walker_Comment::end_el(), for both the
	// 'div' and the 'ol'/'ul' comment styles.
}

/**
 * Pager in Drupal's markup.
 */
function garland_pager() {
	$links = paginate_links(
		array(
			'type'      => 'array',
			'prev_text' => __( '‹ previous', 'garland' ),
			'next_text' => __( 'next ›', 'garland' ),
		)
	);

	if ( empty( $links ) ) {
		return;
	}

	echo '<nav class="pager" role="navigation" aria-labelledby="pagination-heading">';
	echo '<h4 id="pagination-heading" class="visually-hidden">' . esc_html__( 'Pagination', 'garland' ) . '</h4>';
	echo '<ul class="pager__items js-pager__items">';
	foreach ( $links as $link ) {
		echo '<li class="pager__item">' . wp_kses_post( $link ) . '</li>';
	}
	echo '</ul></nav>';
}
