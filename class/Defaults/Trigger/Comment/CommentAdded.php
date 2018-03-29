<?php
/**
 * Comment added trigger
 *
 * @package notification
 */

namespace BracketSpace\Notification\Defaults\Trigger\Comment;

use BracketSpace\Notification\Defaults\MergeTag;

/**
 * Comment added trigger class
 */
class CommentAdded extends CommentTrigger {

	/**
	 * Constructor
	 *
	 * @param string $comment_type optional, default: comment.
	 */
	public function __construct( $comment_type = 'comment' ) {

		parent::__construct( array(
			'slug'         => 'wordpress/comment_' . $comment_type . '_added',
			'name'         => ucfirst( $comment_type ) . ' added',
			'comment_type' => $comment_type,
		) );

		$this->add_action( 'wp_insert_comment', 10, 2 );

		// translators: comment type.
		$this->set_description( sprintf( __( 'Fires when new %s is added', 'notification' ), __( ucfirst( $comment_type ), 'notification' ) ) );

	}

	/**
	 * Assigns action callback args to object
	 * Return `false` if you want to abort the trigger execution
	 *
	 * @return mixed void or false if no notifications should be sent
	 */
	public function action() {

		$this->comment_ID = $this->callback_args[0];
		$this->comment    = $this->callback_args[1];

		$this->user_object                = new \StdClass();
		$this->user_object->ID            = ( $this->comment->user_id ) ? $this->comment->user_id : 0;
		$this->user_object->display_name  = $this->comment->comment_author;
		$this->user_object->user_email    = $this->comment->comment_author_email;

		if ( $this->comment->comment_approved == 'spam' && notification_get_setting( 'triggers/comment/akismet' ) ) {
			return false;
		}

	}

	/**
	 * Registers attached merge tags
	 *
	 * @return void
	 */
	public function merge_tags() {

		parent::merge_tags();

		$this->add_merge_tag( new MergeTag\Comment\CommentActionApprove() );
		$this->add_merge_tag( new MergeTag\Comment\CommentActionTrash() );
		$this->add_merge_tag( new MergeTag\Comment\CommentActionDelete() );
		$this->add_merge_tag( new MergeTag\Comment\CommentActionSpam() );

    }

}
