<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\Helper;

require_once CIRKLE_THEME_INC_DIR . 'utils/translations.php';
require_once CIRKLE_THEME_INC_DIR . 'utils/Cirkle_Scheduler.php';
require_once CIRKLE_THEME_INC_DIR . 'utils/Cirkle_Task.php';
require_once CIRKLE_THEME_INC_DIR . 'ajax/CirkleAjaxActivity.php';
require_once CIRKLE_THEME_INC_DIR . 'ajax/CirkleAjaxMember.php';
require_once CIRKLE_THEME_INC_DIR . 'helper-traits/friends.php';
require_once CIRKLE_THEME_INC_DIR . 'helper-traits/group.php';
require_once CIRKLE_THEME_INC_DIR . 'helper-traits/activity.php';
// require_once CIRKLE_THEME_INC_DIR . 'helper-traits/lc-helper.php';
require_once CIRKLE_THEME_INC_DIR . 'helper-traits/gamipress.php';
require_once CIRKLE_THEME_INC_DIR . 'helper-traits/layout-trait.php';
require_once CIRKLE_THEME_INC_DIR . 'helper-traits/data-trait.php';
require_once CIRKLE_THEME_INC_DIR . 'helper-traits/resource-load-trait.php';
require_once CIRKLE_THEME_INC_DIR . 'helper-traits/custom-query-trait.php';
require_once CIRKLE_THEME_INC_DIR . 'helper-traits/icon-trait.php';
require_once CIRKLE_THEME_INC_DIR . 'helper-traits/socials-share.php';
require_once CIRKLE_THEME_INC_DIR . 'helper-traits/member-data.php';
require_once CIRKLE_THEME_INC_DIR . 'helper-traits/member-activity.php';
// require_once CIRKLE_THEME_INC_DIR . 'helper-traits/lc-utility.php';
require_once CIRKLE_THEME_INC_DIR . 'helper.php';


//Ajax Hook init

Helper::requires('class-tgm-plugin-activation.php');
Helper::requires('custom-header.php');
Helper::requires('tgm-config.php');
Helper::requires('general.php');
Helper::requires('buddypress.php');
Helper::requires('scripts.php');
Helper::requires('layout-settings.php');

Helper::requires('customizer/customizer-default-data.php');
Helper::requires('customizer/init.php');
Helper::requires('rdtheme.php');
if (class_exists('WooCommerce')) {
    Helper::requires('custom/functions.php', 'woocommerce');
}