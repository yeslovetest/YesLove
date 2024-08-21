<?php 
  namespace radiustheme\cirkle;
  use radiustheme\cirkle\Helper;
?>
<?php if ( !is_user_logged_in() ) : ?>
<div class="dropdown dropdown-admin">
  <button type="button" data-toggle="dropdown" aria-expanded="false">
    <?php esc_html_e( 'Login', 'cirkle' ); ?>
  </button>
  <div class="dropdown-menu dropdown-menu-right">
    <?php 
      global $user_ID;
      if(empty($user_ID)) { 
    ?>
      <form class="modal-form" action="<?php echo site_url( '/wp-login.php' ); ?>" method="post">
        <div class="login-form-body">
            <div class="form-group">
                <input class="form-control" type="text" name="log" placeholder="<?php esc_attr_e( 'Username', 'cirkle' ); ?>" required>
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="pwd" placeholder="<?php esc_attr_e( 'Password', 'cirkle' ); ?>" required>
            </div>
            <div class="form-group mb-4 checking-box">
                <div class="remember-me form-check">
                    <input type="checkbox" checked="checked" id="checked" class="form-check-input"> 
                    <label for="checked"><?php esc_html_e( 'Remember me', 'cirkle' ); ?></label>
                </div>
                <div class="remember-me form-check">
                    <input type="checkbox" id="passcheck" class="form-check-input">
                    <label for="passcheck"><?php esc_html_e( 'Remember password ?', 'cirkle' ); ?></label>
                </div>
            </div>
            <div class="form-group">
                <button class="submit-btn btn" type="submit"><?php esc_html_e( 'Login', 'cirkle' ); ?></button>
            </div>
        </div>
        <div class="form-footer">
            <span class="forget-psw"><a href="<?php echo wp_lostpassword_url(); ?>"><?php esc_html_e( 'Lost Your password ?', 'cirkle' ); ?></a></span>
        </div>
    </form>
    <?php } ?>
  </div>
</div>
<?php endif; ?>