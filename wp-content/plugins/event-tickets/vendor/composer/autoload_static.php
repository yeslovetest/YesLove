<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit96fc994de9cf730d1350642ff0270d94
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tribe\\Tickets\\' => 14,
            'TEC\\Tickets\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tribe\\Tickets\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Tribe',
        ),
        'TEC\\Tickets\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Tickets',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'TEC\\Tickets\\Admin\\Glance_Items' => __DIR__ . '/../..' . '/src/Tickets/Admin/Glance_Items.php',
        'TEC\\Tickets\\Admin\\Hooks' => __DIR__ . '/../..' . '/src/Tickets/Admin/Hooks.php',
        'TEC\\Tickets\\Admin\\Plugin_Action_Links' => __DIR__ . '/../..' . '/src/Tickets/Admin/Plugin_Action_Links.php',
        'TEC\\Tickets\\Admin\\Provider' => __DIR__ . '/../..' . '/src/Tickets/Admin/Provider.php',
        'TEC\\Tickets\\Admin\\Upsell' => __DIR__ . '/../..' . '/src/Tickets/Admin/Upsell.php',
        'TEC\\Tickets\\Assets' => __DIR__ . '/../..' . '/src/Tickets/Assets.php',
        'TEC\\Tickets\\Commerce' => __DIR__ . '/../..' . '/src/Tickets/Commerce.php',
        'TEC\\Tickets\\Commerce\\Abstract_Order' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Abstract_Order.php',
        'TEC\\Tickets\\Commerce\\Admin\\Featured_Settings' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Admin/Featured_Settings.php',
        'TEC\\Tickets\\Commerce\\Admin\\Notices' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Admin/Notices.php',
        'TEC\\Tickets\\Commerce\\Admin_Tables\\Attendees' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Admin_Tables/Attendees.php',
        'TEC\\Tickets\\Commerce\\Admin_Tables\\Orders' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Admin_Tables/Orders.php',
        'TEC\\Tickets\\Commerce\\Assets' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Assets.php',
        'TEC\\Tickets\\Commerce\\Attendee' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Attendee.php',
        'TEC\\Tickets\\Commerce\\Cart' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Cart.php',
        'TEC\\Tickets\\Commerce\\Cart\\Cart_Interface' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Cart/Cart_Interface.php',
        'TEC\\Tickets\\Commerce\\Cart\\Unmanaged_Cart' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Cart/Unmanaged_Cart.php',
        'TEC\\Tickets\\Commerce\\Checkout' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Checkout.php',
        'TEC\\Tickets\\Commerce\\Communication\\Email' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Communication/Email.php',
        'TEC\\Tickets\\Commerce\\Compatibility\\Events' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Compatibility/Events.php',
        'TEC\\Tickets\\Commerce\\Editor\\Metabox' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Editor/Metabox.php',
        'TEC\\Tickets\\Commerce\\Flag_Actions\\Archive_Attendees' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Flag_Actions/Archive_Attendees.php',
        'TEC\\Tickets\\Commerce\\Flag_Actions\\Backfill_Purchaser' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Flag_Actions/Backfill_Purchaser.php',
        'TEC\\Tickets\\Commerce\\Flag_Actions\\Decrease_Sales' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Flag_Actions/Decrease_Sales.php',
        'TEC\\Tickets\\Commerce\\Flag_Actions\\Decrease_Stock' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Flag_Actions/Decrease_Stock.php',
        'TEC\\Tickets\\Commerce\\Flag_Actions\\End_Duplicated_Pending_Orders' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Flag_Actions/End_Duplicated_Pending_Orders.php',
        'TEC\\Tickets\\Commerce\\Flag_Actions\\Flag_Action_Abstract' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Flag_Actions/Flag_Action_Abstract.php',
        'TEC\\Tickets\\Commerce\\Flag_Actions\\Flag_Action_Handler' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Flag_Actions/Flag_Action_Handler.php',
        'TEC\\Tickets\\Commerce\\Flag_Actions\\Flag_Action_Interface' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Flag_Actions/Flag_Action_Interface.php',
        'TEC\\Tickets\\Commerce\\Flag_Actions\\Generate_Attendees' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Flag_Actions/Generate_Attendees.php',
        'TEC\\Tickets\\Commerce\\Flag_Actions\\Increase_Sales' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Flag_Actions/Increase_Sales.php',
        'TEC\\Tickets\\Commerce\\Flag_Actions\\Increase_Stock' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Flag_Actions/Increase_Stock.php',
        'TEC\\Tickets\\Commerce\\Flag_Actions\\Send_Email' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Flag_Actions/Send_Email.php',
        'TEC\\Tickets\\Commerce\\Flag_Actions\\Send_Email_Completed_Order' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Flag_Actions/Send_Email_Completed_Order.php',
        'TEC\\Tickets\\Commerce\\Flag_Actions\\Send_Email_Purchase_Receipt' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Flag_Actions/Send_Email_Purchase_Receipt.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\Abstract_Gateway' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/Abstract_Gateway.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\Abstract_Merchant' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/Abstract_Merchant.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\Abstract_REST_Endpoint' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/Abstract_REST_Endpoint.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\Abstract_Requests' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/Abstract_Requests.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\Abstract_Settings' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/Abstract_Settings.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\Abstract_Signup' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/Abstract_Signup.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\Abstract_Webhooks' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/Abstract_Webhooks.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\Abstract_WhoDat' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/Abstract_WhoDat.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\Gateway_Interface' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/Gateway_Interface.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\Merchant_Interface' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/Merchant_Interface.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\REST_Endpoint_Interface' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/REST_Endpoint_Interface.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\Requests_Interface' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/Requests_Interface.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\Signup_Interface' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/Signup_Interface.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\Webhook_Event_Interface' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/Webhook_Event_Interface.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Contracts\\WhoDat_Interface' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Contracts/WhoDat_Interface.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Manager' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Manager.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Manual\\Assets' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Manual/Assets.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Manual\\Gateway' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Manual/Gateway.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Manual\\Hooks' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Manual/Hooks.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Manual\\Order' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Manual/Order.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Manual\\Provider' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Manual/Provider.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Assets' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Assets.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Buttons' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Buttons.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Client' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Client.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Gateway' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Gateway.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Hooks' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Hooks.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Location\\Country' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Location/Country.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Merchant' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Merchant.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Order' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Order.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Provider' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Provider.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\REST' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/REST.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\REST\\On_Boarding_Endpoint' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/REST/On_Boarding_Endpoint.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\REST\\Order_Endpoint' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/REST/Order_Endpoint.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\REST\\Webhook_Endpoint' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/REST/Webhook_Endpoint.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Refresh_Token' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Refresh_Token.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Settings' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Settings.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Signup' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Signup.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Status' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Status.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Tickets_Form' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Tickets_Form.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Webhooks' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Webhooks.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Webhooks\\Events' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Webhooks/Events.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\Webhooks\\Handler' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/Webhooks/Handler.php',
        'TEC\\Tickets\\Commerce\\Gateways\\PayPal\\WhoDat' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/PayPal/WhoDat.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Application_Fee' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Application_Fee.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Assets' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Assets.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Gateway' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Gateway.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Hooks' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Hooks.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Merchant' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Merchant.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Order' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Order.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Payment_Intent' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Payment_Intent.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Payment_Intent_Handler' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Payment_Intent_Handler.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Provider' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Provider.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\REST' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/REST.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\REST\\Order_Endpoint' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/REST/Order_Endpoint.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\REST\\Return_Endpoint' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/REST/Return_Endpoint.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\REST\\Webhook_Endpoint' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/REST/Webhook_Endpoint.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Requests' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Requests.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Settings' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Settings.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Signup' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Signup.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Status' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Status.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Stripe_Elements' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Stripe_Elements.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Webhooks' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Webhooks.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Webhooks\\Account_Webhook' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Webhooks/Account_Webhook.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Webhooks\\Charge_Webhook' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Webhooks/Charge_Webhook.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Webhooks\\Events' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Webhooks/Events.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Webhooks\\Handler' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Webhooks/Handler.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\Webhooks\\Payment_Intent_Webhook' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/Webhooks/Payment_Intent_Webhook.php',
        'TEC\\Tickets\\Commerce\\Gateways\\Stripe\\WhoDat' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Gateways/Stripe/WhoDat.php',
        'TEC\\Tickets\\Commerce\\Hooks' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Hooks.php',
        'TEC\\Tickets\\Commerce\\Legacy_Compat' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Legacy_Compat.php',
        'TEC\\Tickets\\Commerce\\Models\\Attendee_Model' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Models/Attendee_Model.php',
        'TEC\\Tickets\\Commerce\\Models\\Order_Model' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Models/Order_Model.php',
        'TEC\\Tickets\\Commerce\\Models\\Ticket_Model' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Models/Ticket_Model.php',
        'TEC\\Tickets\\Commerce\\Module' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Module.php',
        'TEC\\Tickets\\Commerce\\Notice_Handler' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Notice_Handler.php',
        'TEC\\Tickets\\Commerce\\Order' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Order.php',
        'TEC\\Tickets\\Commerce\\Payments_Tab' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Payments_Tab.php',
        'TEC\\Tickets\\Commerce\\Promoter_Observer' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Promoter_Observer.php',
        'TEC\\Tickets\\Commerce\\Provider' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Provider.php',
        'TEC\\Tickets\\Commerce\\Reports\\Attendance_Totals' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Reports/Attendance_Totals.php',
        'TEC\\Tickets\\Commerce\\Reports\\Attendees' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Reports/Attendees.php',
        'TEC\\Tickets\\Commerce\\Reports\\Attendees_Tab' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Reports/Attendees_Tab.php',
        'TEC\\Tickets\\Commerce\\Reports\\Data\\Order_Summary' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Reports/Data/Order_Summary.php',
        'TEC\\Tickets\\Commerce\\Reports\\Orders' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Reports/Orders.php',
        'TEC\\Tickets\\Commerce\\Reports\\Orders_Tab' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Reports/Orders_Tab.php',
        'TEC\\Tickets\\Commerce\\Reports\\Report_Abstract' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Reports/Report_Abstract.php',
        'TEC\\Tickets\\Commerce\\Reports\\Tabbed_View' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Reports/Tabbed_View.php',
        'TEC\\Tickets\\Commerce\\Repositories\\Attendees_Repository' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Repositories/Attendees_Repository.php',
        'TEC\\Tickets\\Commerce\\Repositories\\Order_Repository' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Repositories/Order_Repository.php',
        'TEC\\Tickets\\Commerce\\Repositories\\Tickets_Repository' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Repositories/Tickets_Repository.php',
        'TEC\\Tickets\\Commerce\\Settings' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Settings.php',
        'TEC\\Tickets\\Commerce\\Shortcodes\\Checkout_Shortcode' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Shortcodes/Checkout_Shortcode.php',
        'TEC\\Tickets\\Commerce\\Shortcodes\\Shortcode_Abstract' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Shortcodes/Shortcode_Abstract.php',
        'TEC\\Tickets\\Commerce\\Shortcodes\\Success_Shortcode' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Shortcodes/Success_Shortcode.php',
        'TEC\\Tickets\\Commerce\\Status\\Action_Required' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Status/Action_Required.php',
        'TEC\\Tickets\\Commerce\\Status\\Approved' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Status/Approved.php',
        'TEC\\Tickets\\Commerce\\Status\\Completed' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Status/Completed.php',
        'TEC\\Tickets\\Commerce\\Status\\Created' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Status/Created.php',
        'TEC\\Tickets\\Commerce\\Status\\Denied' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Status/Denied.php',
        'TEC\\Tickets\\Commerce\\Status\\Not_Completed' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Status/Not_Completed.php',
        'TEC\\Tickets\\Commerce\\Status\\Pending' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Status/Pending.php',
        'TEC\\Tickets\\Commerce\\Status\\Refunded' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Status/Refunded.php',
        'TEC\\Tickets\\Commerce\\Status\\Reversed' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Status/Reversed.php',
        'TEC\\Tickets\\Commerce\\Status\\Status_Abstract' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Status/Status_Abstract.php',
        'TEC\\Tickets\\Commerce\\Status\\Status_Handler' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Status/Status_Handler.php',
        'TEC\\Tickets\\Commerce\\Status\\Status_Interface' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Status/Status_Interface.php',
        'TEC\\Tickets\\Commerce\\Status\\Undefined' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Status/Undefined.php',
        'TEC\\Tickets\\Commerce\\Status\\Voided' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Status/Voided.php',
        'TEC\\Tickets\\Commerce\\Success' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Success.php',
        'TEC\\Tickets\\Commerce\\Ticket' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Ticket.php',
        'TEC\\Tickets\\Commerce\\Tickets_View' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Tickets_View.php',
        'TEC\\Tickets\\Commerce\\Traits\\Has_Mode' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Traits/Has_Mode.php',
        'TEC\\Tickets\\Commerce\\Utils\\Currency' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Utils/Currency.php',
        'TEC\\Tickets\\Commerce\\Utils\\Value' => __DIR__ . '/../..' . '/src/Tickets/Commerce/Utils/Value.php',
        'TEC\\Tickets\\Custom_Tables\\V1\\Migration\\Maintenance_Mode\\Maintenance_Mode' => __DIR__ . '/../..' . '/src/Tickets/Custom_Tables/V1/Migration/Maintenance_Mode/Maintenance_Mode.php',
        'TEC\\Tickets\\Custom_Tables\\V1\\Migration\\Maintenance_Mode\\Provider' => __DIR__ . '/../..' . '/src/Tickets/Custom_Tables/V1/Migration/Maintenance_Mode/Provider.php',
        'TEC\\Tickets\\Custom_Tables\\V1\\Provider' => __DIR__ . '/../..' . '/src/Tickets/Custom_Tables/V1/Provider.php',
        'TEC\\Tickets\\Emails\\Admin\\Emails_Tab' => __DIR__ . '/../..' . '/src/Tickets/Emails/Admin/Emails_Tab.php',
        'TEC\\Tickets\\Emails\\Admin\\Notice_Extension' => __DIR__ . '/../..' . '/src/Tickets/Emails/Admin/Notice_Extension.php',
        'TEC\\Tickets\\Emails\\Admin\\Notice_Upgrade' => __DIR__ . '/../..' . '/src/Tickets/Emails/Admin/Notice_Upgrade.php',
        'TEC\\Tickets\\Emails\\Admin\\Preview_Data' => __DIR__ . '/../..' . '/src/Tickets/Emails/Admin/Preview_Data.php',
        'TEC\\Tickets\\Emails\\Admin\\Preview_Modal' => __DIR__ . '/../..' . '/src/Tickets/Emails/Admin/Preview_Modal.php',
        'TEC\\Tickets\\Emails\\Admin\\Settings' => __DIR__ . '/../..' . '/src/Tickets/Emails/Admin/Settings.php',
        'TEC\\Tickets\\Emails\\Assets' => __DIR__ . '/../..' . '/src/Tickets/Emails/Assets.php',
        'TEC\\Tickets\\Emails\\Dispatcher' => __DIR__ . '/../..' . '/src/Tickets/Emails/Dispatcher.php',
        'TEC\\Tickets\\Emails\\Email\\Completed_Order' => __DIR__ . '/../..' . '/src/Tickets/Emails/Email/Completed_Order.php',
        'TEC\\Tickets\\Emails\\Email\\Purchase_Receipt' => __DIR__ . '/../..' . '/src/Tickets/Emails/Email/Purchase_Receipt.php',
        'TEC\\Tickets\\Emails\\Email\\RSVP' => __DIR__ . '/../..' . '/src/Tickets/Emails/Email/RSVP.php',
        'TEC\\Tickets\\Emails\\Email\\RSVP_Not_Going' => __DIR__ . '/../..' . '/src/Tickets/Emails/Email/RSVP_Not_Going.php',
        'TEC\\Tickets\\Emails\\Email\\Ticket' => __DIR__ . '/../..' . '/src/Tickets/Emails/Email/Ticket.php',
        'TEC\\Tickets\\Emails\\Email_Abstract' => __DIR__ . '/../..' . '/src/Tickets/Emails/Email_Abstract.php',
        'TEC\\Tickets\\Emails\\Email_Handler' => __DIR__ . '/../..' . '/src/Tickets/Emails/Email_Handler.php',
        'TEC\\Tickets\\Emails\\Email_Template' => __DIR__ . '/../..' . '/src/Tickets/Emails/Email_Template.php',
        'TEC\\Tickets\\Emails\\Hooks' => __DIR__ . '/../..' . '/src/Tickets/Emails/Hooks.php',
        'TEC\\Tickets\\Emails\\JSON_LD\\Event_Schema' => __DIR__ . '/../..' . '/src/Tickets/Emails/JSON_LD/Event_Schema.php',
        'TEC\\Tickets\\Emails\\JSON_LD\\JSON_LD_Abstract' => __DIR__ . '/../..' . '/src/Tickets/Emails/JSON_LD/JSON_LD_Abstract.php',
        'TEC\\Tickets\\Emails\\JSON_LD\\Order_Schema' => __DIR__ . '/../..' . '/src/Tickets/Emails/JSON_LD/Order_Schema.php',
        'TEC\\Tickets\\Emails\\JSON_LD\\Preview_Schema' => __DIR__ . '/../..' . '/src/Tickets/Emails/JSON_LD/Preview_Schema.php',
        'TEC\\Tickets\\Emails\\JSON_LD\\Reservation_Schema' => __DIR__ . '/../..' . '/src/Tickets/Emails/JSON_LD/Reservation_Schema.php',
        'TEC\\Tickets\\Emails\\Legacy_Hijack' => __DIR__ . '/../..' . '/src/Tickets/Emails/Legacy_Hijack.php',
        'TEC\\Tickets\\Emails\\Provider' => __DIR__ . '/../..' . '/src/Tickets/Emails/Provider.php',
        'TEC\\Tickets\\Emails\\Web_View' => __DIR__ . '/../..' . '/src/Tickets/Emails/Web_View.php',
        'TEC\\Tickets\\Event' => __DIR__ . '/../..' . '/src/Tickets/Event.php',
        'TEC\\Tickets\\Hooks' => __DIR__ . '/../..' . '/src/Tickets/Hooks.php',
        'TEC\\Tickets\\Integrations\\Integration_Abstract' => __DIR__ . '/../..' . '/src/Tickets/Integrations/Integration_Abstract.php',
        'TEC\\Tickets\\Integrations\\Plugins\\Yoast_Duplicate_Post\\Duplicate_Post' => __DIR__ . '/../..' . '/src/Tickets/Integrations/Plugins/Yoast_Duplicate_Post/Duplicate_Post.php',
        'TEC\\Tickets\\Integrations\\Provider' => __DIR__ . '/../..' . '/src/Tickets/Integrations/Provider.php',
        'TEC\\Tickets\\Integrations\\Themes\\Divi\\Provider' => __DIR__ . '/../..' . '/src/Tickets/Integrations/Themes/Divi/Provider.php',
        'TEC\\Tickets\\Provider' => __DIR__ . '/../..' . '/src/Tickets/Provider.php',
        'TEC\\Tickets\\QR\\Connector' => __DIR__ . '/../..' . '/src/Tickets/QR/Connector.php',
        'TEC\\Tickets\\QR\\Controller' => __DIR__ . '/../..' . '/src/Tickets/QR/Controller.php',
        'TEC\\Tickets\\QR\\Notices' => __DIR__ . '/../..' . '/src/Tickets/QR/Notices.php',
        'TEC\\Tickets\\QR\\Observer' => __DIR__ . '/../..' . '/src/Tickets/QR/Observer.php',
        'TEC\\Tickets\\QR\\QR' => __DIR__ . '/../..' . '/src/Tickets/QR/QR.php',
        'TEC\\Tickets\\QR\\Settings' => __DIR__ . '/../..' . '/src/Tickets/QR/Settings.php',
        'TEC\\Tickets\\Recurrence\\Compatibility' => __DIR__ . '/../..' . '/src/Tickets/Recurrence/Compatibility.php',
        'TEC\\Tickets\\Recurrence\\Hooks' => __DIR__ . '/../..' . '/src/Tickets/Recurrence/Hooks.php',
        'TEC\\Tickets\\Recurrence\\Provider' => __DIR__ . '/../..' . '/src/Tickets/Recurrence/Provider.php',
        'TEC\\Tickets\\Settings' => __DIR__ . '/../..' . '/src/Tickets/Settings.php',
        'TEC\\Tickets\\Site_Health\\Info_Section' => __DIR__ . '/../..' . '/src/Tickets/Site_Health/Info_Section.php',
        'TEC\\Tickets\\Site_Health\\Provider' => __DIR__ . '/../..' . '/src/Tickets/Site_Health/Provider.php',
        'TEC\\Tickets\\Telemetry\\Provider' => __DIR__ . '/../..' . '/src/Tickets/Telemetry/Provider.php',
        'TEC\\Tickets\\Telemetry\\Telemetry' => __DIR__ . '/../..' . '/src/Tickets/Telemetry/Telemetry.php',
        'TEC\\Tickets\\Ticket_Cache_Controller' => __DIR__ . '/../..' . '/src/Tickets/Ticket_Cache_Controller.php',
        'Tribe\\Tickets\\Admin\\Home\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Admin/Home/Service_Provider.php',
        'Tribe\\Tickets\\Admin\\Manager\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Admin/Manager/Service_Provider.php',
        'Tribe\\Tickets\\Admin\\Provider' => __DIR__ . '/../..' . '/src/Tribe/Admin/Provider.php',
        'Tribe\\Tickets\\Admin\\Settings' => __DIR__ . '/../..' . '/src/Tribe/Admin/Settings.php',
        'Tribe\\Tickets\\Admin\\Settings\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Admin/Settings/Service_Provider.php',
        'Tribe\\Tickets\\Editor\\Warnings' => __DIR__ . '/../..' . '/src/Tribe/Editor/Warnings.php',
        'Tribe\\Tickets\\Events\\Attendees_List' => __DIR__ . '/../..' . '/src/Tribe/Events/Attendees_List.php',
        'Tribe\\Tickets\\Events\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Events/Service_Provider.php',
        'Tribe\\Tickets\\Events\\Views\\V2\\Hooks' => __DIR__ . '/../..' . '/src/Tribe/Events/Views/V2/Hooks.php',
        'Tribe\\Tickets\\Events\\Views\\V2\\Models\\Tickets' => __DIR__ . '/../..' . '/src/Tribe/Events/Views/V2/Models/Tickets.php',
        'Tribe\\Tickets\\Events\\Views\\V2\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Events/Views/V2/Service_Provider.php',
        'Tribe\\Tickets\\Migration\\Queue' => __DIR__ . '/../..' . '/src/Tribe/Migration/Queue.php',
        'Tribe\\Tickets\\Migration\\Queue_4_12' => __DIR__ . '/../..' . '/src/Tribe/Migration/Queue_4_12.php',
        'Tribe\\Tickets\\Promoter\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Promoter/Service_Provider.php',
        'Tribe\\Tickets\\Promoter\\Triggers\\Builders\\Attendee_Trigger' => __DIR__ . '/../..' . '/src/Tribe/Promoter/Triggers/Builders/Attendee_Trigger.php',
        'Tribe\\Tickets\\Promoter\\Triggers\\Contracts\\Attendee_Model' => __DIR__ . '/../..' . '/src/Tribe/Promoter/Triggers/Contracts/Attendee_Model.php',
        'Tribe\\Tickets\\Promoter\\Triggers\\Contracts\\Builder' => __DIR__ . '/../..' . '/src/Tribe/Promoter/Triggers/Contracts/Builder.php',
        'Tribe\\Tickets\\Promoter\\Triggers\\Contracts\\Triggered' => __DIR__ . '/../..' . '/src/Tribe/Promoter/Triggers/Contracts/Triggered.php',
        'Tribe\\Tickets\\Promoter\\Triggers\\Director' => __DIR__ . '/../..' . '/src/Tribe/Promoter/Triggers/Director.php',
        'Tribe\\Tickets\\Promoter\\Triggers\\Dispatcher' => __DIR__ . '/../..' . '/src/Tribe/Promoter/Triggers/Dispatcher.php',
        'Tribe\\Tickets\\Promoter\\Triggers\\Factory' => __DIR__ . '/../..' . '/src/Tribe/Promoter/Triggers/Factory.php',
        'Tribe\\Tickets\\Promoter\\Triggers\\Models\\Attendee' => __DIR__ . '/../..' . '/src/Tribe/Promoter/Triggers/Models/Attendee.php',
        'Tribe\\Tickets\\Promoter\\Triggers\\Observers\\Commerce' => __DIR__ . '/../..' . '/src/Tribe/Promoter/Triggers/Observers/Commerce.php',
        'Tribe\\Tickets\\Promoter\\Triggers\\Observers\\RSVP' => __DIR__ . '/../..' . '/src/Tribe/Promoter/Triggers/Observers/RSVP.php',
        'Tribe\\Tickets\\Repositories\\Order' => __DIR__ . '/../..' . '/src/Tribe/Repositories/Order.php',
        'Tribe\\Tickets\\Repositories\\Order\\Commerce' => __DIR__ . '/../..' . '/src/Tribe/Repositories/Order/Commerce.php',
        'Tribe\\Tickets\\Repositories\\Post_Repository' => __DIR__ . '/../..' . '/src/Tribe/Repositories/Post_Repository.php',
        'Tribe\\Tickets\\Repositories\\Traits\\Event' => __DIR__ . '/../..' . '/src/Tribe/Repositories/Traits/Event.php',
        'Tribe\\Tickets\\Repositories\\Traits\\Post_Attendees' => __DIR__ . '/../..' . '/src/Tribe/Repositories/Traits/Post_Attendees.php',
        'Tribe\\Tickets\\Repositories\\Traits\\Post_Tickets' => __DIR__ . '/../..' . '/src/Tribe/Repositories/Traits/Post_Tickets.php',
        'Tribe\\Tickets\\Service_Providers\\Customizer' => __DIR__ . '/../..' . '/src/Tribe/Service_Providers/Customizer.php',
        'Tribe\\Tickets\\Shortcodes\\Tribe_Tickets_Checkout' => __DIR__ . '/../..' . '/src/Tribe/Shortcodes/Tribe_Tickets_Checkout.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit96fc994de9cf730d1350642ff0270d94::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit96fc994de9cf730d1350642ff0270d94::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit96fc994de9cf730d1350642ff0270d94::$classMap;

        }, null, ClassLoader::class);
    }
}
