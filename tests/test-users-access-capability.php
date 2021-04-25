<?php
/**
 * Test case for wp-slideshow plugin's admin side access capability
 *
 * @since      1.0.0
 *
 * @package    wp-slideshow
 */

/**
 * This test case will check whether user has the
 * right capability to access the plugin options
 *
 * @since      1.0.0
 *
 * @package    wp-slideshow
 */
class TestUsersAccessCapability extends WP_UnitTestCase {

	/**
	 * Initialize the test and set its properties.
	 * Add users with different roles before run the test
	 *
	 * @since 1.0.0
	 */
	public function setUp() {

		// make fake users
		$this->admin       = new WP_User( $this->factory->user->create( array( 'role' => 'administrator' ) ) );
		$this->editor      = new WP_User( $this->factory->user->create( array( 'role' => 'editor' ) ) );
		$this->author      = new WP_User( $this->factory->user->create( array( 'role' => 'author' ) ) );
		$this->contributor = new WP_User( $this->factory->user->create( array( 'role' => 'contributor' ) ) );
		$this->subscriber  = new WP_User( $this->factory->user->create( array( 'role' => 'subscriber' ) ) );

	}

	/**
	 * Test users access capability
	 *
	 * @since 1.0.0
	 */
	public function testCapability() {
		// make sure user has the capability to access the plugin options
		$userEditor      = get_user_by( 'id', $this->editor->ID );
		$userAdmin       = get_user_by( 'id', $this->admin->ID );
		$userAuthor      = get_user_by( 'id', $this->author->ID );
		$userContributor = get_user_by( 'id', $this->contributor->ID );
		$userSubscriber  = get_user_by( 'id', $this->subscriber->ID );

		$this->assertTrue( user_can( $userAdmin, wp_slideshow_access_capability() ), 'The admin does not have the access capability, but it should be.' );
		$this->assertFalse( user_can( $userEditor, wp_slideshow_access_capability() ), 'The editor has the access capability, but it should not be.' );
		$this->assertFalse( user_can( $userAuthor, wp_slideshow_access_capability() ), 'The author has the access capability, but it should not be.' );
		$this->assertFalse( user_can( $userContributor, wp_slideshow_access_capability() ), 'The contributor has the access capability, but it should not be.' );
		$this->assertFalse( user_can( $userSubscriber, wp_slideshow_access_capability() ), 'The subscriber has the access capability, but it should not be.' );
	}

	/**
	 * Test users access capability
	 * Remove users after running the test
	 *
	 * @since 1.0.0
	 */
	public function tearDown() {
		parent::tearDown();

		wp_delete_user( $this->editor->ID, true );
		wp_delete_user( $this->admin->ID, true );
		wp_delete_user( $this->author->ID, true );
		wp_delete_user( $this->contributor->ID, true );
		wp_delete_user( $this->subscriber->ID, true );

	}
}
