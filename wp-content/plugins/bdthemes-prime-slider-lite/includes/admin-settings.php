<?php

use  PrimeSlider\Notices ;
use  Elementor\Settings ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
/**
 * Prime Slider Admin Settings Class
 */
class PrimeSlider_Admin_Settings
{
    const  PAGE_ID = 'prime_slider_options' ;
    private  $settings_api ;
    public  $responseObj ;
    public  $licenseMessage ;
    public  $showMessage = false ;
    public  $slug = "prime_slider_options" ;
    private  $is_activated = false ;
    function __construct()
    {
        $this->settings_api = new PrimeSlider_Settings_API();
        
        if ( !defined( 'BDTPS_HIDE' ) ) {
            add_action( 'admin_init', [ $this, 'admin_init' ] );
            add_action( 'admin_menu', [ $this, 'admin_menu' ], 201 );
        }
    
    }
    
    public static function get_url()
    {
        return admin_url( 'admin.php?page=' . self::PAGE_ID );
    }
    
    function admin_init()
    {
        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->prime_slider_admin_settings() );
        //initialize settings
        $this->settings_api->admin_init();
    }
    
    function admin_menu()
    {
        add_menu_page(
            BDTPS_TITLE . ' ' . esc_html__( 'Dashboard', 'bdthemes-prime-slider' ),
            BDTPS_TITLE,
            'manage_options',
            self::PAGE_ID,
            [ $this, 'plugin_page' ],
            $this->prime_slider_icon(),
            58.5
        );
        add_submenu_page(
            self::PAGE_ID,
            BDTPS_TITLE,
            esc_html__( 'Core Widgets', 'bdthemes-prime-slider' ),
            'manage_options',
            self::PAGE_ID . '#widgets',
            [ $this, 'display_page' ]
        );
    }
    
    function prime_slider_icon()
    {
        return 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyMy4wLjMsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAyMzAuNyAyNTQuOCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjMwLjcgMjU0Ljg7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJLnN0MHtmaWxsOnVybCgjU1ZHSURfMV8pO30NCgkuc3Qxe2ZpbGw6dXJsKCNTVkdJRF8yXyk7fQ0KCS5zdDJ7ZmlsbDp1cmwoI1NWR0lEXzNfKTt9DQoJLnN0M3tmaWxsOnVybCgjU1ZHSURfNF8pO30NCgkuc3Q0e2ZpbGw6dXJsKCNTVkdJRF81Xyk7fQ0KPC9zdHlsZT4NCjxnPg0KCTxsaW5lYXJHcmFkaWVudCBpZD0iU1ZHSURfMV8iIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIiB4MT0iMTY1Ljg4MTMiIHkxPSItOS4xNzQyIiB4Mj0iLTE0Ljk3ODMiIHkyPSIxOTIuNzE1NiI+DQoJCTxzdG9wICBvZmZzZXQ9IjAiIHN0eWxlPSJzdG9wLWNvbG9yOiNGQzZBMkMiLz4NCgkJPHN0b3AgIG9mZnNldD0iMSIgc3R5bGU9InN0b3AtY29sb3I6I0ZFNTE2QiIvPg0KCTwvbGluZWFyR3JhZGllbnQ+DQoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTIwMi4yLDY5LjJoLTE3NGMtMywwLTUuNS0yLjUtNS41LTUuNVYzMS4xYzAtMywyLjUtNS41LDUuNS01LjVoMTc0YzMsMCw1LjUsMi41LDUuNSw1LjV2MzIuNg0KCQlDMjA3LjcsNjYuOCwyMDUuMiw2OS4yLDIwMi4yLDY5LjJ6Ii8+DQoJPGxpbmVhckdyYWRpZW50IGlkPSJTVkdJRF8yXyIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiIHgxPSIyMDUuNjI4MSIgeTE9IjI2LjQzMjMiIHgyPSIyNC43Njg1IiB5Mj0iMjI4LjMyMjEiPg0KCQk8c3RvcCAgb2Zmc2V0PSIwIiBzdHlsZT0ic3RvcC1jb2xvcjojRkM2QTJDIi8+DQoJCTxzdG9wICBvZmZzZXQ9IjEiIHN0eWxlPSJzdG9wLWNvbG9yOiNGRTUxNkIiLz4NCgk8L2xpbmVhckdyYWRpZW50Pg0KCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik0yMDIuMiwxNDkuMmgtMTc0Yy0zLDAtNS41LTIuNS01LjUtNS41di0zMi42YzAtMywyLjUtNS41LDUuNS01LjVoMTc0YzMsMCw1LjUsMi41LDUuNSw1LjV2MzIuNg0KCQlDMjA3LjcsMTQ2LjgsMjA1LjIsMTQ5LjIsMjAyLjIsMTQ5LjJ6Ii8+DQoJPGxpbmVhckdyYWRpZW50IGlkPSJTVkdJRF8zXyIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiIHgxPSIyMjMuMDM5IiB5MT0iNDIuMDI5NSIgeDI9IjQyLjE3OTQiIHkyPSIyNDMuOTE5NCI+DQoJCTxzdG9wICBvZmZzZXQ9IjAiIHN0eWxlPSJzdG9wLWNvbG9yOiNGQzZBMkMiLz4NCgkJPHN0b3AgIG9mZnNldD0iMSIgc3R5bGU9InN0b3AtY29sb3I6I0ZFNTE2QiIvPg0KCTwvbGluZWFyR3JhZGllbnQ+DQoJPHBhdGggY2xhc3M9InN0MiIgZD0iTTEyMS42LDIyOS4ySDI4LjJjLTMsMC01LjUtMi41LTUuNS01LjV2LTMyLjZjMC0zLDIuNS01LjUsNS41LTUuNWg5My41YzMsMCw1LjUsMi41LDUuNSw1LjV2MzIuNg0KCQlDMTI3LjIsMjI2LjcsMTI0LjcsMjI5LjIsMTIxLjYsMjI5LjJ6Ii8+DQoJPGxpbmVhckdyYWRpZW50IGlkPSJTVkdJRF80XyIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiIHgxPSIxNDYuMDMzMSIgeTE9Ii0yNi45NTUiIHgyPSItMzQuODI2NiIgeTI9IjE3NC45MzQ4Ij4NCgkJPHN0b3AgIG9mZnNldD0iMCIgc3R5bGU9InN0b3AtY29sb3I6I0ZDNkEyQyIvPg0KCQk8c3RvcCAgb2Zmc2V0PSIxIiBzdHlsZT0ic3RvcC1jb2xvcjojRkU1MTZCIi8+DQoJPC9saW5lYXJHcmFkaWVudD4NCgk8cGF0aCBjbGFzcz0ic3QzIiBkPSJNNjYuMyw0NS43VjEyN2MwLDMtMi41LDUuNS01LjUsNS41SDI4LjJjLTMsMC01LjUtMi41LTUuNS01LjVWNDUuN2MwLTMsMi41LTUuNSw1LjUtNS41aDMyLjYNCgkJQzYzLjgsNDAuMiw2Ni4zLDQyLjcsNjYuMyw0NS43eiIvPg0KCTxsaW5lYXJHcmFkaWVudCBpZD0iU1ZHSURfNV8iIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIiB4MT0iMjY0LjcxMzQiIHkxPSI3OS4zNjI4IiB4Mj0iODMuODUzNyIgeTI9IjI4MS4yNTI2Ij4NCgkJPHN0b3AgIG9mZnNldD0iMCIgc3R5bGU9InN0b3AtY29sb3I6I0ZDNkEyQyIvPg0KCQk8c3RvcCAgb2Zmc2V0PSIxIiBzdHlsZT0ic3RvcC1jb2xvcjojRkU1MTZCIi8+DQoJPC9saW5lYXJHcmFkaWVudD4NCgk8cGF0aCBjbGFzcz0ic3Q0IiBkPSJNMjA3LjcsMTExLjF2MTEyLjZjMCwzLTIuNSw1LjUtNS41LDUuNWgtMzIuNmMtMywwLTUuNS0yLjUtNS41LTUuNVYxMTEuMWMwLTMsMi41LTUuNSw1LjUtNS41aDMyLjYNCgkJQzIwNS4yLDEwNS42LDIwNy43LDEwOCwyMDcuNywxMTEuMXoiLz4NCjwvZz4NCjwvc3ZnPg0K';
    }
    
    function get_settings_sections()
    {
        $sections = [ [
            'id'    => 'prime_slider_active_modules',
            'title' => esc_html__( 'Core Widgets', 'bdthemes-prime-slider' ),
        ] ];
        return $sections;
    }
    
    protected function prime_slider_admin_settings()
    {
        
        if ( ps_is_general_enabled() ) {
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'general',
                'label'        => esc_html__( 'General Base', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'static',
                'demo_url'     => 'https://primeslider.pro/demo/general/',
                'video_url'    => 'https://youtu.be/VMBuGusjvtM',
            ];
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'general_skin_slide',
                'label'        => esc_html__( 'General - Skin Slide', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'static',
                'demo_url'     => 'https://primeslider.pro/demo/general-skin-slide/',
                'video_url'    => 'https://youtu.be/gOiyL6_9vtc',
            ];
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'general_skin_crelly',
                'label'        => esc_html__( 'General - Skin Crelly', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'static',
                'demo_url'     => 'https://primeslider.pro/demo/general-skin-crelly/',
                'video_url'    => 'https://youtu.be/AkuOeqRmIjM',
            ];
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'general_skin_meteor',
                'label'        => esc_html__( 'General - Skin Meteor', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'static',
                'demo_url'     => 'https://primeslider.pro/demo/general-skin-meteor/',
                'video_url'    => 'https://youtu.be/bnW6hw140Vg',
            ];
        }
        
        if ( ps_is_flogia_enabled() ) {
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'flogia',
                'label'        => esc_html__( 'Flogia Base', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'post',
                'demo_url'     => 'https://primeslider.pro/demo/flogia/',
                'video_url'    => 'https://youtu.be/4YaNEk5FbUc',
            ];
        }
        if ( ps_is_dragon_enabled() ) {
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'dragon',
                'label'        => esc_html__( 'Dragon Base', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'custom',
                'demo_url'     => 'https://primeslider.pro/demo/dragon/',
                'video_url'    => 'https://youtu.be/eL0a9f7VEtc',
            ];
        }
        
        if ( ps_is_isolate_enabled() ) {
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'isolate',
                'label'        => esc_html__( 'Isolate Base', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'static',
                'demo_url'     => 'https://primeslider.pro/demo/isolate/',
                'video_url'    => 'https://youtu.be/8wlCWhSMQno',
            ];
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'isolate_skin_locate',
                'label'        => esc_html__( 'Isolate - Skin Locate', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'static',
                'demo_url'     => 'https://primeslider.pro/demo/isolate-skin-locate/',
                'video_url'    => 'https://youtu.be/-HijcVJvTIs',
            ];
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'isolate_skin_slice',
                'label'        => esc_html__( 'Isolate - Skin Slice', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'static',
                'demo_url'     => 'https://primeslider.pro/demo/isolate-skin-slice/',
                'video_url'    => 'https://youtu.be/t0rxBfKY5UQ',
            ];
        }
        
        
        if ( ps_is_blog_enabled() ) {
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'blog',
                'label'        => esc_html__( 'Blog Base', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'post',
                'demo_url'     => 'https://primeslider.pro/demo/blog/',
                'video_url'    => 'https://youtu.be/G32YlydUcHg',
            ];
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'blog_skin_coral',
                'label'        => esc_html__( 'Blog - Skin Coral', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'post',
                'demo_url'     => 'https://primeslider.pro/demo/blog-skin-coral/',
                'video_url'    => 'https://youtu.be/1ggdO2GNAJc',
            ];
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'blog_skin_folio',
                'label'        => esc_html__( 'Blog - Skin Folio', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'post',
                'demo_url'     => 'https://primeslider.pro/demo/blog-skin-folio/',
                'video_url'    => 'https://youtu.be/rqT95tMDK44',
            ];
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'blog_skin_zinest',
                'label'        => esc_html__( 'Blog - Skin Zinest', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'post',
                'demo_url'     => 'https://primeslider.pro/demo/blog-skin-zinest/',
                'video_url'    => 'https://youtu.be/cTAkZU-8CRQ',
            ];
        }
        
        if ( ps_is_woocommerce_enabled() ) {
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'woocommerce',
                'label'        => esc_html__( 'WooCommerce Base', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'ecommerce',
                'demo_url'     => 'https://primeslider.pro/demo/woocommerce/',
                'video_url'    => 'https://youtu.be/6Wkk2EMN2ps',
            ];
        }
        if ( ps_is_woolamp_enabled() ) {
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'woolamp',
                'label'        => esc_html__( 'Woolamp Base', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'ecommerce new',
                'demo_url'     => 'https://primeslider.pro/demo/woolamp/',
                'video_url'    => '',
            ];
        }
        if ( ps_is_multiscroll_enabled() ) {
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'multiscroll',
                'label'        => esc_html__( 'Multiscroll Base', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'free',
                'content_type' => 'static',
                'demo_url'     => 'https://primeslider.pro/demo/multiscroll/',
                'video_url'    => 'https://youtu.be/uzBHDw_mdRE',
            ];
        }
        if ( ps_is_pagepiling_enabled() ) {
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'pagepiling',
                'label'        => esc_html__( 'Pagepiling Base', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "off",
                'widget_type'  => 'free',
                'content_type' => 'static',
                'demo_url'     => 'https://primeslider.pro/demo/pagepiling/',
                'video_url'    => 'https://youtu.be/L7eWKJaZj5I',
            ];
        }
        if ( ps_is_sequester_enabled() ) {
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'sequester',
                'label'        => esc_html__( 'Sequester Base', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "off",
                'widget_type'  => 'free',
                'content_type' => 'static',
                'demo_url'     => 'https://primeslider.pro/demo/sequester/',
                'video_url'    => '',
            ];
        }
        if ( ps_is_mount_enabled() ) {
            $settings_fields['prime_slider_active_modules'][] = [
                'name'         => 'mount',
                'label'        => esc_html__( 'Mount Base', 'bdthemes-prime-slider' ),
                'type'         => 'checkbox',
                'default'      => "off",
                'widget_type'  => 'free',
                'content_type' => 'static',
                'demo_url'     => 'https://primeslider.pro/demo/mount/',
                'video_url'    => '',
            ];
        }
        return $settings_fields;
    }
    
    function prime_slider_welcome()
    {
        $current_user = wp_get_current_user();
        ?>

            <div class="ps-dashboard-panel"
                 bdt-scrollspy="target: > div > div > .bdt-card; cls: bdt-animation-slide-bottom-small; delay: 300">

                <div class="bdt-grid" bdt-grid bdt-height-match="target: > div > .bdt-card">
                    <div class="bdt-width-1-2@m ps-welcome-banner">
                        <div class="ps-welcome-content bdt-card bdt-card-body">
                            <h1 class="ps-feature-title">
                                Welcome <?php 
        echo  esc_html( $current_user->user_firstname ) ;
        ?> <?php 
        echo  esc_html( $current_user->user_lastname ) ;
        ?>
                                !</h1>
                            <p>Based on Elementor page builder – Prime slider is a dynamic ready to use slider that
                                comes
                                with next-generation designs. Everything is done by us, you have to just replace the
                                media
                                files and the content. Prime Slider for Elementor has been developed with world’s best
                                practice code standard and meets proper validation using the latest CSS, HTML5 and PHP
                                7.x
                                technologies to bring you a professional level slider for Elementor Page Builder Plugin
                                that
                                is WordPress 5.2x ready.</p>
                        </div>
                    </div>

                    <div class="bdt-width-1-2@m">
                        <div class="bdt-card bdt-card-body bdt-card-red ps-genarate-idea">

                            <h1 class="ps-feature-title">Learn Prime Slider</h1>
                            <p style="max-width: 690px;">Designing an element might be so tough, I might not able to do
                                it!
                                You often may think like that but it’s not true. We have made the best tutotials and
                                walk
                                throughs for each and every elements, widgets, blocks that anyone will be able to do it.
                                Lets visit the documentation web portal and learn more about your desired elements to
                                make
                                the next coolest website on the internet.</p>
                            <a class="bdt-button bdt-btn-red bdt-margin-small-top bdt-margin-small-right"
                               target="_blank" rel=""
                               href="https://primeslider.pro/knowledge-base/">Go knowledge page</a>
                            <a class="bdt-button bdt-btn-red bdt-margin-small-top" target="_blank" rel=""
                               href="https://www.facebook.com/primeslider/">Follow on Facebook</a>

                        </div>
                    </div>
                </div>

                <div class="bdt-grid" bdt-grid bdt-height-match="target: > div > .bdt-card">

                    <div class="bdt-width-2-3@m">
                        <div class="bdt-card bdt-card-red bdt-card-body">
                            <h1 class="ps-feature-title">Frequently Asked Questions</h1>

                            <ul bdt-accordion="collapsible: false">
                                <li>
                                    <a class="bdt-accordion-title" href="#">Is Prime Slider compatible my theme?</a>
                                    <div class="bdt-accordion-content">
                                        <p>
                                            Normally our plugin is compatible with most of theme and cross browser that
                                            we
                                            have tested. If happen very few change to your site looking, no problem our
                                            strong support team is dedicated for fixing your minor problem.
                                        </p>
                                        <p>
                                            Here some theme compatibility video example: <a
                                                    href="https://youtu.be/5U6j7X5kA9A" target="_blank">Avada</a> ,<a
                                                    href="https://youtu.be/HdZACDwrrdM" target="_blank">Astra</a>, <a
                                                    href="https://youtu.be/kjqpQRsVyY0" target="_blank">OcecanWP</a>
                                        </p>

                                    </div>
                                </li>
                                <li>
                                    <a class="bdt-accordion-title" href="#">How should I get updates?</a>
                                    <div class="bdt-accordion-content">
                                        <p>
                                            When we release an update version, then automatically you will get a
                                            notification on WordPress plugin manager, so you can update from there.
                                            Thereafter you want to update manually just knock us, we will send you
                                            update
                                            version via mail.
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <a class="bdt-accordion-title" href="#">What is 3rd Party Widgets?</a>
                                    <div class="bdt-accordion-content">
                                        <p>
                                            3rd Party widgets mean you should install that 3rd party plugin to use that
                                            widget. For example, There have WC Carousel or WC Products. If you want to
                                            use
                                            those widgets so you must install WooCommerce Plugin first. So you can
                                            access
                                            those widgets.
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="bdt-width-1-3@m">
                        <div class="ps-video-tutorial bdt-card bdt-card-body bdt-card-green">
                            <h1 class="ps-feature-title">Video Tutorial</h1>

                            <ul class="bdt-list bdt-list-divider" bdt-lightbox>
                                <li>
                                    <a href="https://youtu.be/v2nrvSarDA0">
                                        <h4 class="ps-link-title">How to Create a Template for Offcanvas Menu by Prime Slider</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://youtu.be/VMBuGusjvtM">
                                        <h4 class="ps-link-title">How to use General Widget</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://youtu.be/8wlCWhSMQno">
                                        <h4 class="ps-link-title">How to Use Isolate Widget</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://youtu.be/G32YlydUcHg">
                                        <h4 class="ps-link-title">How to Blog Widget</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://youtu.be/1ggdO2GNAJc">
                                        <h4 class="ps-link-title">How to Blog Widget Coral Skin</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://youtu.be/t0rxBfKY5UQ">
                                        <h4 class="ps-link-title">How to Use Isolate Widget Slice Skin</h4>
                                    </a>
                                </li>
                            </ul>

                            <a class="bdt-video-btn" target="_blank"
                               href="https://www.youtube.com/playlist?list=PLP0S85GEw7DP3-yJrkgwpIeDFoXy0PDlM">View more
                                videos <span class="dashicons dashicons-arrow-right"></span></a>
                        </div>


                    </div>

                </div>


                <div class="bdt-grid" bdt-grid bdt-height-match="target: > div > .bdt-card">
                    <div class="bdt-width-1-3@m ps-support-section">
                        <div class="ps-support-content bdt-card bdt-card-green bdt-card-body">
                            <h1 class="ps-feature-title">Support And Feedback</h1>
                            <p>Feeling like to consult with an expert? Take live Chat support immediately from <a
                                        href="https://primeslider.pro/" target="_blank" rel="">PrimeSlider</a>. We are
                                always ready to help you 24/7.</p>
                            <p><strong>Or if you’re facing technical issues with our plugin, then please create a
                                    support
                                    ticket</strong></p>
                            <a class="bdt-button bdt-btn-green bdt-margin-small-top" target="_blank"
                               href="https://bdthemes.com/support/">Get Support</a>
                        </div>
                    </div>

                    <div class="bdt-width-2-3@m">
                        <div class="bdt-card bdt-card-body bdt-card-green ps-system-requirement">
                            <h1 class="ps-feature-title bdt-margin-small-bottom">System Requirement</h1>
                            <?php 
        $this->prime_slider_system_requirement();
        ?>
                        </div>
                    </div>
                </div>

                <div class="bdt-grid" bdt-grid bdt-height-match="target: > div > .bdt-card">
                    <div class="bdt-width-2-3@m ps-support-section">
                        <div class="bdt-card bdt-card-body bdt-card-red ps-support-feedback">
                            <h1 class="ps-feature-title">Missing Any Feature?</h1>
                            <p style="max-width: 800px;">Are you in need of a feature that’s not available in our
                                plugin?
                                Feel free to do a
                                feature request from here,</p>
                            <a class="bdt-button bdt-btn-red bdt-margin-small-top" target="_blank" rel=""
                               href="https://primeslider.pro/make-a-suggestion/">Request Feature</a>
                        </div>
                    </div>

                    <div class="bdt-width-1-3@m">
                        <div class="ps-newsletter-content bdt-card bdt-card-green bdt-card-body">
                            <h1 class="ps-feature-title">Newsletter Subscription</h1>
                            <p>To get updated news, current offers, deals, and tips please subscribe to our
                                Newsletters.</p>
                            <a class="bdt-button bdt-btn-green bdt-margin-small-top" target="_blank" rel=""
                               href="https://primeslider.pro/#footer-section">Subscribe Now</a>
                        </div>
                    </div>
                </div>

            </div>
            
            
            <?php 
    }
    
    function prime_slider_system_requirement()
    {
        $php_version = phpversion();
        $max_execution_time = ini_get( 'max_execution_time' );
        $memory_limit = ini_get( 'memory_limit' );
        $post_limit = ini_get( 'post_max_size' );
        $uploads = wp_upload_dir();
        $upload_path = $uploads['basedir'];
        $yes_icon = '<span class="valid"><i class="dashicons-before dashicons-yes"></i></span>';
        $no_icon = '<span class="invalid"><i class="dashicons-before dashicons-no-alt"></i></span>';
        // TODO - active and deactive modules count
        // $core_moduels = get_option( 'prime_slider_active_modules' );
        // $thirdparty_modules = get_option( 'prime_slider_third_party_widget' );
        // $extended = get_option( 'prime_slider_elementor_extend' );
        // $all_modules = count($core_moduels) + count($thirdparty_modules) + count($extended) ;
        ?>
            <ul class="check-system-status">
                <li>
                    <span class="label1">PHP Version: </span>
                    
                    <?php 
        
        if ( version_compare( $php_version, '5.6.0', '<' ) ) {
            echo  $no_icon ;
            echo  '<span class="label2">Currently: ' . $php_version . ' (Min: 5.6 Recommended)</span>' ;
        } else {
            echo  $yes_icon ;
            echo  '<span class="label2">Currently: ' . $php_version . '</span>' ;
        }
        
        ?>
                </li>
                <li>
                    <span class="label1">Maximum execution time: </span>
                    
                    <?php 
        
        if ( $max_execution_time < '90' ) {
            echo  $no_icon ;
            echo  '<span class="label2">Currently: ' . $max_execution_time . '(Min: 90 Recommended)</span>' ;
        } else {
            echo  $yes_icon ;
            echo  '<span class="label2">Currently: ' . $max_execution_time . '</span>' ;
        }
        
        ?>
                </li>
                <li>
                    <span class="label1">Memory Limit: </span>
                    
                    <?php 
        
        if ( intval( $memory_limit ) < '128' ) {
            echo  $no_icon ;
            echo  '<span class="label2">Currently: ' . $memory_limit . ' (Min: 128M Recommended)</span>' ;
        } else {
            echo  $yes_icon ;
            echo  '<span class="label2">Currently: ' . $memory_limit . '</span>' ;
        }
        
        ?>
                </li>

                <li>
                    <span class="label1">Max Post Limit: </span>
                    
                    <?php 
        
        if ( intval( $post_limit ) < '32' ) {
            echo  $no_icon ;
            echo  '<span class="label2">Currently: ' . $post_limit . ' (Min: 32M Recommended)</span>' ;
        } else {
            echo  $yes_icon ;
            echo  '<span class="label2">Currently: ' . $post_limit . '</span>' ;
        }
        
        ?>
                </li>

                <li>
                    <span class="label1">Uploads folder writable: </span>
                    
                    <?php 
        
        if ( !is_writable( $upload_path ) ) {
            echo  $no_icon ;
        } else {
            echo  $yes_icon ;
        }
        
        ?>
                </li>

            </ul>

            <div class="bdt-admin-alert">
                <strong>Note:</strong> If you have multiple addons like element pack so you need some more requirement
                some
                cases so make sure you added more memory for others addon too.
            </div>
            <?php 
    }
    
    function plugin_page()
    {
        echo  '<div class="wrap prime-slider-dashboard">' ;
        echo  '<h1>' . BDTPS_TITLE . ' Settings</h1>' ;
        $this->settings_api->show_navigation();
        ?>


            <div class="bdt-switcher">
                <div id="prime_slider_welcome_page" class="ps-option-page group">
                    <?php 
        $this->prime_slider_welcome();
        ?>
                </div>
                
                <?php 
        $this->settings_api->show_forms();
        ?>


            </div>

            </div>
            
            <?php 
        if ( !defined( 'BDTPS_WL' ) ) {
            $this->footer_info();
        }
        ?>
            
            <?php 
        $this->script();
        ?>
            
            <?php 
    }
    
    /**
     * Tabbable JavaScript codes & Initiate Color Picker
     *
     * This code uses localstorage for displaying active tabs
     */
    function script()
    {
        ?>
            <script>
                jQuery(document).ready(function ($) {

                    var hash = location.hash.substr(1);

                    if (hash === 'widgets') {
                        bdtUIkit.tab('.prime-slider-dashboard .bdt-tab').show(1);
                    }
                    if (hash === 'license') {
                        bdtUIkit.tab('.prime-slider-dashboard .bdt-tab').show(5);
                    }

                    jQuery("#adminmenu .toplevel_page_prime_slider_options .wp-submenu > li:nth-child(3) > a").click(function () {
                        bdtUIkit.tab('.prime-slider-dashboard .bdt-tab').show(1);
                        window.location.hash = "widgets"

                    });

                    jQuery("#adminmenu .toplevel_page_prime_slider_options .wp-submenu > li:nth-child(4) > a").click(function () {
                        bdtUIkit.tab('.prime-slider-dashboard .bdt-tab').show(5);
                        window.location.hash = "license"
                    });

                    jQuery("#prime_slider_active_modules_page a.ps-active-all-widget").click(function () {
                        jQuery('#prime_slider_active_modules_page .checkbox').attr('checked', 'checked').prop("checked", true);
                        jQuery(this).addClass('bdt-active');
                        jQuery("a.ps-deactive-all-widget").removeClass('bdt-active');
                    });

                    jQuery("#prime_slider_active_modules_page a.ps-deactive-all-widget").click(function () {
                        jQuery('#prime_slider_active_modules_page .checkbox').removeAttr('checked');
                        jQuery(this).addClass('bdt-active');
                        jQuery("a.ps-active-all-widget").removeClass('bdt-active');
                    });

                    jQuery("#prime_slider_third_party_widget_page a.ps-active-all-widget").click(function () {
                        jQuery('#prime_slider_third_party_widget_page .checkbox').attr('checked', 'checked').prop("checked", true);
                        jQuery(this).addClass('bdt-active');
                        jQuery("a.ps-deactive-all-widget").removeClass('bdt-active');
                    });

                    jQuery("#prime_slider_third_party_widget_page a.ps-deactive-all-widget").click(function () {
                        jQuery('#prime_slider_third_party_widget_page .checkbox').removeAttr('checked');
                        jQuery(this).addClass('bdt-active');
                        jQuery("a.ps-active-all-widget").removeClass('bdt-active');
                    });


                    jQuery('form.settings-save').submit(function (event) {
                        event.preventDefault();

                        bdtUIkit.notification({
                            message: '<div bdt-spinner></div> <?php 
        esc_html_e( 'Please wait, Saving settings...', 'bdthemes-prime-slider' );
        ?>',
                            timeout: false
                        });

                        jQuery(this).ajaxSubmit({
                            success: function () {
                                bdtUIkit.notification.closeAll();
                                bdtUIkit.notification({
                                    message: '<span class="dashicons dashicons-yes"></span> <?php 
        esc_html_e( 'Settings Saved Successfully.', 'bdthemes-prime-slider' );
        ?>',
                                    status : 'primary'
                                });
                            },
                            error  : function (data) {
                                bdtUIkit.notification.closeAll();
                                bdtUIkit.notification({
                                    message: '<span bdt-icon=\'icon: warning\'></span> <?php 
        esc_html_e( 'Unknown error, make sure access is correct!', 'bdthemes-prime-slider' );
        ?>',
                                    status : 'warning'
                                });
                            }
                        });

                        return false;
                    });

                });
            </script>
            <?php 
    }
    
    function footer_info()
    {
        ?>
            <div class="prime-slider-footer-info">
                <p>Prime Slider Addon made with love by <a target="_blank" href="https://bdthemes.com">BdThemes</a>
                    Team.
                    <br>All rights reserved by BdThemes.</p>
            </div>
            <?php 
    }
    
    public function admin_notice()
    {
        Notices::add_notice( [
            'id'               => 'license-issue',
            'type'             => 'error',
            'dismissible'      => true,
            'dismissible-time' => 43200,
            'message'          => __( 'Thank you for purchase Prime Slider. Please <a href="' . self::get_url() . '">activate your license</a> to get feature updates, premium support. <br> Don\'t have Prime Slider license? Purchase and download your license copy <a href="https://primeslider.pro/" target="_blank">from here</a>.', 'bdthemes-prime-slider' ),
        ] );
    }
    
    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages()
    {
        $pages = get_pages();
        $pages_options = [];
        if ( $pages ) {
            foreach ( $pages as $page ) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }
        return $pages_options;
    }

}
new PrimeSlider_Admin_Settings();