<?php 
  namespace radiustheme\cirkle;
  use radiustheme\cirkle\Helper;
?>
<?php if ( is_user_logged_in() ) : ?>
<div class="dropdown dropdown-admin">
  <div class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
    <span class="media">
      <span class="item-img">
        <a href="<?php echo bp_loggedin_user_domain(); ?>">
          <?php bp_loggedin_user_avatar( 'type=full' ); ?>
        </a>
        <span class="acc-verified"><i class="icofont-check"></i></span>
      </span>
      <span class="media-body">
        <span class="item-title"><?php echo bp_core_get_userlink( bp_loggedin_user_id() ); ?></span>
      </span>
    </span>
  </div>
  <div class="dropdown-menu dropdown-menu-right">
    <ul class="admin-options">
      <li><a href="<?php echo bp_core_get_user_domain( bp_loggedin_user_id() ); ?>"><i class="icofont-user-suited"></i><?php esc_html_e( 'Timeline', 'cirkle' ); ?></a></li>
      <li><a href="<?php echo bp_core_get_user_domain( bp_loggedin_user_id() ).'profile'; ?>"><i class="icofont-users-alt-2"></i><?php esc_html_e( 'Profile', 'cirkle' ); ?></a></li>
		<li><a href="<?php echo bp_core_get_user_domain( bp_loggedin_user_id() ).'settings'; ?>"><i class="icofont-gear"></i><?php esc_html_e( 'Settings', 'cirkle' ); ?></a></li>
      <?php if ( RDTheme::$options['profile_groups_tab'] != 0 || bp_is_active( 'groups' ) ){ ?>
      <li><a href="<?php echo esc_url ( bp_loggedin_user_domain().'groups' ); ?>"><i class="icofont-users-alt-2"></i><?php esc_html_e( 'Groups', 'cirkle' ); ?></a></li>
      <?php } ?>
      <li>
        <a href="<?php echo wp_logout_url(); ?>"><i class="icofont-power"></i><?php esc_html_e( 'Log Out', 'cirkle' ); ?></a>
      </li>
    </ul>
  </div>
</div>

<?php else : ?>

<?php endif; ?>