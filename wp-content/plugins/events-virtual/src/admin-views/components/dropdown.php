<?php
/**
 * View: Virtual Events Metabox Dropdown.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/admin-views/components/dropdown.php
 *
 * See more documentation about our views templating system.
 *
 * @link    https://evnt.is/1aiy
 *
 * @version 1.6.0
 *
 * @var string               $label    Label for the dropdown input.
 * @var string               $id       ID of the dropdown input.
 * @var string               $class    Class attribute for the dropdown input.
 * @var string               $name     Name attribute for the dropdown input.
 * @var string|int           $selected The selected option id.
 * @var array<string,string> $attrs    Associative array of attributes of the dropdown.
 */
?>
<div
	class="tribe-events-virtual-meetings-control tribe-events-virtual-meetings-control--select"
>
	<label
		class="screen-reader-text tribe-events-virtual-meetings-control__label"
		for="<?php echo esc_attr( $id ); ?>"
	>
		<?php echo esc_html( $label ); ?>
	</label>
	<select
		id="<?php echo esc_attr( $id ); ?>"
		name="<?php echo esc_attr( $name ); ?>"
		class="tribe-dropdown <?php echo esc_attr( $class ); ?>"
		value="<?php echo esc_attr( $selected ); ?>"
		style="width: 100%;" <?php /* This is required for selectWoo styling to prevent select box overflow */ ?>
		<?php tribe_attributes( $attrs ) ?>
	>
	</select>
</div>
