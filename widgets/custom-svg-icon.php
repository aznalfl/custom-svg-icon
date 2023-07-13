<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Custom_Svg_Icon_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'custom-svg-icon';
	}

	public function get_title() {
		return __( 'Custom SVG Icon', 'custom-svg-icon' );
	}

	public function get_icon() {
		return 'fa fa-code';
	}

	public function get_categories() {
		return [ 'general' ];
	}

  protected function register_controls() {
      $this->start_controls_section(
          'content_section',
          [
              'label' => __( 'Content', 'custom-svg-icon' ),
              'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
          ]
      );

      $this->add_control(
          'svg_icon',
          [
              'label' => __( 'SVG Icon', 'custom-svg-icon' ),
              'type' => \Elementor\Controls_Manager::MEDIA,
              'dynamic' => [
                  'active' => true,
              ],
              'description' => __( 'Upload your SVG file here.', 'custom-svg-icon' ),
          ]
      );

      $this->add_responsive_control(
          'align',
          [
              'label' => __( 'Alignment', 'custom-svg-icon' ),
              'type' => \Elementor\Controls_Manager::CHOOSE,
              'options' => [
                  'left' => [
                      'title' => __( 'Left', 'custom-svg-icon' ),
                      'icon' => 'fa fa-align-left',
                  ],
                  'center' => [
                      'title' => __( 'Center', 'custom-svg-icon' ),
                      'icon' => 'fa fa-align-center',
                  ],
                  'right' => [
                      'title' => __( 'Right', 'custom-svg-icon' ),
                      'icon' => 'fa fa-align-right',
                  ],
              ],
              'selectors' => [
                  '{{WRAPPER}}' => 'text-align: {{VALUE}};',
              ],
          ]
      );

      $this->add_control(
          'color',
          [
              'label' => __( 'Color', 'custom-svg-icon' ),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                  '{{WRAPPER}} svg' => 'fill: {{VALUE}};',
              ],
          ]
      );

      $this->add_responsive_control(
          'size',
          [
              'label' => __( 'Size', 'custom-svg-icon' ),
              'type' => \Elementor\Controls_Manager::SLIDER,
              'range' => [
                  'px' => [
                      'min' => 1,
                      'max' => 200,
                  ],
              ],
              'selectors' => [
                  '{{WRAPPER}} svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
              ],
          ]
      );

      $this->end_controls_section();
  }

  protected function render() {
      $settings = $this->get_settings_for_display();

      // SVG Icon URL
      $svg_icon_url = $settings['svg_icon']['url'];

      // If the SVG Icon URL is not empty, fetch and sanitize the SVG content
      if ( ! empty( $svg_icon_url ) ) {
          // Get the path of the SVG file on the server
          // This assumes that the SVG file is hosted on the same server as the website
          $svg_file_path = ABSPATH . wp_make_link_relative( $svg_icon_url );

          if ( file_exists( $svg_file_path ) ) {
              // Get the SVG file content
              $svg_content = file_get_contents( $svg_file_path );

              // Sanitize the SVG content
              $svg_content = wp_kses( $svg_content, [
                  'svg' => [
                      'class' => true,
                      'aria-hidden' => true,
                      'aria-labelledby' => true,
                      'role' => true,
                      'xmlns' => true,
                      'width' => true,
                      'height' => true,
                      'viewbox' => true, // <= Must be lower case!
                  ],
                  'title' => [ 'title' => true ],
                  'path' => [ 'd' => true, 'fill' => true ],
              ] );

              // Output the sanitized SVG
              echo $svg_content;
          }
      }
  }
}
?>
