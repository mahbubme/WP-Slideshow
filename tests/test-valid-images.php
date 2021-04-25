<?php
/**
 * Test case to verify image existence via is_valid_images() function
 *
 * @since      1.0.0
 *
 * @package    wp-slideshow
 */

/**
 * This test case will check the is_valid_images() function and
 * see it's checking the submitted images properly
 *
 * @since      1.0.0
 *
 * @package    wp-slideshow
 */
class TestValidImages extends WP_UnitTestCase {

	/**
	 * Attachment ids
	 *
	 * @since 1.0.0
	 */
	private $attachment_ids;

	/**
	 * Initialize the test and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function setUp() {
		// upload fake attachments and store the attachment ids in a array
		$attachments = array();

		$post_image = $this->factory->post->create_and_get();
		$post_pdf   = $this->factory->post->create_and_get();
		$post_video = $this->factory->post->create_and_get();

		$image_id = $this->factory->attachment->create_upload_object( __DIR__ . '/assets/dummy-attachment.jpg', $post_image->ID );
		$pdf_id   = $this->factory->attachment->create_upload_object( __DIR__ . '/assets/dummy-attachment.pdf', $post_pdf->ID );
		$video_id = $this->factory->attachment->create_upload_object( __DIR__ . '/assets/dummy-attachment.mp4', $post_video->ID );

		$attachments[] = $image_id;
		$attachments[] = $pdf_id;
		$attachments[] = $video_id;

		$this->attachment_ids = $attachments;
	}

	/**
	 * Validate attachments types, and image existence in the database.
	 *
	 * @since 1.0.0
	 */
	public function testIsValidImagesFunction() {
		$this->assertFalse( wp_slideshow_is_valid_images( $this->attachment_ids ), 'Only images are allowed, no other file types are given.' );
	}

	/**
	 * Validate attachments types, and image existence in the database.
	 * Remove uploaded attachments after running the test
	 *
	 * @since 1.0.0
	 */
	public function tearDown() {
		parent::tearDown();

		foreach ( $this->attachment_ids as $post_id ) {
			wp_delete_post( $post_id, true );
		}
	}
}
