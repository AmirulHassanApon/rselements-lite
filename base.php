<?php
/**
 * Main Elementor Rsaddon Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Rsaddon_Elementor_lite_Extension {


	const VERSION = '1.0.0';

	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	const MINIMUM_PHP_VERSION = '5.4';

	private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	public function __construct() {
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}


	public function i18n() {
		load_plugin_textdomain( 'rsaddon' );
	}

	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add Plugin actions
		add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );
		add_action('elementor/elements/categories_registered', [$this, 'add_category']);
		add_action( 'wp_enqueue_scripts', [ $this, 'rsaddon_register_plugin_styles' ] );		
		add_action( 'admin_enqueue_scripts', [ $this, 'rsaddon_admin_defualt_css' ] );		
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'rsaddon_register_plugin_admin_styles' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'rselements_studio_fonts_url' ] );

		$this->include_files();
		
	}

	function rselements_studio_fonts_url() {
          $font_url = '';
          
          if ( 'off' !== _x( 'on', 'Google font: on or off', 'rsaddon' ) ) {
              $font_url = add_query_arg( 'family', urlencode( 'Open Sans: 400,500,600,700|Montserrat: 400,500,600,700' ), "//fonts.googleapis.com/css" );
          }
        return $font_url;
    }

	public function rsaddon_register_plugin_styles() {

		$dir = plugin_dir_url(__FILE__);

        wp_enqueue_style( 'bootstrap', $dir.'assets/css/bootstrap.min.css' ); 
        wp_enqueue_style( 'magnific-popup', $dir.'assets/css/magnific-popup.css'); 
        wp_enqueue_style( 'font-awesome-latest', $dir.'assets/css/fontawesome.css' );
        wp_enqueue_style( 'brands', $dir.'assets/css/brands.css' );
        wp_enqueue_style( 'solid', $dir.'assets/css/solid.css' );
        wp_enqueue_style( 'rsaddons-floaticon', $dir.'assets/fonts/flaticon.css' );
        wp_enqueue_style( 'headding-title', $dir.'assets/css/headding-title.css' );
        wp_enqueue_style( 'rsaddons-lite', $dir.'assets/css/rsaddons.css' );      

		wp_enqueue_script( 'magnific-popup', $dir.'assets/js/jquery.magnific-popup.min.js' , array('jquery'), '201513434', true);  
		wp_enqueue_script( 'popper', $dir.'assets/js/popper.min.js' , array('jquery'), '201513434', true);  
        wp_enqueue_script( 'bootstrap', $dir.'assets/js/bootstrap.min.js' , array('jquery'), '201513434', true );    
           
        wp_enqueue_script( 'waypoints', $dir.'assets/js/waypoints.min.js' , array('jquery'), '201513434', true );
        wp_enqueue_script( 'jquery-counterup', $dir.'assets/js/jquery.counterup.min.js' , array('jquery'), '201513434', true );     
        wp_enqueue_script( 'headding-title', $dir.'assets/js/headding-title.js' , array('jquery'), '201513434', true);     
        wp_enqueue_script( 'rsaddons-custom-lite', $dir.'assets/js/custom.js', array('jquery', 'imagesloaded'), '201513434', true);    	
    }

    public function rsaddon_register_plugin_admin_styles(){
    	$dir = plugin_dir_url(__FILE__);
    	wp_enqueue_style( 'rsaddons-admin', $dir.'assets/css/admin/admin.css' );
    	wp_enqueue_style( 'rsaddons-admin-floaticon', $dir.'assets/fonts/flaticon.css' );
    } 

    public function rsaddon_admin_defualt_css(){
    	$dir = plugin_dir_url(__FILE__);
    	wp_enqueue_style( 'rsaddons-admin', $dir.'assets/css/admin/style.css' );    	
    }

     public function include_files() {       
        require( __DIR__ . '/inc/rs-addon-icons.php' );       
    }

	public function add_category( $elements_manager ) {
        $elements_manager->add_category(
            'rsaddon_category',
            [
                'title' => __( 'RS Elementor Addons', 'rsaddon' ),
                'icon' => 'fa fa-smile-o',
            ]
        );
    }

	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'rsaddon' ),
			'<strong>' . esc_html__( 'RS Addon Custom Elementor Addon', 'rsaddon' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'rsaddon' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'rsaddon' ),
			'<strong>' . esc_html__( 'RS Addon Custom Elementor Addon', 'rsaddon' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'rsaddon' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'rsaddon' ),
			'<strong>' . esc_html__( 'RS Addon Custom Elementor Addon', 'rsaddon' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'rsaddon' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {
		
		require_once( __DIR__ . '/widgets/heading/heading.php' );
		require_once( __DIR__ . '/widgets/dual-heading/dual-heading.php' );
		require_once( __DIR__ . '/widgets/animated-heading/animated-heading.php' );
		require_once( __DIR__ . '/widgets/team-member/team-grid-widget.php' );		
		require_once( __DIR__ . '/widgets/counter/rs-counter.php' );
		require_once( __DIR__ . '/widgets/services/rs-service-grid.php' );
		require_once( __DIR__ . '/widgets/portfolio-grid/portfolio-grid-widget.php' );
		require_once( __DIR__ . '/widgets/video/rs-video.php' );
		require_once( __DIR__ . '/widgets/pricing-table/pricing-table.php' );
		require_once( __DIR__ . '/widgets/logo-widget/logo.php' );	
		require_once( __DIR__ . '/widgets/button/button.php' );
		require_once( __DIR__ . '/widgets/cta/cta.php' );
		require_once( __DIR__ . '/widgets/testimonial/testimonail-widget.php' );
		require_once( __DIR__ . '/widgets/flip-box/flip-box.php' );
		require_once( __DIR__ . '/widgets/tab/tab.php' );
		require_once( __DIR__ . '/widgets/iconbox/rs-iconbox.php' );
		require_once( __DIR__ . '/widgets/blog-grid/blog-grid-widget.php' );
		require_once( __DIR__ . '/widgets/number/rs-number.php' );
		require_once( __DIR__ . '/widgets/cf7/contact-cf7.php' );
		require_once( __DIR__ . '/widgets/progress/rs-progress.php' );
		require_once( __DIR__ . '/widgets/contact-box/contact-box.php' );		
		require_once( __DIR__ . '/widgets/tooltip/rs-tooltip.php' );		
		require_once( __DIR__ . '/widgets/static-product/static-product.php' );	
		require_once( __DIR__ . '/widgets/faq/rs-faq.php' );	
		require_once( __DIR__ . '/widgets/image-widget/image.php' );	
		require_once( __DIR__ . '/widgets/business-hour/rs-hour.php' );	
		
		

		// Register widget
		
		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_Heading_Widget() );

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_Heading_dual_Widget() );

		

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_Animated_Heading_Widget());

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_Team_Grid_Widget() );
		
		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Portfolio_lite_Grid_Widget() );		

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_RSCounter_Widget() );

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_RSservices_Grid_Widget() );
		
		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_RSvideo_Widget() );
		
		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_Pricing_Table_Widget() );
		
		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_lite_Button_Widget() );

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_lite_Logo_Showcase_Widget() );

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_lite_CTA_Widget() );

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_lite_Testimonial_Grid_Widget() );
		
		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_lite_Flip_Box_Widget() );

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_lite_Tab_Widget() );

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_RSIcon_Box_Widget() );

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_Blog_Grid_Widget() );
		
		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_RSnumber_Grid_Widget() );		

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_RSCF7_Widget() );

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_progress_Widget() );
		
		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_RScontactbox_Grid_Widget() );

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_RSTooltip_Box_Widget() );

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_RSStatic_Product_Widget() );

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_Faq_Widget() );

		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_lite_Image_Showcase_Widget() );
		
		\Elementor\Plugin::instance()->widgets_manager->register( new \Rsaddon_Elementor_lite_Business_Hour_Widget() );

	}
}
Rsaddon_Elementor_lite_Extension::instance();