<?php if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');}

class MeprCheckoutCtrl extends MeprBaseCtrl {
  public function load_hooks() {
    add_action('wp_enqueue_scripts', array($this,'enqueue_scripts'));
    add_action('mepr-signup', array($this, 'process_spc_payment_form'), 100); // 100 priority to give other things a chance to hook in before SPC takes over the world
    add_filter('mepr_signup_form_payment_description', array($this, 'maybe_render_payment_form'), 10, 3);
    MeprHooks::add_shortcode('mepr-ecommerce-tracking', array($this, 'replace_tracking_codes'));
    add_filter('mepr-signup-checkout-url', array($this, 'handle_spc_checkout_url'), 10, 2);
    add_action( 'wp_ajax_mepr_update_spc_invoice_table', array( $this, 'update_spc_invoice_table' ) );
    add_action( 'wp_ajax_nopriv_mepr_update_spc_invoice_table', array( $this, 'update_spc_invoice_table' ) );
    add_action( 'wp_ajax_nopriv_mepr_update_price_string', array( $this, 'update_price_string' ) );
    add_action( 'wp_ajax_mepr_update_price_string', array( $this, 'update_price_string' ) );
    add_action( 'mepr_readylaunch_thank_you_page_after_content', array( $this, 'maybe_show_order_bumps_error_message_in_readylaunch' ) );
    add_filter('mepr_options_helper_payment_methods', array($this, 'exclude_disconnected_gateways'), 10, 2);
    add_filter( 'the_content', [$this, 'maybe_show_order_bumps_error_message'], 1 );
  }

  public function maybe_show_order_bumps_error_message_in_readylaunch()
  {
    if (!isset($_GET['trans_num'])) {
      return;
    }

    $trans_num = filter_var( $_GET['trans_num'] );
    $original_txn = MeprTransaction::get_one_by_trans_num( $trans_num );

    if (isset($original_txn->id)) {
      $original_txn = new MeprTransaction($original_txn->id);
    }

    $order = $original_txn->order();

    if ( !$order ) {
      return;
    }

    $bumps = MeprTransaction::get_all_by_order_id( $order->id );
    $errors = [];

    foreach ( $bumps as $txn ) {
      $product = $txn->product();
      $meta = $txn->get_meta( '_authorizenet_txn_error_', true );

      if (empty($meta)) {
        continue;
      }

      $error = (explode('|', $meta));
      $error_message = sprintf( __( 'Notice: %s purchase failed. Click <a href="%s" target="_blank">here</a> to purchase it separately.', 'memberpress' ), $product->post_title, get_permalink($product->ID) );


      if ( ! empty( $error ) ) {
        $errors[] = $error_message;
      }
    }

    if ( !empty($errors) ) {
      MeprView::render('/shared/errors', get_defined_vars());
      echo "<br>";
    }
  }

  public function maybe_show_order_bumps_error_message( $content ) {
    if ( is_singular() && in_the_loop() && is_main_query() ) {
      $mepr_options = MeprOptions::fetch();

      if ( $mepr_options->thankyou_page_id != get_the_ID() ) {
        return $content;
      }

      if (!isset($_GET['trans_num'])) {
        return $content;
      }

      $trans_num = filter_var( $_GET['trans_num'] );
      $original_txn = MeprTransaction::get_one_by_trans_num( $trans_num );

      if (isset($original_txn->id)) {
        $original_txn = new MeprTransaction($original_txn->id);
      }

      $order = $original_txn->order();

      if ( !$order ) {
        return $content;
      }

      $bumps = MeprTransaction::get_all_by_order_id( $order->id );
      $errors = [];

      foreach ( $bumps as $txn ) {
        $product = $txn->product();
        $meta = $txn->get_meta( '_authorizenet_txn_error_', true );

        if (empty($meta)) {
          continue;
        }

        $error = (explode('|', $meta));
        $error_message = sprintf( __( 'Notice: %s purchase failed. Click <a href="%s" target="_blank">here</a> to purchase it separately.', 'memberpress' ), $product->post_title, get_permalink($product->ID) );

        if ( ! empty( $error ) ) {
          $errors[] = $error_message;
        }
      }

      if ( !empty($errors) ) {
        ob_start();
        MeprView::render('/shared/errors', get_defined_vars());
        $error_section = ob_get_contents();
        ob_end_clean();
        $content .= $error_section;
      }
    }

    return $content;
  }

  public function replace_tracking_codes($atts, $content='') {
    $atts = shortcode_atts(
      array(
        'membership' => null,
      ),
      $atts,
      'mepr-ecommerce-tracking'
    );

    if(!($this->request_has_valid_thank_you_params($_GET) &&
       $this->request_has_valid_thank_you_membership_id($_GET) &&
       $this->request_has_valid_thank_you_trans_num($_GET) &&
       $this->request_has_valid_thank_you_membership($atts, $_GET))) {
      return '';
    }

    $tracking_codes = array(
      '%%subtotal%%'          => array('MeprTransaction'  => 'tracking_subtotal'),
      '%%tax_amount%%'        => array('MeprTransaction'  => 'tracking_tax_amount'),
      '%%tax_rate%%'          => array('MeprTransaction'  => 'tracking_tax_rate'),
      '%%total%%'             => array('MeprTransaction'  => 'tracking_total'),
      '%%txn_num%%'           => array('MeprTransaction'  => 'trans_num'),
      '%%sub_id%%'            => array('MeprTransaction'  => 'subscription_id'),
      '%%txn_id%%'            => array('MeprTransaction'  => 'id'),
      '%%sub_num%%'           => array('MeprSubscription' => 'subscr_id'),
      '%%membership_amount%%' => array('MeprSubscription' => 'price'),
      '%%trial_days%%'        => array('MeprSubscription' => 'trial_days'),
      '%%trial_amount%%'      => array('MeprSubscription' => 'trial_amount'),
      '%%username%%'          => array('MeprUser'         => 'user_login'),
      '%%user_email%%'        => array('MeprUser'         => 'user_email'),
      '%%user_id%%'           => array('MeprUser'         => 'ID'),
      '%%membership_name%%'   => array('MeprProduct'      => 'post_title'),
      '%%membership_id%%'     => array('MeprProduct'      => 'ID'),
    );

    foreach($tracking_codes as $code => $mapping) {
      // Make sure the content has a code to replace
      if(strpos($content, $code) !== false) {
        foreach($mapping as $model => $attr) {
          switch($model) {
            case 'MeprTransaction':
              // Only fetch the object once!
              if(!isset($txn)) {
                if(isset($_GET['trans_num']) && !empty($_GET['trans_num'])) {
                  $rec = $model::get_one_by_trans_num($_GET['trans_num']);
                  $txn = $obj = new MeprTransaction($rec->id);
                }
                elseif(isset($_GET['transaction_id']) && !empty($_GET['transaction_id'])) {
                  $txn = $obj = new MeprTransaction((int) $_GET['transaction_id']);
                }
              }
              break;
            case 'MeprSubscription':
              if(!isset($sub)) {
                if(isset($_GET['subscr_id']) && !empty($_GET['subscr_id'])) {
                  $sub = $obj = $model::get_one_by_subscr_id($_GET['subscr_id']);
                }
                elseif(isset($_GET['subscription_id']) && !empty($_GET['subscription_id'])) {
                  $sub = $obj = $model::get_one((int) $_GET['subscription_id']);
                }
              }
              break;
            case 'MeprUser':
              if(!isset($user)) {
                $user = $obj = MeprUtils::get_currentuserinfo();
              }
              break;
            case 'MeprProduct':
              if(!isset($prod) && isset($_GET['membership_id']) && !empty($_GET['membership_id'])) {
                $prod = $obj = new $model($_GET['membership_id']);
              }
              break;
            default:
              unset($obj);
          }
          if(isset($obj) && (isset($obj->id) && (int) $obj->id > 0) || (isset($obj->ID) && (int) $obj->ID > 0)) {
            $content = str_replace($code, $obj->$attr, $content);
            break; // once we've replaced the code time to move on
          }
        }
        // Blank out the code if it isn't found
        $content = str_replace($code, '', $content);
      }
    }
    return $content;
  }

  /** Enqueue gateway specific js/css if required */
  public function enqueue_scripts() {
    global $post;
    $mepr_options = MeprOptions::fetch();

    if(MeprProduct::is_product_page($post)) {

      $has_phone = false;

      if ( ! empty( $mepr_options->custom_fields ) ) {
        foreach ( $mepr_options->custom_fields as $field ) {
          if ( 'tel' === $field->field_type && $field->show_on_signup ) {
            $has_phone = true;
            break;
          }
        }
      }

      // Check if there's a phone field
      if ( $has_phone ) {
        wp_enqueue_style( 'mepr-phone-css', MEPR_CSS_URL . '/intlTelInput.min.css', '', '16.0.0' );
        wp_enqueue_style( 'mepr-tel-config-css', MEPR_CSS_URL . '/tel_input.css', '', MEPR_VERSION );
        wp_enqueue_script( 'mepr-phone-js', MEPR_JS_URL . '/intlTelInput.js', '', '16.0.0', true );
        wp_enqueue_script( 'mepr-tel-config-js', MEPR_JS_URL . '/tel_input.js', array( 'mepr-phone-js', 'mp-signup' ), MEPR_VERSION, true );
        wp_localize_script( 'mepr-tel-config-js', 'meprTel', MeprHooks::apply_filters( 'mepr-phone-input-config', array(
          'defaultCountry' => strtolower( get_option( 'mepr_biz_country' ) ),
          'utilsUrl' => MEPR_JS_URL . '/intlTelInputUtils.js'
        ) ) );
      }

      if(((isset($_REQUEST['action']) &&
           $_REQUEST['action'] === 'checkout' &&
           ( (isset($_REQUEST['mepr_transaction_id']) &&
             ($txn = new MeprTransaction($_REQUEST['mepr_transaction_id']))) ||
             (isset($_REQUEST['txn']) &&
             ($txn = new MeprTransaction($_REQUEST['txn'])))
           ) &&
           $txn->id > 0 &&
           ($pm = $txn->payment_method())) ||
          (MeprUtils::is_user_logged_in() &&
           isset($_REQUEST['action']) &&
           $_REQUEST['action'] === 'update' &&
           isset($_REQUEST['sub']) &&
           ($sub = new MeprSubscription($_REQUEST['sub'])) &&
           $sub->id > 0 &&
           ($pm = $sub->payment_method()))) &&
         ($pm instanceof MeprBaseRealGateway)) {
        wp_register_script('mepr-checkout-js', MEPR_JS_URL . '/checkout.js', array('jquery', 'jquery.payment'), MEPR_VERSION);
        $pm->enqueue_payment_form_scripts();
      }
    }
  }

  /**
  * Renders the payment form if SPC is enabled and supported by the payment method
  * Called from: mepr_signup_form_payment_description filter
  * Returns: description includding form for SPC if enabled
  */
  public function maybe_render_payment_form($description, $payment_method, $first) {
    $mepr_options = MeprOptions::fetch();
    if( ($mepr_options->enable_spc || $mepr_options->design_enable_checkout_template) && $payment_method->has_spc_form) {
      // TODO: Maybe we queue these up from wp_enqueue_scripts?
      wp_register_script('mepr-checkout-js', MEPR_JS_URL . '/checkout.js', array('jquery', 'jquery.payment'), MEPR_VERSION);
      wp_enqueue_script('mepr-checkout-js');
      $payment_method->enqueue_payment_form_scripts();
      $description = $payment_method->spc_payment_fields();
    }
    return $description;
  }

  public function display_signup_form($product) {
    $mepr_options = MeprOptions::fetch();
    $mepr_blogurl = home_url();
    $mepr_coupon_code = '';

    extract($_REQUEST, EXTR_SKIP);
    if ( isset( $_REQUEST['errors'] ) ) {
      if ( is_array( $_REQUEST['errors'] ) ) {
        $errors = array_map( 'wp_kses_post', $_REQUEST['errors'] ); // Use kses here so our error HTML isn't stripped
      } else {
        $errors = [ wp_kses_post( $_REQUEST['errors'] ) ];
      }
    }
    //See if Coupon was passed via GET
    if(isset($_GET['coupon']) && !empty($_GET['coupon'])) {
      if(MeprCoupon::is_valid_coupon_code($_GET['coupon'], $product->ID)) {
        $mepr_coupon_code = htmlentities( sanitize_text_field( $_GET['coupon'] ) );
      }
    }

    if(MeprUtils::is_user_logged_in()) {
      $mepr_current_user = MeprUtils::get_currentuserinfo();
    }

    $first_name_value = '';
    if(isset($user_first_name)) {
      $first_name_value = esc_attr(stripslashes($user_first_name));
    }
    elseif(MeprUtils::is_user_logged_in()) {
      $first_name_value = (string)$mepr_current_user->first_name;
    }

    $last_name_value = '';
    if(isset($user_last_name)) {
      $last_name_value = esc_attr(stripslashes($user_last_name));
    }
    elseif(MeprUtils::is_user_logged_in()) {
      $last_name_value = (string)$mepr_current_user->last_name;
    }

    if(isset($errors) and !empty($errors)) {
      MeprView::render("/shared/errors", get_defined_vars());
    }

    // Gather payment methods for checkout
    $payment_methods = $product->payment_methods();
    if(empty($payment_methods)) {
      $payment_methods = array_keys($mepr_options->integrations);
    }
    $payment_methods = MeprHooks::apply_filters('mepr_options_helper_payment_methods', $payment_methods, 'mepr_payment_method');
    $payment_methods = array_map(function($pm_id) use($mepr_options) {
      return $mepr_options->payment_method($pm_id);
    }, $payment_methods);

    static $unique_suffix = 0;
    $unique_suffix++;

    $payment_required = MeprHooks::apply_filters('mepr_signup_payment_required', $product->is_payment_required($mepr_coupon_code), $product);

    if($mepr_options->enable_spc) {
      MeprView::render('/checkout/spc_form', get_defined_vars());
    }
    else {
      MeprView::render('/checkout/form', get_defined_vars());
    }
  }

  /** Gets called on the 'init' hook ... used for processing aspects of the signup
    * form before the logic progresses on to 'the_content' ...
    */
  public function process_signup_form() {
    $mepr_options = MeprOptions::fetch();

    if(isset($_POST['mepr_transaction_id']) && is_numeric($_POST['mepr_transaction_id'])) {
      // With the new Stripe SCA changes a transaction already exists, just grab the vars we need for the hooks
      $txn = new MeprTransaction((int) $_POST['mepr_transaction_id']);

      if(empty($txn->id)) {
        $_POST['errors'] = array(__('Sorry, we were unable to find the transaction.', 'memberpress'));
        return;
      }

      $usr = $txn->user();

      if (empty($usr->ID)) {
        $_POST['errors'] = array(__('Sorry, we were unable to find the user.', 'memberpress'));
        return;
      }

      $is_existing_user = true;

      $product = $txn->product();

      if($product->is_one_time_payment()) {
        $signup_type = 'non-recurring';
      }
      else {
        $signup_type = 'recurring';
      }
    }
    else {
      // Validate the form post
      $errors = MeprHooks::apply_filters('mepr-validate-signup', MeprUser::validate_signup($_POST, array()));
      if(!empty($errors)) {
        $_POST['errors'] = $errors; //Deprecated?
        $_REQUEST['errors'] = $errors;

        return;
      }

      // Check if the user is logged in already
      $is_existing_user = MeprUtils::is_user_logged_in();

      if($is_existing_user) {
        $usr = MeprUtils::get_currentuserinfo();
      }
      else { // If new user we've got to create them and sign them in
        $usr = new MeprUser();
        $usr->user_login = ($mepr_options->username_is_email)?sanitize_email($_POST['user_email']):sanitize_user($_POST['user_login']);
        $usr->user_email = sanitize_email($_POST['user_email']);
        $usr->first_name = isset($_POST['user_first_name']) && !empty($_POST['user_first_name']) ? sanitize_text_field(wp_unslash($_POST['user_first_name'])) : '';
        $usr->last_name = isset($_POST['user_last_name']) && !empty($_POST['user_last_name']) ? sanitize_text_field(wp_unslash($_POST['user_last_name'])) : '';

        $password = ($mepr_options->disable_checkout_password_fields === true) ? wp_generate_password() : $_POST['mepr_user_password'];
        //Have to use rec here because we unset user_pass on __construct
        $usr->set_password($password);

        try {
          $usr->store();

          // We need to refresh the user object. In the case where emails are used as
          // usernames, the email & username could differ after the user is saved.
          $usr = new MeprUser($usr->ID);

          // Log the new user in
          if(MeprHooks::apply_filters('mepr-auto-login', true, $_POST['mepr_product_id'], $usr)) {
            wp_signon(
              array(
                'user_login'    => $usr->user_login,
                'user_password' => $password
              ),
              MeprUtils::is_ssl() //May help with the users getting logged out when going between http and https
            );
          }

          MeprEvent::record('login', $usr); //Record the first login here
        }
        catch(MeprCreateException $e) {
          $_POST['errors'] = array(__( 'The user was unable to be saved.', 'memberpress'));  //Deprecated?
          $_REQUEST['errors'] = array(__( 'The user was unable to be saved.', 'memberpress'));
          return;
        }
      }

      // Create a new transaction and set our new membership details
      $txn = new MeprTransaction();
      $txn->user_id = $usr->ID;

      // Get the membership in place
      $txn->product_id = sanitize_text_field($_POST['mepr_product_id']);
      $product = $txn->product();

      if(empty($product->ID)) {
        $_POST['errors'] = array(__('Sorry, we were unable to find the membership.', 'memberpress'));
        $_REQUEST['errors'] = array(__('Sorry, we were unable to find the membership.', 'memberpress'));
        return;
      }

      // If we're showing the fields on logged in purchases, let's save them here
      if(!$is_existing_user || ($is_existing_user && $mepr_options->show_fields_logged_in_purchases)) {
        MeprUsersCtrl::save_extra_profile_fields($usr->ID, true, $product, true);
        $usr = new MeprUser($usr->ID); //Re-load the user object with the metadata now (helps with first name last name missing from hooks below)
      }

      // Needed for autoresponders (SPC + Stripe + Free Trial issue)
      MeprHooks::do_action('mepr-signup-user-loaded', $usr);

      // Set default price, adjust it later if coupon applies
      $price = $product->adjusted_price();

      // Default coupon object
      $cpn = (object)array('ID' => 0, 'post_title' => null);

      // Adjust membership price from the coupon code
      if(isset($_POST['mepr_coupon_code']) && !empty($_POST['mepr_coupon_code'])) {
        // Coupon object has to be loaded here or else txn create will record a 0 for coupon_id
        $mepr_coupon_code = htmlentities(sanitize_text_field($_POST['mepr_coupon_code']));
        $cpn = MeprCoupon::get_one_from_code(sanitize_text_field($_POST['mepr_coupon_code']));

        if(($cpn !== false) || ($cpn instanceof MeprCoupon)) {
          $price = $product->adjusted_price($cpn->post_title);
        }
      }

      $txn->set_subtotal($price);

      // Set the coupon id of the transaction
      $txn->coupon_id = $cpn->ID;

      // Figure out the Payment Method
      if(isset($_POST['mepr_payment_method']) && !empty($_POST['mepr_payment_method'])) {
        $txn->gateway = sanitize_text_field($_POST['mepr_payment_method']);
      }
      else {
        $txn->gateway = MeprTransaction::$free_gateway_str;
      }

      // Let's checkout now
      if($txn->gateway === MeprTransaction::$free_gateway_str) {
        $signup_type = 'free';
      }
      elseif(($pm = $txn->payment_method()) && $pm instanceof MeprBaseExclusiveRecurringGateway) {
        $sub_attrs = $pm->subscription_attributes($product->plan_code);
        if($pm->is_one_time_payment($product->plan_code)) {
          $signup_type = 'non-recurring';
          $price = $sub_attrs['one_time_amount'];
        }
        else {
          $signup_type = 'recurring';

          // Create the subscription from the gateway plan
          $sub = new MeprSubscription($sub_attrs);
          $sub->user_id = $usr->ID;
          $sub->gateway = $pm->id;
          $sub->product_id = $product->ID;
          $sub->maybe_prorate(); // sub to sub
          $sub->store();

          // Update the transaction with subscription id
          $txn->subscription_id = $sub->id;
          $price = $sub->price;
        }
        // Update subtotal
        $txn->amount = $price;
      }
      elseif(($pm = $txn->payment_method()) && ($pm instanceof MeprBaseRealGateway)) {
        // Set default price, adjust it later if coupon applies
        $price = $product->adjusted_price();
        // Default coupon object
        $cpn = (object)array('ID' => 0, 'post_title' => null);
        // Adjust membership price from the coupon code
        if(isset($_POST['mepr_coupon_code']) && !empty($_POST['mepr_coupon_code'])) {
          // Coupon object has to be loaded here or else txn create will record a 0 for coupon_id
          $cpn = MeprCoupon::get_one_from_code(sanitize_text_field($_POST['mepr_coupon_code']));
          if(($cpn !== false) || ($cpn instanceof MeprCoupon)) {
            $price = $product->adjusted_price($cpn->post_title);
          }
        }
        $txn->set_subtotal($price);
        // Set the coupon id of the transaction
        $txn->coupon_id = $cpn->ID;
        // Create a new subscription
        if($product->is_one_time_payment()) {
          $signup_type = 'non-recurring';
        }
        else {
          $signup_type = 'recurring';

          $sub = new MeprSubscription();
          $sub->user_id = $usr->ID;
          $sub->gateway = $pm->id;
          $sub->load_product_vars($product, $cpn->post_title, true);
          $sub->maybe_prorate(); // sub to sub
          $sub->store();

          $txn->subscription_id = $sub->id;
        }
      }
      else {
        $_POST['errors'] = array(__('Invalid payment method', 'memberpress'));
        return;
      }

      $txn->store();

      if(empty($txn->id)) {
        // Don't want any loose ends here if the $txn didn't save for some reason
        if($signup_type === 'recurring' && ($sub instanceof MeprSubscription)) {
          $sub->destroy();
        }
        $_POST['errors'] = array(__('Sorry, we were unable to create a transaction.', 'memberpress'));
        return;
      }
    }

    try {
      if(! $is_existing_user) {
        if($mepr_options->disable_checkout_password_fields === true) {
          $usr->send_password_notification('new');
        }
      }

      // DEPRECATED: These 2 actions here for backwards compatibility ... use mepr-signup instead
      MeprHooks::do_action('mepr-track-signup',   $txn->amount, $usr, $product->ID, $txn->id);
      MeprHooks::do_action('mepr-process-signup', $txn->amount, $usr, $product->ID, $txn->id);

      if(('free' !== $signup_type) && isset($pm) && ($pm instanceof MeprBaseRealGateway)) {
        $pm->process_signup_form($txn);
      }

      // Signup type can be 'free', 'non-recurring' or 'recurring'
      MeprHooks::do_action("mepr-{$signup_type}-signup", $txn);
      MeprHooks::do_action('mepr-signup', $txn);

      // Pass order bump product IDs to the checkout second page
      $obs = isset($_POST['mepr_order_bumps']) && is_array($_POST['mepr_order_bumps']) ? array_filter(array_map('intval', $_POST['mepr_order_bumps'])) : [];
      $args = count($obs) ? ['obs' => $obs] : [];

      MeprUtils::wp_redirect(MeprHooks::apply_filters('mepr-signup-checkout-url', $txn->checkout_url($args), $txn));
    }
    catch(Exception $e) {
      $_POST['errors'] = $_REQUEST['errors'] = array($e->getMessage());
    }
  }

  /**
  * Called from filter mepr-signup-checkout-url
  * Used to handle redirection when there are errors on SPC
  * Returns: redirection URL
  */
  public function handle_spc_checkout_url($checkout_url, $txn) {
    $mepr_options = MeprOptions::fetch();
    if(isset($_POST['mepr_payment_method'])) {
      $payment_method = $mepr_options->payment_method($_POST['mepr_payment_method']);
      if($mepr_options->enable_spc && $payment_method->has_spc_form && !empty($_POST['errors'])) {
        $errors = $_POST['errors'];
        $errors = array_map('urlencode', $errors);
        $query_params = array(
          'errors'                    => $errors,
          'mepr_transaction_id'       => $txn->id,
          'mepr_process_signup_form'  => 0,
          'mepr_process_payment_form' => 1,
          'mepr_payment_method'       => sanitize_text_field($_POST['mepr_payment_method']),
        );
        if(!empty($_POST['mepr_coupon_code'])) {
          $query_params = array_merge(array('mepr_coupon_code' => htmlentities( sanitize_text_field( $_POST['mepr_coupon_code'] ) )), $query_params);
        }
        $product = $txn->product();
        $checkout_url = add_query_arg($query_params, $product->url());
      }
    }
    return $checkout_url;
  }

  /**
  * Called from mepr-signup action
  * Processes the payment for SPC
  */
  public function process_spc_payment_form($txn) {
    if(did_action('mepr_stripe_payment_pending') || did_action('mepr_stripe_checkout_pending')) {
      return;
    }

    if(isset($_POST['smart-payment-button']) && $_POST['smart-payment-button']) {
      return;
    }

    $mepr_options = MeprOptions::fetch();
    if(isset($_POST['mepr_payment_method'])) {
      $payment_method = $mepr_options->payment_method($_POST['mepr_payment_method']);
      if($mepr_options->enable_spc && $payment_method->has_spc_form || ($mepr_options->design_enable_checkout_template)) {
        $_POST = array_merge(
          $_POST,
          array(
            'mepr_process_payment_form' => 1,
            'mepr_transaction_id'       => $txn->id,
          )
        );
        $this->process_payment_form();
      }
    }
  }

  public function display_payment_page() {
    $mepr_options = MeprOptions::fetch();

    $txn_id = $_REQUEST['txn'];
    $txn = new MeprTransaction($txn_id);

    if(!isset($txn->id) || $txn->id <= 0) {
      wp_die(__('ERROR: Invalid Transaction ID. Use your browser back button and try registering again.', 'memberpress'));
    }

    if($txn->gateway === MeprTransaction::$free_gateway_str || $txn->amount <= 0.00) {
      MeprTransaction::create_free_transaction($txn);
    }
    else if(($pm = $mepr_options->payment_method($txn->gateway)) && $pm instanceof MeprBaseRealGateway) {
      $pm->display_payment_page($txn);
    }

    // Artificially set the payment method params so we can use them downstream
    // when display_payment_form is called in the 'the_content' action.
    $_REQUEST['payment_method_params'] = array(
      'method'         => $txn->gateway,
      'amount'         => $txn->amount,
      'user'           => $txn->user(),
      'product_id'     => $txn->product_id,
      'transaction_id' => $txn->id
    );
  }

  // Called in the 'the_content' hook ... used to display a signup form
  public function display_payment_form() {
    $mepr_options = MeprOptions::fetch();

    if(isset($_REQUEST['payment_method_params'])) {
      extract($_REQUEST['payment_method_params'], EXTR_SKIP);

      if(isset($_REQUEST['errors']) && !empty($_REQUEST['errors'])) {
        $errors = $_REQUEST['errors'];
        MeprView::render('/shared/errors', get_defined_vars());
      }

      if(($pm = $mepr_options->payment_method($method)) &&
         ($pm instanceof MeprBaseRealGateway)) {
        $pm->display_payment_form($amount, $user, $product_id, $transaction_id);
      }
    }
  }

  // Called in the 'the_content' hook ... used to display invoice on single page checkout forms
  public function update_spc_invoice_table() {
    extract($_POST, EXTR_SKIP);

    if(!isset($prd_id) || empty($prd_id)) {
      echo 'false';
      die();
    }

    if(isset($code) && !empty($code)){
      check_ajax_referer('mepr_coupons', 'coupon_nonce');
    }

    $code = sanitize_text_field(wp_unslash($code));
    $product = new MeprProduct(sanitize_key(wp_unslash($prd_id)));
    $order_bump_products = [];

    try {
      $order_bump_product_ids = isset($mepr_order_bumps) && is_array($mepr_order_bumps) ? array_map('intval', $mepr_order_bumps) : [];
      $order_bump_products = self::get_order_bump_products($product->ID, $order_bump_product_ids);
    }
    catch(Exception $e) {
      // ignore exception
    }

    ob_start();
    MeprProductsHelper::display_spc_invoice( $product, $code, $order_bump_products );
    $invoice_html = ob_get_clean();

    wp_send_json(array(
      'status' => 'success',
      'invoice' => $invoice_html,
    ));
  }

  /**
   * Updates price string via AJAX
   *
   * @return void
   */
  public static function update_price_string() {
    extract($_POST, EXTR_SKIP);

    if(!isset($prd_id) || empty($prd_id)) {
      echo 'false';
      die();
    }

    if(isset($code) && !empty($code)){
      check_ajax_referer('mepr_coupons', 'coupon_nonce');
    }

    $code = sanitize_text_field(wp_unslash($code));
    $product = new MeprProduct(sanitize_key(wp_unslash($prd_id)));
    $payment_required = $product->is_payment_required($code);

    if(isset($_POST['mpgft_gift_checkbox']) && "true" == $_POST['mpgft_gift_checkbox']){
      $product->allow_renewal = false;
    }

    ob_start();
    MeprProductsHelper::display_invoice( $product, $code );
    $price_string = ob_get_clean();

    try {
      $order_bump_product_ids = isset($_POST['mepr_order_bumps']) && is_array($_POST['mepr_order_bumps']) ? array_map('intval', $_POST['mepr_order_bumps']) : [];
      $order_bump_products = MeprCheckoutCtrl::get_order_bump_products($product->ID, $order_bump_product_ids);

      foreach($order_bump_products as $product) {
        if($product->is_payment_required()) {
          $payment_required = true;
        }
      }
    }
    catch(Exception $e) {}

    $payment_required = MeprHooks::apply_filters('mepr_signup_payment_required', $payment_required, $product);

    wp_send_json(array(
      'status' => 'success',
      'price_string' => $price_string,
      'payment_required' => $payment_required,
      'is_gift' => MeprHooks::apply_filters( 'mepr_signup_product_is_gift', false, $product)
    ));
  }

  public function process_payment_form() {
    if(isset($_POST['mepr_process_payment_form']) && isset($_POST['mepr_transaction_id']) && is_numeric($_POST['mepr_transaction_id'])) {
      $txn = new MeprTransaction($_POST['mepr_transaction_id']);

      if($txn->rec != false) {
        $mepr_options = MeprOptions::fetch();
        if(($pm = $mepr_options->payment_method($txn->gateway)) && $pm instanceof MeprBaseRealGateway) {
          $errors = $pm->validate_payment_form(array());

          if(empty($errors)) {
            // process_payment_form either returns true
            // for success or an array of $errors on failure
            try {
              $pm->process_payment_form($txn);
            }
            catch(Exception $e) {
              MeprHooks::do_action('mepr_payment_failure', $txn);
              $errors = array($e->getMessage());
            }
          }

          if(empty($errors)) {
            //Reload the txn now that it should have a proper trans_num set
            $txn = new MeprTransaction($txn->id);
            $product = new MeprProduct($txn->product_id);
            $sanitized_title = sanitize_title($product->post_title);
            $query_params = array('membership' => $sanitized_title, 'trans_num' => $txn->trans_num, 'membership_id' => $product->ID);
            if($txn->subscription_id > 0) {
              $sub = $txn->subscription();
              $query_params = array_merge($query_params, array('subscr_id' => $sub->subscr_id));
            }
            MeprUtils::wp_redirect($mepr_options->thankyou_page_url(build_query($query_params)));
          }
          else {
            // Artificially set the payment method params so we can use them downstream
            // when display_payment_form is called in the 'the_content' action.
            $_REQUEST['payment_method_params'] = array(
              'method' => $pm->id,
              'amount' => $txn->amount,
              'user' => new MeprUser($txn->user_id),
              'product_id' => $txn->product_id,
              'transaction_id' => $txn->id
            );
            $_REQUEST['mepr_payment_method'] = $pm->id;
            $_POST['errors'] = $errors;
            return;
          }
        }
      }
    }

    $_POST['errors'] = array(__('Sorry, an unknown error occurred.', 'memberpress'));
  }

  public function exclude_disconnected_gateways($pm_ids, $field_name) {
    $mepr_options = MeprOptions::fetch();
    $connected_pm_ids = array();

    foreach($pm_ids as $pm_id) {
      $obj = $mepr_options->payment_method($pm_id);

      if(MeprUtils::is_gateway_connected($obj)) {
        $connected_pm_ids[] = $pm_id;
      }
    }

    return $connected_pm_ids;
  }


  private function request_has_valid_thank_you_params($req) {
    // If these aren't set as parameters then this isn't actually a real checkout
    if( !isset($req['membership']) ||
        !isset($req['membership_id']) ||
       (!isset($req['trans_num']) && !isset($req['transaction_id']))) {
      return false;
    }

    return true;
  }

  private function request_has_valid_thank_you_membership_id($req) {
    // If this is an invalid membership then let's bail, yo
    $membership = new MeprProduct($req['membership_id']);
    if( !$membership || empty($membership->ID) ) {
      return false;
    }

    return true;
  }

  private function request_has_valid_thank_you_trans_num($req) {
    // If this is an invalid transaction then let's bail, yo
    $transaction = $this->get_transaction_from_request($req);

    return !empty($transaction);
  }

  private function request_has_valid_thank_you_membership($atts, $req) {
    $membership = new MeprProduct($req['membership_id']);
    $transaction = $this->get_transaction_from_request($req);

    // If this transaction doesn't match the membership then something fishy is going on here bro
    if(empty($transaction) || $transaction->product_id != $membership->ID) {
      return false;
    }

    // If the shortcode is tied to a specific membership then only show
    // it when this is the thank you page for the specified membership
    if( !is_null($atts['membership']) && isset($req['membership_id']) &&
        $req['membership_id'] != $atts['membership'] ) {
      return false;
    }

    return true;
  }

  private function get_transaction_from_request($req) {
    if(isset($req['trans_num'])) {
      return MeprTransaction::get_one_by_trans_num($req['trans_num']);
    }
    elseif(isset($req['transaction_id'])) {
      return MeprTransaction::get_one((int) $req['transaction_id']);
    }

    return false;
  }

  /**
   * Prepare transaction variables
   *
   * Instantiates and returns a new transaction and subscription (if recurring), based on the given parameters.
   *
   * @param MeprProduct      $product    The product being purchased
   * @param int              $order_id   The order ID
   * @param int              $user_id    The user ID
   * @param string           $gateway_id The payment gateway ID
   * @param MeprCoupon|false $cpn        Optional coupon code
   * @param bool             $store      Whether to store the transaction & subscription, default true
   * @return array{0: MeprTransaction, 1: MeprSubscription|null}
   * @throws Exception If unable to store a transaction or subscription
   */
  public static function prepare_transaction(MeprProduct $product, $order_id, $user_id, $gateway_id, $cpn = false, $store = true) {
    $txn = new MeprTransaction();
    $txn->order_id = $order_id;
    $txn->user_id = $user_id;
    $txn->gateway = $gateway_id;
    $txn->product_id = $product->ID;
    $txn->coupon_id = 0;

    // Set default price, adjust it later if coupon applies
    $price = $product->adjusted_price();

    // Adjust membership price from the coupon code
    if($cpn instanceof MeprCoupon) {
      $price = $product->adjusted_price($cpn->post_title);
      $txn->coupon_id = $cpn->ID;
    }

    $txn->set_subtotal($price);

    if($product->is_one_time_payment()) {
      $sub = null;
    }
    else {
      $sub = new MeprSubscription();
      $sub->order_id = $order_id;
      $sub->user_id = $user_id;
      $sub->gateway = $gateway_id;
      $sub->load_product_vars($product, $cpn instanceof MeprCoupon ? $cpn->post_title : null, true);
      $sub->maybe_prorate(); // sub to sub
    }

    if($store) {
      if($sub instanceof MeprSubscription) {
        $sub->store();

        if(empty($sub->id)) {
          throw new Exception(__('Sorry, we were unable to create a subscription.', 'memberpress'));
        }

        $txn->subscription_id = $sub->id;
      }

      $txn->store();

      if(empty($txn->id)) {
        // Don't want any loose ends here if the transaction didn't save for some reason
        if($sub instanceof MeprSubscription) {
          $sub->destroy();
        }

        throw new Exception(__('Sorry, we were unable to create a transaction.', 'memberpress'));
      }
    }

    return [$txn, $sub];
  }

  /**
   * Get order bump products
   *
   * Gets an array that is filled with a MeprProduct for each order bump in the $_POST data.
   *
   * @param int $product_id The main product for the purchase, order bumps with this ID will be ignored
   * @return MeprProduct[]
   * @throws Exception If a product was not found
   */
  public static function get_order_bump_products($product_id, array $order_bump_product_ids) {
    $order_bump_products = [];

    foreach($order_bump_product_ids as $order_bump_product_id) {
      $product = new MeprProduct($order_bump_product_id);

      if(empty($product->ID)) {
        throw new Exception(__('Product not found', 'memberpress'));
      }

      if($product_id == $product->ID) {
        continue;
      }

      if(!$product->can_you_buy_me()) {
        throw new Exception(sprintf(__("You don't have access to purchase %s.", 'memberpress'), $product->post_title));
      }

      $group = $product->group();

      if($group instanceof MeprGroup && $group->is_upgrade_path) {
        throw new Exception(sprintf(__("The product %s cannot be purchased at this time.", 'memberpress'), $product->post_title));
      }

      $order_bump_products[] = $product;
    }

    return $order_bump_products;
  }
}
