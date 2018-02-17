<?php
/**
 * Post published trigger
 *
 * @package notification
 */

namespace underDEV\Notification\Defaults\Trigger\Post;

use underDEV\Notification\Defaults\MergeTag;

/**
 * Post published trigger class
 */
class PostPublished extends PostTrigger {

	/**
	 * Constructor
	 *
	 * @param string $post_type optional, default: post.
	 */
	public function __construct( $post_type = 'post' ) {

		parent::__construct( array(
			'post_type' => $post_type,
			'slug'      => 'wordpress/' . $post_type . '/published',
			// translators: singular post name.
			'name'      => sprintf( __( '%s published' ), parent::get_post_type_name( $post_type ) ),
		) );

		$this->add_action( 'transition_post_status', 10, 3 );

		// translators: 1. singular post name, 2. post type slug.
		$this->set_description( sprintf( __( 'Fires when %s (%s) is published' ), parent::get_post_type_name( $post_type ), $post_type ) );

	}

	/**
	 * Assigns action callback args to object
	 * Return `false` if you want to abort the trigger execution
	 *
	 * @return mixed void or false if no notifications should be sent
	 */
	public function action() {

		$new_status = $this->callback_args[0];
		$old_status = $this->callback_args[1];
		// WP_Post object.
		$this->post = $this->callback_args[2];

		if ( $this->post->post_type != $this->post_type ) {
			return false;
		}

		if ( $new_status == $old_status ) {
			return false;
		}

		if ( $new_status != 'publish' ) {
			return false;
		}

		$this->author          = get_userdata( $this->post->post_author );
		$this->publishing_user = get_userdata( get_current_user_id() );

		$this->{ $this->post_type . '_creation_datetime' }     = strtotime( $this->post->post_date );
		$this->{ $this->post_type . '_modification_datetime' } = strtotime( $this->post->post_modified );

	}

	/**
	 * Registers attached merge tags
	 *
	 * @return void
	 */
	public function merge_tags() {

		$post_name = parent::get_post_type_name( $this->post_type );

		parent::merge_tags();

		// Publishing user.
		$this->add_merge_tag( new MergeTag\User\UserID( array(
			'slug'          => $this->post_type . '_publishing_user_ID',
			// translators: singular post name.
			'name'          => sprintf( __( '%s publishing user ID' ), $post_name ),
			'property_name' => 'publishing_user',
		) ) );

    	$this->add_merge_tag( new MergeTag\User\UserLogin( array(
			'slug'          => $this->post_type . '_publishing_user_login',
			// translators: singular post name.
			'name'          => sprintf( __( '%s publishing user login'  ), $post_name ),
			'property_name' => 'publishing_user',
		) ) );

        $this->add_merge_tag( new MergeTag\User\UserEmail( array(
			'slug'          => $this->post_type . '_publishing_user_email',
			// translators: singular post name.
			'name'          => sprintf( __( '%s publishing user email' ), $post_name ),
			'property_name' => 'publishing_user',
		) ) );

		$this->add_merge_tag( new MergeTag\User\UserNicename( array(
			'slug'          => $this->post_type . '_publishing_user_nicename',
			// translators: singular post name.
			'name'          => sprintf( __( '%s publishing user nicename' ), $post_name ),
			'property_name' => 'publishing_user',
		) ) );

        $this->add_merge_tag( new MergeTag\User\UserFirstName( array(
			'slug'          => $this->post_type . '_publishing_user_firstname',
			// translators: singular post name.
			'name'          => sprintf( __( '%s publishing user first name' ), $post_name ),
			'property_name' => 'publishing_user',
		) ) );

		$this->add_merge_tag( new MergeTag\User\UserLastName( array(
			'slug'          => $this->post_type . '_publishing_user_lastname',
			// translators: singular post name.
			'name'          => sprintf( __( '%s publishing user last name' ), $post_name ),
			'property_name' => 'publishing_user',
		) ) );

    }

}