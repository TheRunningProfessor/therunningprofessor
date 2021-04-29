(function($, elementor) {

    'use strict';

    var widgetPagepiling = function($scope, $) {

        var $pagepiling = $scope.find('.bdt-pagepiling-slider');

        if (!$pagepiling.length) {
            return;
        }
        var $settings = $pagepiling.data('settings');

        $($pagepiling).pagepiling({
			menu: null,
        	direction: 'vertical',
            verticalCentered: true,
            scrollingSpeed: $settings.scrollingSpeed,
            easing: 'swing',
            navigation: {
				'position': 'left',
			},
            loopBottom: $settings.loopBottom,
            loopTop: $settings.loopTop,
            css3: true,
            normalScrollElements: null,
			normalScrollElementTouchThreshold: 5,
			touchSensitivity: 5,
			keyboardScrolling: true,
			sectionSelector: '.section'
        });

    };


    jQuery(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/prime-slider-pagepiling.default', widgetPagepiling);
    });

}(jQuery, window.elementorFrontend));