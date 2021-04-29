<?php
    
    /**
     * Prime slider widget activation filters
     * @since 1.12.6
     */
    
    if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    // Admin Settings Filters
    
    if ( !function_exists( 'ps_is_dashboard_enabled' ) ) {
        function ps_is_dashboard_enabled() {
            if ( bdt_ps()->is_plan('agency') ) {
                return apply_filters( 'primeslider/settings/dashboard', true );
            } else {
                return true;
            }
        }
    }
    if ( !function_exists( 'ps_is_affiliation_enabled' ) ) { //TODO
        function ps_is_affiliation_enabled() {
            if ( bdt_ps()->is_plan('agency') ) {
                return apply_filters( 'primeslider/settings/affiliation', true );
            } else {
                return true;
            }
        }
    }
    
    if ( !function_exists( 'ps_is_account_enabled' ) ) { //TODO
        function ps_is_account_enabled() {
            if ( bdt_ps()->is_plan('agency') ) {
                return apply_filters( 'primeslider/settings/account', true );
            } else {
                return true;
            }
        }
    }
    
    if ( !function_exists( 'ps_is_contact_enabled' ) ) { //TODO
        function ps_is_contact_enabled() {
            if ( bdt_ps()->is_plan('agency') ) {
                return apply_filters( 'primeslider/settings/contact', true );
            } else {
                return true;
            }
        }
    }
    if ( !function_exists( 'ps_is_upgrade_mode_enabled' ) ) { //TODO
        function ps_is_upgrade_mode_enabled() {
            if ( bdt_ps()->is_plan('agency') ) {
                return apply_filters( 'primeslider/settings/upgrade_mode', true );
            } else {
                return true;
            }
        }
    }
    
    if ( !function_exists( 'ps_is_giveaway_notice_enabled' ) ) {
        function ps_is_giveaway_notice_enabled() {
            return apply_filters( 'primeslider/settings/giveaway_notice', true );
        }
    }
    
    // Widgets filters
    if ( !function_exists( 'ps_is_blog_enabled' ) ) {
        function ps_is_blog_enabled() {
            return apply_filters( 'primeslider/widgets/blog', true );
        }
    }
    
    if ( !function_exists( 'ps_is_dragon_enabled' ) ) {
        function ps_is_dragon_enabled() {
            return apply_filters( 'primeslider/widgets/dragon', true );
        }
    }
    
    if ( !function_exists( 'ps_is_flogia_enabled' ) ) {
        function ps_is_flogia_enabled() {
            return apply_filters( 'primeslider/widgets/flogia', true );
        }
    }
    
    if ( !function_exists( 'ps_is_general_enabled' ) ) {
        function ps_is_general_enabled() {
            return apply_filters( 'primeslider/widgets/general', true );
        }
    }
    
    if ( !function_exists( 'ps_is_isolate_enabled' ) ) {
        function ps_is_isolate_enabled() {
            return apply_filters( 'primeslider/widgets/isolate', true );
        }
    }
    
    if ( !function_exists( 'ps_is_mount_enabled' ) ) {
        function ps_is_mount_enabled() {
            return apply_filters( 'primeslider/widgets/mount', true );
        }
    }
    
    if ( !function_exists( 'ps_is_multiscroll_enabled' ) ) {
        function ps_is_multiscroll_enabled() {
            return apply_filters( 'primeslider/widgets/multiscroll', true );
        }
    }
    
    if ( !function_exists( 'ps_is_pagepiling_enabled' ) ) {
        function ps_is_pagepiling_enabled() {
            return apply_filters( 'primeslider/widgets/pagepiling', true );
        }
    }
    
    if ( !function_exists( 'ps_is_sequester_enabled' ) ) {
        function ps_is_sequester_enabled() {
            return apply_filters( 'primeslider/widgets/sequester', true );
        }
    }
    
    if ( !function_exists( 'ps_is_custom_enabled' ) ) {
        function ps_is_custom_enabled() {
            return apply_filters( 'primeslider/widgets/custom', true );
        }
    }
    
    if ( !function_exists( 'ps_is_fluent_enabled' ) ) {
        function ps_is_fluent_enabled() {
            return apply_filters( 'primeslider/widgets/fluent', true );
        }
    }
    
    if ( !function_exists( 'ps_is_flexure_enabled' ) ) {
        function ps_is_flexure_enabled() {
            return apply_filters( 'primeslider/widgets/flexure', true );
        }
    }
    
    if ( !function_exists( 'ps_is_monster_enabled' ) ) {
        function ps_is_monster_enabled() {
            return apply_filters( 'primeslider/widgets/monster', true );
        }
    }
    
    if ( !function_exists( 'ps_is_event_calendar_enabled' ) ) {
        function ps_is_event_calendar_enabled() {
            return apply_filters( 'primeslider/widgets/event_calendar', true );
        }
    }
    
    if ( !function_exists( 'ps_is_woostand_enabled' ) ) {
        function ps_is_woostand_enabled() {
            return apply_filters( 'primeslider/widgets/woostand', true );
        }
    }
    
    if ( !function_exists( 'ps_is_woocommerce_enabled' ) ) {
        function ps_is_woocommerce_enabled() {
            return apply_filters( 'primeslider/widgets/woocommerce', true );
        }
    }
    
    if ( !function_exists( 'ps_is_woolamp_enabled' ) ) {
        function ps_is_woolamp_enabled() {
            return apply_filters( 'primeslider/widgets/woolamp', true );
        }
    }

