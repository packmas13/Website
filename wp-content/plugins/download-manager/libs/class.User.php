<?php
/**
 * Created by PhpStorm.
 * User: shahnuralam
 * Date: 6/24/18
 * Time: 10:39 PM
 */

namespace WPDM\libs;


use WPDM\Form;

if( ! class_exists( 'User' ) ):

    class User{

        public static $instance;

        public static function instance(){
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        function __construct()
        {

        }

        static function signupForm(){
            $reg_data_fields['name'] = array(
                'cols' => array(
                    array('label' => __( "First name", "download-manager" ), 'type' => 'text', 'grid_class' => 'col-md-6 col-sm-12', 'attrs' => array( 'name' => 'first', 'id' => 'first_name' )),
                    array('label' => __( "Last name", "download-manager" ), 'type' => 'text', 'grid_class' => 'col-md-6 col-sm-12', 'attrs' => array( 'name' => 'last', 'id' => 'last_name'))
                )
            );
            $reg_data_fields['email'] = array(
                'label' => __( "Email", "download-manager" ),
                'type'  => 'email',
                'attrs' => array( 'name' => 'email', 'id' => 'email')
            );
            $reg_data_fields['password'] = array(
                'cols' => array(
                    'pass' => array('label' => __( "Password", "download-manager" ), 'type' => 'text', 'grid_class' => 'col-md-6 col-sm-12', 'attrs' => array( 'name' => 'password', 'id' => 'password')),
                    'confirm' => array('label' => __( "Confirm Password", "download-manager" ), 'type' => 'text', 'grid_class' => 'col-md-6 col-sm-12', 'attrs' => array( 'confirm' => 'last', 'id' => 'confirm_pass'))
                )
            );

            $form = new Form($reg_data_fields, array('name' => 'wpdm_reg_form', 'id' => 'wpdm_reg_form', 'method' => 'POST', 'action' => ''));
            return $form->render();

        }


        function modalLoginForm($params = array()){

            global $current_user;

            if(!isset($params) || !is_array($params)) $params = array();

            if(isset($params) && is_array($params))
                extract($params);
            if(!isset($redirect)) $redirect = get_permalink(get_option('__wpdm_user_dashboard'));

            if(!isset($regurl)) {
                $regurl = get_option('__wpdm_register_url');
                if ($regurl > 0)
                    $regurl = get_permalink($regurl);
            }
            $log_redirect =  $_SERVER['REQUEST_URI'];
            if(isset($params['redirect'])) $log_redirect = esc_url($params['redirect']);
            if(isset($_GET['redirect_to'])) $log_redirect = esc_url($_GET['redirect_to']);

            $up = parse_url($log_redirect);
            if(isset($up['host']) && $up['host'] != $_SERVER['SERVER_NAME']) $log_redirect = $_SERVER['REQUEST_URI'];

            $log_redirect = strip_tags($log_redirect);

            if(!isset($params['logo']) || $params['logo'] == '') $params['logo'] = get_site_icon_url();

            $__wpdm_social_login = get_option('__wpdm_social_login');
            $__wpdm_social_login = is_array($__wpdm_social_login)?$__wpdm_social_login:array();

            ob_start();
            //get_option('__wpdm_modal_login', 0)

            include( wpdm_tpl_path('wpdm-login-modal-form.php') );

            $content =  ob_get_clean();
            $content = apply_filters("wpdm_login_modal_form_html", $content);

            return $content;
        }

    }

//echo User::signupForm();

endif;

