<?php
define ("COLOMBIA_WIDGET_ID","colombia");
class WP_Widget_Colombia extends WP_Widget {

    private static $counter;
    function __construct() {

        $widget_ops = array('classname' => 'colombia_widget', 'description' => __( "Colombia widget for your site.") );
        parent::__construct( COLOMBIA_WIDGET_ID, _x( 'Colombia', 'Colombia' ), $widget_ops );
        $this->plugin_directory = plugin_dir_path(__FILE__);
    }

   function widget( $args, $instance ) {
        if (!isset(WP_Widget_Colombia::$counter)){
            WP_Widget_Colombia::$counter = 1;
        }
        else{
            WP_Widget_Colombia::$counter = WP_Widget_Colombia::$counter + 1;
        }
        if (trim($instance['widget_id']) == ''){
            return;
        }
        extract($args);

        $tmp_id = explode("-",$args["widget_id"]);
        $widget_num = $tmp_id[1];
        $widget_id = ! empty( $instance['widget_id'] ) ? $instance['widget_id'] : '';
        echo '<div class="colombia" data-slot="'.$widget_id.'" data-position="'.$widget_num.'" data-selection="0" id="div_clmb_'.$widget_id.'_'.$widget_num.'"></div>';        
    }

   function form( $instance ) {
        $instance = wp_parse_args( (array) $instance );
        $widget_id = esc_attr( $instance['widget_id'] );
        ?>
        <div style="margin:10px">
            <label for="<?php echo $this->get_field_id('widget_id'); ?>"><?php _e('AdSlot ID:'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('widget_id'); ?>" name="<?php echo $this->get_field_name('widget_id'); ?>" type="text" value="<?php echo esc_attr($widget_id); ?>" style="height:20px;margin:5px" />
            </label>
        </div>
    <?php
    }

   function update( $new_instance, $old_instance ) {

        // canceling save if the field is empty
        if (strip_tags($new_instance['widget_id']) == ""){
            return false;
	    }

        $instance = $old_instance;
        $instance['widget_id'] = strip_tags($new_instance['widget_id']);

        return $instance;
    }

}
add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_Colombia");'));
