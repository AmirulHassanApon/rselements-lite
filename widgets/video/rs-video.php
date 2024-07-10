<?php
/**
 * Elementor RS video Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\register_controls;
use Elementor\Group_Control_Border;

use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Rsaddon_Elementor_lite_RSvideo_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve counter widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'rs-video';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve counter widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'RS Video', 'rsaddon' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve counter widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'glyph-icon flaticon-multimedia';
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.3.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_categories() {
        return [ 'rsaddon_category' ];
    }

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'video' ];
	}

	/**
	 * Register counter widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_counter',
			[
				'label' => __( 'Content', 'rsaddon' ),
			]
		);

		$this->add_responsive_control(
            'align',
            [
                'label' => __( 'Title Alignment', 'rsaddon' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'rsaddon' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'rsaddon' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'rsaddon' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justify', 'rsaddon' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default'     => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .rs-video' => 'text-align: {{VALUE}}'
                ],
				'separator' => 'before',
            ]
        );

        $this->add_control(
			'rs_video_style',
			[
				'label'   => esc_html__( 'Select Video Style', 'rsaddon' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [					
					'style1' => esc_html__( 'Style 1', 'rsaddon'),
					'style2' => esc_html__( 'Style 2', 'rsaddon'),
				],
			]
		);

	
		$this->add_control(
			'video_link',
			[
				'label' => __( 'Enter Link Here', 'rsaddon' ),
				'type' => Controls_Manager::TEXT,
				'default'     => '#',
				'placeholder' => esc_html__( 'Video link here', 'rsaddon' ),				
				'separator' => 'before',
			]
		);
	
		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Background Image', 'rsaddon' ),
				'type' => \Elementor\Controls_Manager::MEDIA,				
				'separator' => 'before',
			]
		);

			$this->add_control(
			'rs_video_title',
			[
				'label' => __( 'Video Title', 'rsaddon' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,	
				'separator' => 'before',
				'condition' => [
		            'rs_video_style' => 'style2'
		        ],
			]
		);
			
		
	
		
		$this->add_control(
			'description',
			[
				'label' => __( 'Video Description', 'rsaddon' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,	
				'default'     => 'Add your video description here',
				'placeholder' => esc_html__( 'Add your video description here..', 'rsaddon' ),
				'separator' => 'before',
			]
			
		);
	
		
		$this->add_control(
			'rs_video_subtitle',
			[
				'label' => __( 'Video Subtitle', 'rsaddon' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,	
				'separator' => 'before',
				'condition' => [
		            'rs_video_style' => 'style2'
		        ],
			]
			
		);
	
		
		$this->add_control(
			'rs_video_btn',
			[
				'label' => __( 'Button Text', 'rsaddon' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,	
				'separator' => 'before',
				'default'     => 'Button Text',
				'placeholder' => esc_html__( 'Add button text here..', 'rsaddon' ),
				'condition' => [
		            'rs_video_style' => 'style2'
		        ],
			]
			
		);
		
		$this->add_control(
			'rs_video_btn_link',
			[
				'label' => __( 'Button Link Text', 'rsaddon' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,	
				'separator' => 'before',
				'default'     => '#',
				'placeholder' => esc_html__( 'Add button link here..', 'rsaddon' ),
				'condition' => [
		            'rs_video_style' => 'style2'
		        ],
			]
			
		);


		
		
		$this->end_controls_section();

				
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Content', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color_style2',
			[
				'label' => __( 'Title Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .video_title' => 'color: {{VALUE}};',
				],				
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'video_title_text',				
				'selector' => '{{WRAPPER}} .video_title',
				
			]
		);


		$this->add_control(
			'title_color',
			[
				'label' => __( 'Content Text Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .video-desc' => 'color: {{VALUE}};',
				],

				
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_text',				
				'selector' => '{{WRAPPER}} .video-desc',
				
			]
		);

		$this->add_responsive_control(
            'video_title_postion',
            [
                'label' => __( 'Content Position Vertical', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
               'range' => [
                   'px' => [
                       'min' => -500,
                       'max' => 500,
                   ],
               ],                
                'selectors' => [
                    '{{WRAPPER}} .rs-video .video-desc' => 'top: {{SIZE}}px;',                   
                ],
            ]
        );

        $this->add_responsive_control(
		    'video_full_area_padding',
		    [
		        'label' => __( 'Area Padding', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-video' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Icon', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'icon_btn',
			[
				'label' => __( 'Button Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .rs-video.style2 .rs-icon-inner .rs-icon-btn a' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
		            'rs_video_style' => 'style2'
		        ],
			]
		);


		$this->add_control(
			'icon_btn_hover',
			[
				'label' => __( 'Button Hover Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .rs-video.style2 .rs-icon-inner .rs-icon-btn a:hover' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
		            'rs_video_style' => 'style2'
		        ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[	'label' => __( 'Typography', 'rsaddon' ),
				'name' => 'typography_btn',				
				'selector' => '{{WRAPPER}} .rs-video.style2 .rs-icon-inner .rs-icon-btn a',
				'separator' => 'before',
				'condition' => [
		            'rs_video_style' => 'style2'
		        ],
			]
		);

		$this->add_control(
			'btn_bg',
			[
				'label' => __( 'Button Background Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .rs-video.style2 .rs-icon-inner .rs-icon-btn a' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
		            'rs_video_style' => 'style2'
		        ],
			]
		);

		$this->add_control(
			'btn_bg_hover',
			[
				'label' => __( 'Button Hover Background Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .rs-video.style2 .rs-icon-inner .rs-icon-btn a:hover' => 'background: {{VALUE}};',
					'{{WRAPPER}} .rs-video.style2 .rs-icon-inner .rs-icon-btn a:before' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
		            'rs_video_style' => 'style2'
		        ],
			]
		);


		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .rs-video .popup-videos i:before' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[	'label' => __( 'Typography', 'rsaddon' ),
				'name' => 'typography_icon',				
				'selector' => '{{WRAPPER}} .rs-video .popup-videos i',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_bg',
			[
				'label' => __( 'Icon Background Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .rs-video .popup-videos' => 'background: {{VALUE}};',
					'{{WRAPPER}} .rs-video .popup-videos:before' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);


		$this->add_control(
			'icon_border',
			[
				'label' => __( 'Icon Border Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .rs-video .overly-border' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
            'video_icon_postion_ver',
            [
                'label' => __( 'Icon Position Vertical', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],

                
                'selectors' => [
                    '{{WRAPPER}} .rs-video .overly-border' => 'top: {{SIZE}}%;',                   
                ],
            ]
        );

		$this->add_responsive_control(
            'video_icon_postion_ht',
            [
                'label' => __( 'Icon Position Horizontal', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],

                
                'selectors' => [
                    '{{WRAPPER}} .rs-video .overly-border' => 'left: {{SIZE}}%;',                   
                ],
            ]
        );


		$this->end_controls_section();

	}

	/**
	 * Render counter widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	/**
	 * Render counter widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {	
	
		$settings = $this->get_settings_for_display();	
		$rand = rand(12, 3330);

		$this->add_inline_editing_attributes( 'description', 'basic' );
        $this->add_render_attribute( 'description', 'class', 'video-desc' ); 

		?>
  		<div class="rs-video video-item-<?php echo esc_attr($rand);?> <?php echo esc_html($settings['align']);?> <?php echo esc_html($settings['rs_video_style']);?>" <?php if(!empty($settings['image']['url'])):?>style="background: url(<?php echo esc_url($settings['image']['url']);?>);"<?php endif;?>>


   				<?php if($settings['rs_video_style'] == 'style1') { ?>	
  						<div class="overly-border">
						    <a class="popup-videos" href="<?php echo esc_url($settings['video_link']);?>">
								<i class="fa fa-play"></i>
							</a>
						</div>

				    <?php if( !empty( $settings['description']) || !empty( $settings['rs_video_subtitle']) ) : ?>
				    	<div <?php echo esc_attr($this->print_render_attribute_string('description')); ?>>
				    		<?php echo wp_kses_post($settings['description']); ?>
				    	</div>
				    <?php endif; ?>

				<?php }; ?>

				<?php if($settings['rs_video_style'] == 'style2') : ?>	
  					
  					<span class="video_title"><?php echo esc_html($settings['rs_video_title']); ?></span>

				    <?php if( !empty( $settings['description']) || !empty( $settings['rs_video_subtitle']) ) : ?>
				    	<div class="video-desc">
				    		<?php echo wp_kses_post($settings['description']); ?>
				    		<?php if( !empty( $settings['rs_video_subtitle']) ) : ?>	
				    			<span><?php echo wp_kses_post($settings['rs_video_subtitle']); ?></span>
				    		<?php endif;?>
				    	</div>
				    <?php endif;?>
				    <div class="rs-icon-inner">
  						<?php if( !empty( $settings['rs_video_btn']) ) : ?>	
	  						<div class="rs-icon-btn">
	  							<a href="<?php echo esc_url($settings['rs_video_btn_link']);?>"><?php echo esc_html($settings['rs_video_btn']);?></a>
	  						</div>
  						<?php endif; ?>

	   					<div class="icon-area">
		   					<div class="overly-border">
							    <a class="popup-videos" href="<?php echo esc_url($settings['video_link']);?>">
									<i class="fa fa-play"></i>
								</a>
							</div>
						</div>
					</div>
				<?php endif; ?>  
				    
			</div>	


		<script type="text/javascript">			
			jQuery(document).ready(function(){
				jQuery('.popup-videos').magnificPopup({
			        disableOn: 10,
			        type: 'iframe',
			        mainClass: 'mfp-fade',
			        removalDelay: 160,
			        preloader: false,

			        fixedContentPos: false
			    }); 
			});
		</script>
    
<?php 
	}
}