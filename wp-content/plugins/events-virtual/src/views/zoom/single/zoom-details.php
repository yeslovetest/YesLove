<?php
/**
 * Zoom details section for event single.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-virtual/zoom/single/zoom-details.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 1.1.2
 *
 * @var WP_Post $event             The event post object with properties added by the `tribe_get_event` function.
 * @var array   $link_button_attrs Associative array of link button attributes.
 * @var array   $zoom_link_attrs   Associative array of zoom link attributes.
 *
 * @see tribe_get_event() For the format of the event object.
 */

// Remove the query vars from the zoom URL to avoid too long a URL in display.
if ( ! empty( $event->zoom_join_url ) ) {
	$short_zoom_url = implode(
		'',
		array_intersect_key( wp_parse_url( $event->zoom_join_url ), array_flip( [ 'host', 'path' ] ) )
	);
}
?>
<div class="tribe-events-virtual-single-zoom-details tribe-events-single-section tribe-events-event-meta tribe-clearfix">
	<?php if ( $event->virtual_linked_button && ! empty( $event->zoom_join_url ) ) : ?>
		<div class="tribe-events-virtual-single-zoom-details__meta-group tribe-events-virtual-single-zoom-details__meta-group--link-button tribe-events-meta-group">
			<?php
			$this->template(
				'components/link-button',
				[
					'url'   => $event->zoom_join_url,
					'label' => $event->virtual_linked_button_text,
					'attrs' => $link_button_attrs,
				]
			);
			?>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $event->zoom_join_url ) ) : ?>
		<div class="tribe-events-virtual-single-zoom-details__meta-group tribe-events-virtual-single-zoom-details__meta-group--zoom-link tribe-events-meta-group">
			<?php
			$this->template(
				'v2/components/icons/video',
				[
					'classes' => [
						'tribe-events-virtual-single-zoom-details__icon',
						'tribe-events-virtual-single-zoom-details__icon--video',
					],
				]
			);
			?>
			<div class="tribe-events-virtual-single-zoom-details__meta-group-content">
				<a
					href="<?php echo esc_url( $event->zoom_join_url ); ?>"
					class="tribe-events-virtual-single-zoom-details__zoom-link"
					<?php tribe_attributes( $zoom_link_attrs ); ?>
				>
					<?php echo esc_html( $short_zoom_url ); ?>
				</a>
				<span class="tribe-events-virtual-single-zoom-details__zoom-id">
					<?php
					echo esc_html(
						sprintf(
							// translators: %1$s: ID label, %2$s: Zoom meeting ID.
							_x(
								'%1$s: %2$s',
								'The label for the Zoom Meeting ID, prefixed by ID label.',
								'events-virtual'
							),
							'ID',
							$event->zoom_meeting_id
						)
					);
					?>
				</span>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $event->zoom_global_dial_in_numbers ) ) : ?>
		<div class="tribe-events-virtual-single-zoom-details__meta-group tribe-events-virtual-single-zoom-details__meta-group--zoom-phone tribe-events-meta-group">
			<?php
			$this->template(
				'v2/components/icons/phone',
				[
					'classes' => [
						'tribe-events-virtual-single-zoom-details__icon',
						'tribe-events-virtual-single-zoom-details__icon--phone',
					],
				]
			);
			?>
			<div class="tribe-events-virtual-single-zoom-details__meta-group-content">
				<ul class="tribe-events-virtual-single-zoom-details__phone-number-list">
					<?php foreach ( $event->zoom_global_dial_in_numbers as $phone_number ) : ?>
						<li class="tribe-events-virtual-single-zoom-details__phone-number-list-item">
							<a
								href="<?php echo esc_url( 'tel:' . $phone_number['compact'] ); ?>"
								class="tribe-events-virtual-single-zoom-details__phone-number"
							>
								<?php
								echo esc_html(
									sprintf(
										// translators: %1$s: country, %2$s: Zoom meeting phone number.
										_x(
											'(%1$s) %2$s',
											'The country and phone number for Zoom meeting.',
											'events-virtual'
										),
										$phone_number['country'],
										$phone_number['visual']
									)
								);
								?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	<?php endif; ?>
</div>
