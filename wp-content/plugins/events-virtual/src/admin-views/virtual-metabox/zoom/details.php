<?php
/**
 * View: Virtual Events Metabox Zoom API link controls.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/admin-views/virtual-metabox/zoom/details.php
 *
 * See more documentation about our views templating system.
 *
 * @since   1.0.0
 * @since   1.4.0 - Add display of host and choice of alternative hosts
 * @since   1.5.0 - Add support for multiple accounts.
 *
 * @version 1.5.0
 *
 * @link    http://evnt.is/1aiy
 *
 * @var \WP_Post             $event             The event post object, as decorated by the `tribe_get_event` function.
 * @var string               $account_name      The api account name of a Zoom Meeting or Webinar.
 * @var string               $host_label        The label used to designate the host of a Zoom Meeting or Webinar.
 * @var string               $remove_link_url   The URL to remove the event Zoom Meeting.
 * @var string               $remove_link_label The label of the button to remove the event Zoom Meeting link.
 * @var string               $details_title     The title of the details box.
 * @var array<string>        $phone_numbers     A list of the available meeting dial-in phone numbers.
 * @var string               $id_label          The label used to prefix the meeting ID.
 * @var array<string,string> $alt_hosts         An array of users to be able to select as an alternative host,
 * @var array<string,string> $attrs             Associative array of attributes of the details template.
 * @var string               $message           A html message to display.
 *
 * @see     tribe_get_event() For the format of the event object.
 */

?>

<?php
if ( ! isset( $event->virtual, $event->zoom_join_url, $event->zoom_meeting_id ) ) {
	return;
}

// Remove the query vars from the zoom URL to avoid too long a URL in display.
$short_zoom_url = implode(
	'',
	array_intersect_key( wp_parse_url( $event->zoom_join_url ), array_flip( [ 'host', 'path' ] ) )
);
?>


<div
	id="tribe-events-virtual-meetings-zoom"
	class="tribe-dependent tribe-events-virtual-meetings-zoom-details"
	<?php tribe_attributes( $attrs ) ?>

	data-depends="#tribe-events-virtual-video-source"
	data-condition="zoom"
>
	<div class="tribe-events-virtual-meetings-video-source__inner tribe-events-virtual-meetings-zoom-details__inner">
		<a
			class="tribe-events-virtual-meetings-zoom-details__remove-link"
			href="<?php echo esc_url( $remove_link_url ); ?>"
			aria-label="<?php echo esc_attr( $remove_link_label ); ?>"
			title="<?php echo esc_attr( $remove_link_label ); ?>"
		>
			×
		</a>

		<?php echo $message; ?>

		<div class="tribe-events-virtual-meetings-zoom__title">
			<?php echo esc_html( $details_title ); ?> <?php echo esc_html( $account_name ); ?>
		</div>

		<div class="tribe-events-virtual-meetings-zoom__host">
			<?php echo esc_html( $host_label ); ?><?php echo esc_html( $event->zoom_host_email ); ?>
		</div>

		<div class="tribe-events-virtual-meetings-zoom__alternative-host">
			<?php $this->template( 'virtual-metabox/zoom/components/multiselect', $alt_hosts );	?>
		</div>

		<div class="tribe-events-virtual-meetings-zoom__url-wrapper">
			<?php
			$this->template( 'virtual-metabox/zoom/icons/video', [
				'classes' => [
					'tribe-events-virtual-meeting-zoom__icon',
					'tribe-events-virtual-meeting-zoom__icon--video',
				],
			] );
			?>
			<div class="tribe-events-virtual-meetings-zoom__url">
				<a
					href="<?php echo esc_url( $event->zoom_join_url ); ?>"
					class="tribe-events-virtual-meetings-zoom__url-meeting-link"
				>
					<?php echo esc_html( $short_zoom_url ); ?>
				</a>
				<div class="tribe-events-virtual-meetings-zoom__url-meeting-id">
					<?php echo esc_html( $id_label ); ?>
					<?php echo esc_html( $event->zoom_meeting_id ); ?>
				</div>
			</div>
		</div>

		<?php if ( count( $phone_numbers ) ) : ?>
			<div class="tribe-events-virtual-meetings-zoom__phone-wrapper">
				<?php
				$this->template( 'virtual-metabox/zoom/icons/phone', [
					'classes' => [
						'tribe-events-virtual-meeting-zoom__icon',
						'tribe-events-virtual-meeting-zoom__icon--phone',
					],
				] );
				?>
				<ul class="tribe-events-virtual-meetings-zoom__phone-list">
					<?php foreach ( $phone_numbers as $phone_number => $country ) : ?>
						<li class="tribe-events-virtual-meetings-zoom__phone-list-item">
							<a
								href="<?php echo esc_url( 'tel:' . trim( str_replace( ' ', '', $phone_number ) ) ); ?>"
								class="tribe-events-virtual-meetings-zoom__phone-list-item-number"
							>
								<?php echo esc_html( "({$country}) {$phone_number}" ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

	</div>
</div>
