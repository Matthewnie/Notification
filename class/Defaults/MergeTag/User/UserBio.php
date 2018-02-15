<?php
/**
 * User Bio merge tag
 *
 * @package notification
 */

namespace underDEV\Notification\Defaults\MergeTag\User;

use underDEV\Notification\Defaults\MergeTag\StringTag;

/**
 * User Bio merge tag class
 */
class UserBio extends StringTag {

    /**
     * Constructor
     */
    public function __construct() {

    	parent::__construct( array(
			'slug'        => 'user_bio',
			'name'        => __( 'User bio' ),
			'description' => __( 'Developer based in Ontario, Canada' ),
			'example'     => true,
			'resolver'    => function() {
				return $this->trigger->user_object->description;
			},
        ) );

    }

    /**
     * Function for checking requirements
     *
     * @return boolean
     */
    public function check_requirements( ) {
        return isset( $this->trigger->user_object->description );
    }

}
