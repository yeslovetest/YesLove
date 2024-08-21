<?php
/**
 * @author  RadiusTheme
 *
 * @since   1.0
 *
 * @version 1.1
 */
if (!defined('ABSPATH')) {
	exit;
}

class Cirkle_Usermeta
{
	protected static $instance;

	public function __construct()
	{
		add_action('show_user_profile', [$this, 'add_customer_meta_fields'], 1);
		add_action('edit_user_profile', [$this, 'add_customer_meta_fields'], 1);
		add_action('personal_options_update', [$this, 'save_customer_meta_fields']);
		add_action('edit_user_profile_update', [$this, 'save_customer_meta_fields']);

		add_action('wp_ajax_state_by_country', [&$this, 'state_by_country']);
		add_action('wp_ajax_nopriv_state_by_country', [&$this, 'state_by_country']);
	}

	public static function instance()
	{
		if (null == self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Get Address Fields for the edit user pages.
	 *
	 * @return array Fields to display which are filtered through cirkle_user_location_fields before being returned
	 */
	public function get_customer_meta_fields()
	{
		$show_fields = apply_filters(
			'cirkle_user_location_fields',
			[
				'user_location'  => [
					'title'  => esc_html__('User Location', 'cirkle-core'),
					'fields' => [
						'user_country'    => [
							'label'       => esc_html__('Country', 'cirkle'),
							// 'description' => esc_html__( 'Some country has no region allowed', 'cirkle-core' ),
							'class'       => 'cirkle_field_country',
							'type'        => 'select',
							'options'     => ['' => esc_html__('Select a country / region&hellip;', 'cirkle-core')] + Cirkle_Core::getCountryList(),
						],
						'user_state'      => [
							'label'       => esc_html__('Region / State', 'cirkle-core'),
							'type'        => 'select',
							'class'       => 'cirkle_field_state',
						],
					],
				],
			]
		);

		return $show_fields;
	}

	/**
	 * Show Address Fields on edit user pages.
	 *
	 * @param WP_User $user
	 */
	public function add_customer_meta_fields($user)
	{
		if (!apply_filters('cirkle_current_user_can_edit_customer_meta_fields', current_user_can('administrator'), $user->ID)) {
			return;
		}

		$show_fields = $this->get_customer_meta_fields();

		foreach ($show_fields as $fieldset_key => $fieldset) {
			?>
				<h2><?php echo $fieldset['title']; ?>
				</h2>
				<table class="form-table"
					id="<?php echo esc_attr('fieldset-'.$fieldset_key); ?>">
					<?php foreach ($fieldset['fields'] as $key => $field) { ?>
					<tr>
						<th>
							<label for="<?php echo esc_attr($key); ?>"><?php echo esc_html($field['label']); ?></label>
						</th>
						<td>
							<?php if (!empty($field['type']) && 'select' === $field['type']) { ?>
							<select name="<?php echo esc_attr($key); ?>"
								id="<?php echo esc_attr($key); ?>"
								class="select2-search <?php echo esc_attr($field['class']); ?>"
								style="width: 25em;"
								data-state="<?php echo esc_attr(get_user_meta($user->ID, 'user_state', true)); ?>">
								<?php
														$selected = esc_attr(get_user_meta($user->ID, $key, true));
														if (!empty($field['options'])) {
															foreach ($field['options'] as $option_key => $option_value) {
																?>
								<option value="<?php echo esc_attr($option_key); ?>"
									<?php selected($selected, $option_key, true); ?>><?php echo esc_html($option_value); ?>
								</option>
								<?php
															}
														} ?>
							</select>
							<?php } elseif (!empty($field['type']) && 'checkbox' === $field['type']) { ?>
							<input type="checkbox"
								name="<?php echo esc_attr($key); ?>"
								id="<?php echo esc_attr($key); ?>" value="1"
								class="<?php echo esc_attr($field['class']); ?>"
								<?php checked((int) get_user_meta($user->ID, $key, true), 1, true); ?>
							/>
							<?php } elseif (!empty($field['type']) && 'button' === $field['type']) { ?>
							<button type="button" id="<?php echo esc_attr($key); ?>"
								class="button <?php echo esc_attr($field['class']); ?>"><?php echo esc_html($field['text']); ?></button>
							<?php } else { ?>
							<input type="text" name="<?php echo esc_attr($key); ?>"
								id="<?php echo esc_attr($key); ?>"
								value="<?php echo esc_attr($this->get_user_meta($user->ID, $key)); ?>"
								class="<?php echo !empty($field['class']) ? esc_attr($field['class']) : 'regular-text'; ?>" />
							<?php } if (!empty($field['description'])) { ?>
							<p class="description"><?php //echo wp_kses_post( $field['description'] );?></p>
							<?php } ?>
						</td>
					</tr>
					<?php } ?>
				</table>
				<?php
		}
	}

	/**
	 * Save Address Fields on edit user pages.
	 *
	 * @param int $user_id User ID of the user being saved
	 */
	public function save_customer_meta_fields($user_id)
	{
		if (!apply_filters('cirkle_current_user_can_edit_customer_meta_fields', current_user_can('administrator'), $user_id)) {
			return;
		}

		$save_fields = $this->get_customer_meta_fields();

		foreach ($save_fields as $fieldset) {
			foreach ($fieldset['fields'] as $key => $field) {
				if (isset($field['type']) && 'checkbox' === $field['type']) {
					update_user_meta($user_id, $key, isset($_POST[$key]));
				} elseif (isset($_POST[$key])) {
					update_user_meta($user_id, $key, $this->cirkle_clean($_POST[$key]));
				}
			}
		}
	}

	/**
	 * Get user meta for a given key, with fallbacks to core user info for pre-existing fields.
	 *
	 * @since 3.1.0
	 *
	 * @param int    $user_id User ID of the user being edited
	 * @param string $key     Key for user meta field
	 *
	 * @return string
	 */
	protected function get_user_meta($user_id, $key)
	{
		$value           = get_user_meta($user_id, $key, true);
		$existing_fields = ['user_login'];
		if (!$value && in_array($key, $existing_fields)) {
			$value = get_user_meta($user_id, str_replace('user_', '', $key), true);
		} elseif (!$value && ('user_email' === $key)) {
			$user  = get_userdata($user_id);
			$value = $user->user_email;
		}

		return $value;
	}

	/**
	 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
	 * Non-scalar values are ignored.
	 *
	 * @param string|array $var data to sanitize
	 *
	 * @return string|array
	 */
	public function cirkle_clean($var)
	{
		if (is_array($var)) {
			return array_map('cirkle_clean', $var);
		} else {
			return is_scalar($var) ? sanitize_text_field($var) : $var;
		}
	}

	/**
	 * User Locations
	 ==========================================================================
	 */
	public static function user_locations()
	{
		$mb_user_meta_key = 'user_country';

		$mb_get_users        = get_users(['meta_key' => $mb_user_meta_key]);
		$mb_user_meta_values = [];
		foreach ($mb_get_users as $mb_user) {
			$mb_user_meta_values[] = get_user_meta($mb_user->ID, $mb_user_meta_key, true);
		}
		$mb_user_meta_values = array_unique($mb_user_meta_values);

		$all_country = Cirkle_Core::getCountryList();

		$used_country = [];
		foreach ($all_country as $key => $value) {
			if (in_array($key, $mb_user_meta_values)) {
				$used_country[$key] = $value;
			}
		}

		return array_unique($used_country);
	}

	public static function user_state()
	{
		$mb_user_meta_key = 'user_state';

		$mb_get_users        = get_users(['meta_key' => $mb_user_meta_key]);
		$mb_user_meta_values = [];
		foreach ($mb_get_users as $mb_user) {
			$mb_user_meta_values[] = get_user_meta($mb_user->ID, $mb_user_meta_key, true);
		}
		$mb_user_meta_values = array_unique($mb_user_meta_values);

		$all_state = Cirkle_Core::getStateByCountry();

		$used_state = [];
		foreach ($all_state as $value) {
			if (is_array($value)) {
				foreach ($value as $state_key => $state_value) {
					if (in_array($state_key, $mb_user_meta_values)) {
						$used_state[$state_key] = $state_value;
					}
				}
			}
		}

		return array_unique($used_state);
	}

	/**
	 * User States
	 ==========================================================================
	 */
	public function state_by_country()
	{
		$country_id = isset($_POST['value']) ? sanitize_text_field($_POST['value']) : '';
		$user_state = isset($_POST['user_state']) ? sanitize_text_field($_POST['user_state']) : '';
		//$elementor = isset( $_POST['elementor'] ) ? true : false;
		$data   = '';
		$states = Cirkle_Core::getStateByCountry($country_id);

		foreach ($states as $key => $value) {
			//if ( $elementor && ! isset( self::user_state()[$key] ) ) continue;

			$selected = ($user_state == $key) ? 'selected' : '';

			$data .= sprintf(
				'<option %s value="%s">%s</option>',
				$selected,
				$key,
				$value
			);
		}
		wp_send_json_success($data);
	}
}

Cirkle_Usermeta::instance();
