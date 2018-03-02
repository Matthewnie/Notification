<?php
/**
 * Extension promo box template
 *
 * @package notification
 */

if ( notification_is_whitelabeled() ) {
	return;
}

?>

<div class="plugin-card promo">
	<div class="plugin-card-top">
		<div class="name column-name">
			<h3><?php _e( 'Your extension', 'notification' ); ?></h3>
		</div>
		<div class="action-links">
			<ul class="plugin-action-buttons">
				<li><a href="https://bracketspace.com/contact/" target="_blank" class="button"><?php _e( 'Send extension', 'notification' ); ?></a></li>
			</ul>
		</div>
		<div class="desc column-description">
			<p><?php _e( 'If you wrote a Notification extension or you have a plugin which complete Notification, let us know!', 'notification' ); ?></p>
			<?php // translators: 1. Link to documentation. ?>
			<p><?php printf( __( 'See the %s for more information how to release an extension.', 'notification' ), '<a href="https://docs.bracketspace.com/docs/how-to-create-public-extension/" target="_blank">' . __( 'documentation' ) . '</a>' ); ?></p>
		</div>
	</div>
</div>
