<?php

/**
 * @package Unlimited Elements
 * @author UniteCMS http://unitecms.net
 * @copyright Copyright (c) 2016 UniteCMS
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

//no direct accees
defined ('UNLIMITED_ELEMENTS_INC') or die ('restricted aceess');

class UniteCreatorElementorPagination{
	
	
	/**
	 * add content controls
	 */
	private function addElementorControls_content($widget){
    	
		$widget->start_controls_section(
                'section_pagination', array(
                'label' => esc_html__("Posts Pagination", "unlimited-elements-for-elementor"),
              )
         );

		$widget->add_control(
			'pagination_heading',
			[
				'label' => __( 'When turned on, the pagination will appear in archive or single pages, you have option to use the "Posts Pagination" widget for all the styling options', "unlimited-elements-for-elementor"),
				'type' => \Elementor\Controls_Manager::HEADING,
				'default' => ''
			]
		);
         
         
		$widget->add_control(
			'pagination_type',
			[
				'label' => __( 'Pagination', "unlimited-elements-for-elementor"),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', "unlimited-elements-for-elementor"),
					'numbers' => __( 'Numbers', "unlimited-elements-for-elementor"),
					'pagination_widget' => __( 'Using Pagination Widget', "unlimited-elements-for-elementor")
				],
			]
		);

		/*
		$widget->add_control(
			'pagination_page_limit',
			[
				'label' => __( 'Page Limit', "unlimited-elements-for-elementor"),
				'default' => '5',
				'condition' => [
					'pagination_type!' => '',
				],
			]
		);

		$widget->add_control(
			'pagination_numbers_shorten',
			[
				'label' => __( 'Shorten', "unlimited-elements-for-elementor"),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'pagination_type' => [
						'numbers',
						'numbers_and_prev_next',
					],
				],
			]
		);

		$widget->add_control(
			'pagination_prev_label',
			[
				'label' => __( 'Previous Label', "unlimited-elements-for-elementor"),
				'default' => __( '&laquo; Previous', "unlimited-elements-for-elementor"),
				'condition' => [
					'pagination_type' => [
						'prev_next',
						'numbers_and_prev_next',
					],
				],
			]
		);

		$widget->add_control(
			'pagination_next_label',
			[
				'label' => __( 'Next Label', "unlimited-elements-for-elementor"),
				'default' => __( 'Next &raquo;', "unlimited-elements-for-elementor"),
				'condition' => [
					'pagination_type' => [
						'prev_next',
						'numbers_and_prev_next',
					],
				],
			]
		);
		

		$widget->add_control(
			'pagination_align',
			[
				'label' => __( 'Alignment', "unlimited-elements-for-elementor"),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', "unlimited-elements-for-elementor"),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', "unlimited-elements-for-elementor"),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', "unlimited-elements-for-elementor"),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .uc-posts-pagination' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'pagination_type!' => '',
				],
			]
		);
		*/

                  
        $widget->end_controls_section();
	}
	
	
	/**
	 * add styles controls
	 */
	private function addElementorControls_styles($widget){
		
		$widget->start_controls_section(
			'section_pagination_style',
			[
				'label' => __( 'Pagination', "unlimited-elements-for-elementor"),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'pagination_type!' => '',
				],
			]
		);

		$widget->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pagination_typography',
				'selector' => '{{WRAPPER}} .uc-posts-pagination',
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_2,
			]
		);

		$widget->add_control(
			'pagination_color_heading',
			[
				'label' => __( 'Colors', "unlimited-elements-for-elementor"),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$widget->start_controls_tabs( 'pagination_colors' );

		$widget->start_controls_tab(
			'pagination_color_normal',
			[
				'label' => __( 'Normal', "unlimited-elements-for-elementor"),
			]
		);

		$widget->add_control(
			'pagination_color',
			[
				'label' => __( 'Color', "unlimited-elements-for-elementor"),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uc-posts-pagination .page-numbers:not(.dots)' => 'color: {{VALUE}};',
				],
			]
		);

		$widget->end_controls_tab();

		$widget->start_controls_tab(
			'pagination_color_hover',
			[
				'label' => __( 'Hover', "unlimited-elements-for-elementor"),
			]
		);

		$widget->add_control(
			'pagination_hover_color',
			[
				'label' => __( 'Color', "unlimited-elements-for-elementor"),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uc-posts-pagination a.page-numbers:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$widget->end_controls_tab();

		$widget->start_controls_tab(
			'pagination_color_active',
			[
				'label' => __( 'Active', "unlimited-elements-for-elementor"),
			]
		);

		$widget->add_control(
			'pagination_active_color',
			[
				'label' => __( 'Color', "unlimited-elements-for-elementor"),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .uc-posts-pagination .page-numbers.current' => 'color: {{VALUE}};',
				],
			]
		);

		$widget->end_controls_tab();

		$widget->end_controls_tabs();

		$widget->add_responsive_control(
			'pagination_spacing',
			[
				'label' => __( 'Space Between', "unlimited-elements-for-elementor"),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'separator' => 'before',
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .uc-posts-pagination .page-numbers:not(:first-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'body:not(.rtl) {{WRAPPER}} .uc-posts-pagination .page-numbers:not(:last-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .uc-posts-pagination .page-numbers:not(:first-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .uc-posts-pagination .page-numbers:not(:last-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
				],
			]
		);

		$widget->end_controls_section();
		
	}
	
	
	/**
	 * add elementor controls
	 */
	public function addElementorSectionControls($widget){
		
		$this->addElementorControls_content($widget);
		
		//$this->addElementorControls_styles($widget);
		
	}
	
	
	/**
	 * put pagination
	 */
	public function getHTMLPaginationByElementor($arrValues, $isArchivePage){
		
		$paginationType = UniteFunctionsUC::getVal($arrValues, "pagination_type");
				
		if($paginationType != "numbers")
			return(false);

		if(is_front_page() == true)
			return(false);
				
		$options = array();
		$options["prev_next"] = false;
				
		//$options["mid_size"] = 2;
		//$options["prev_text"] = __( 'Newer', "unlimited-elements-for-elementor");
		//$options["next_text"] = __( 'Older', "unlimited-elements-for-elementor");
		//$options["total"] = 10;
		//$options["current"] = 3;
		
		if($isArchivePage == true){

			$options = $this->getArchivePageOptions($options);
		
			$pagination = get_the_posts_pagination($options);
		}
		else{
			
			$options = $this->getSinglePageOptions($options);
			
			if(isset($options["current"]) == false)
				return(false);
			
			$pagination = paginate_links($options);
		}
		
		$html = "<div class='uc-posts-pagination'>$pagination</div>";
		
		return($html);
	}
	
	/**
	 * get archive options
	 */
	private function getArchivePageOptions($options){
		
		//output demo pagination
		$isEditMode = UniteCreatorElementorIntegrate::$isEditMode;
		if($isEditMode == true){
			$options["total"] = 5;
			$options["current"] = 2;
			return($options);
		}
		
		return($options);
	}
	
	
	/**
	 * get single page options
	 */
	private function getSinglePageOptions($options){
		
		//output demo pagination
		$isEditMode = UniteCreatorElementorIntegrate::$isEditMode;
		if($isEditMode == true){
			$options["total"] = 5;
			$options["current"] = 2;
			return($options);
		}
		
		if(empty(GlobalsProviderUC::$lastPostQuery))
			return($options);
		
		$numPages = GlobalsProviderUC::$lastPostQuery->max_num_pages;
		if($numPages <= 1)
			return($options);
		
		global $wp_rewrite;
		$isUsingPermalinks = $wp_rewrite->using_permalinks();
		if( $isUsingPermalinks == true){		//with permalinks - add /2
			
			$options['base'] = trailingslashit( get_permalink() ) . '%_%';
			$options['format'] = user_trailingslashit( '%#%', 'single_paged' );
			
		}else{		//if not permalinks
			$options['format'] = '?page=%#%';		// add ?page=2
		}
		
		$options["total"] = $numPages;
		
		//set current page
		$currentPage = 1;
		if(!empty(GlobalsProviderUC::$lastPostQuery_page))
			$currentPage = GlobalsProviderUC::$lastPostQuery_page;
		else{
			$currentPage = get_query_var("page");
		}
		
		if(empty($currentPage))
			$currentPage = 1;
		
		$options["current"] = $currentPage;
		
		return($options);		
	}
	
	
	/**
	 * put pagination widget html
	 */
	public function putPaginationWidgetHtml($args){
		
		
		$putPrevNext = UniteFunctionsUC::getVal($args, "put_prev_next_buttons");
		$putPrevNext = UniteFunctionsUC::strToBool($putPrevNext);
		
		$midSize = UniteFunctionsUC::getVal($args, "mid_size", 2);
		$midSize = (int)$midSize;

		$endSize = UniteFunctionsUC::getVal($args, "end_size", 1);
		$endSize = (int)$endSize;
		
		$showAll = UniteFunctionsUC::getVal($args, "show_all");
		$showAll = UniteFunctionsUC::strToBool($showAll);
		
		$isShowText = UniteFunctionsUC::getVal($args, "show_text");
		$isShowText = UniteFunctionsUC::strToBool($isShowText);
		
		$prevText = UniteFunctionsUC::getVal($args, "prev_text");
		$nextText = UniteFunctionsUC::getVal($args, "next_text");
		
		$prevText = trim($prevText);
		$nextText = trim($nextText);
		
		$isDebug = UniteFunctionsUC::getVal($args, "debug_pagination_options");
		$isDebug = UniteFunctionsUC::strToBool($isDebug);
		
		//--------- prepare options
		
		$options = array();
		
		$options["show_all"] = $showAll;
		$options["mid_size"] = $midSize;
		$options["end_size"] = $endSize;
		
		$options["prev_next"] = $putPrevNext;
		
		if(!empty($prevText))
			$options["prev_text"] = $prevText;
		
		if(!empty($nextText))
			$options["next_text"] = $nextText;
		
		//disable the text, leave only icon
		if($isShowText == false){
			$options["next_text"] = "";
			$options["prev_text"] = "";
		}
		
		//$options["total"] = 10;
		//$options["current"] = 3;
		
		//-------- put pagination html
					
		$isArchivePage = UniteFunctionsWPUC::isArchiveLocation();
		
		if($isArchivePage == true){
						
			$options = $this->getArchivePageOptions($options);
			$pagination = get_the_posts_pagination($options);
			
		}else{		//on single
			
			//skip for home pages
			if(is_home() == true)
				return(false);
						
			$options = $this->getSinglePageOptions($options);
			
			if(isset($options["current"]) == false)
				return(false);
			
			if(empty($nextText))
				$options["next_text"] = _x( 'Next', 'next set of posts' );
			
			if(empty($prevText))
				$options["prev_text"] = _x( 'Previous', 'previous set of posts' );
			
			$pagination = paginate_links($options);	
		}
		
		if($isDebug == true){
			dmp("<b>Pagination Options</b>: ");
			dmp($options);
		}
		
		echo $pagination;
	}
	
	
}