<?php
/**
 * The comment area.
 *
 * Port of Drupal's comment wrapper markup (#comments with an h2.comments
 * heading); individual comments are rendered by garland_comment().
 *
 * @package Garland
 */

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="comments">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments title">
			<?php
			$garland_count = get_comments_number();
			printf(
				/* translators: %s: comment count. */
				esc_html( _n( '%s comment', '%s comments', $garland_count, 'garland' ) ),
				esc_html( number_format_i18n( $garland_count ) )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			// garland_comment() prints the <li>; the list itself is ours to open.
			wp_list_comments(
				array(
					'style'       => 'ol',
					'callback'    => 'garland_comment',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_pagination(
			array(
				'prev_text' => __( '‹ previous', 'garland' ),
				'next_text' => __( 'next ›', 'garland' ),
			)
		);
		?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'garland' ); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'          => __( 'Add new comment', 'garland' ),
			'class_form'           => 'comment-form',
			'comment_notes_before' => '',
			'label_submit'         => __( 'Save', 'garland' ),
			'class_submit'         => 'form-submit button',
		)
	);
	?>

</section>
