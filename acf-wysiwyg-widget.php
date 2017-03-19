<?php

/*
 * Plugin Name:       ACF WYSIWYG Widget
 * Plugin URI:        https://github.com/wolozo/ACF-WYSIWYG-Widget
 * GitHub Plugin URI: https://github.com/wolozo/ACF-WYSIWYG-Widget
 * Description:       ACF Pro Widget to add a WYSIWYG Widget.
 * Version:           1.0.0
 * Author:            Wolozo
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       acf-wysiwyg-widget
 * Requires WP:       4.3
 * Requires PHP:      5.3
 */

/**
 * Test for required plugins
 */
function w_acfww_checkPlugins() {
  $thisPlugin = '<b>ACF WYSIWYG Widget</b>';

  if ( ! function_exists( 'acf_add_options_page' ) && current_user_can( 'manage_options' ) ) {

    add_action( 'admin_notices',
      function () use ( &$thisPlugin ) {
        $ACFPlugin = "<a href='https://www.advancedcustomfields.com/'>Advanced Custom Fields PRO</a>";
        ?>

        <div class="notice notice-warning">
          <p><?php _e( "The plugin $ACFPlugin is required. Please install and activate it or deactivate the plugin $thisPlugin",
                       'acf-wysiwyg-widget' ); ?></p>
        </div>

      <?php } );
  }
}

add_action( 'admin_init', 'w_acfww_checkPlugins' );

/**
 * Add ACF fields
 */
function w_acfww_fields() {
  if ( function_exists( 'acf_add_local_field_group' ) ):

    acf_add_local_field_group( array(
                                 'key'                   => 'group_58cea87aed030',
                                 'title'                 => 'ACF WYSIWYG Widget',
                                 'fields'                => array(
                                   array(
                                     'key'               => 'field_58ceaf237001b',
                                     'label'             => 'Title',
                                     'name'              => 'acfww_title',
                                     'type'              => 'text',
                                     'instructions'      => '',
                                     'required'          => 0,
                                     'conditional_logic' => 0,
                                     'wrapper'           => array(
                                       'width' => '100',
                                       'class' => '',
                                       'id'    => '',
                                     ),
                                     'default_value'     => '',
                                     'placeholder'       => '',
                                     'prepend'           => '',
                                     'append'            => '',
                                     'maxlength'         => '',
                                   ),
                                   array(
                                     'key'               => 'field_58cea88293fc9',
                                     'label'             => 'Content',
                                     'name'              => 'acfww_wysiwyg',
                                     'type'              => 'wysiwyg',
                                     'instructions'      => '',
                                     'required'          => 0,
                                     'conditional_logic' => 0,
                                     'wrapper'           => array(
                                       'width' => '100',
                                       'class' => '',
                                       'id'    => '',
                                     ),
                                     'default_value'     => '',
                                     'tabs'              => 'all',
                                     'toolbar'           => 'full',
                                     'media_upload'      => 1,
                                     'delay'             => 1,
                                   ),
                                 ),
                                 'location'              => array(
                                   array(
                                     array(
                                       'param'    => 'widget',
                                       'operator' => '==',
                                       'value'    => 'acf_wysiwyg_widget',
                                     ),
                                   ),
                                 ),
                                 'menu_order'            => 0,
                                 'position'              => 'normal',
                                 'style'                 => 'default',
                                 'label_placement'       => 'top',
                                 'instruction_placement' => 'label',
                                 'hide_on_screen'        => '',
                                 'active'                => 1,
                                 'description'           => '',
                               ) );

  endif;
}

add_action( 'acf/init', 'w_acfww_fields' );


/**
 * Class ACF_WYSIWYG_Widget
 */
class ACF_WYSIWYG_Widget extends WP_Widget {

  function ACF_WYSIWYG_Widget() {
    parent::__construct( false,
                         $name = __( 'ACF WYSIWYG', 'acf-wysiwyg-widget' ),
                         array(
                           'description' => __( 'WYSIWYG field', 'acf-wysiwyg-widget' )
                         ) );
  }

  function form( $instance ) { }

  function widget( $args, $instance ) {

    $widget = 'widget_' . $args[ 'widget_id' ];

    echo $args[ 'before_widget' ];
    echo $args[ 'before_title' ] . get_field( 'acfww_title', $widget ) . $args[ 'after_title' ];
    echo '<div class="acfww-content">' . get_field( 'acfww_wysiwyg', $widget ) . '</div>';
    echo $args[ 'after_widget' ];
  }
}

add_action( 'widgets_init', create_function( '', 'return register_widget("ACF_WYSIWYG_Widget");' ) );
