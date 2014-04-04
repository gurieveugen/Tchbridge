<?php
/**
 * Register new widget
 */
add_action('widgets_init', create_function('', 'register_widget( "SignUpWidget" );'));

class SignUpWidget extends WP_Widget {
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct() 
	{
		$widget_ops     = array('classname' => 'widget-sign-up', 'description' => 'Display Sign up button' );		
		parent::__construct('signupwidget', 'Sign up widget', $widget_ops);
	}

	function widget( $args, $instance ) 
	{
		extract($args);
		if(!is_user_logged_in())
		{
			echo $before_widget;
			echo '<a href="#" class="btn big pink wide" onclick="showHide(true, [\'#sign-up\', \'.lightbox-mask\']); return false;"><span>'.$instance['text_btn'].'</span> <i class="pensil"></i></a>';
			echo '<p>'.$instance['text_below'].'</p>';
			echo $after_widget;	
		}		
	}

	function form($instance) 
	{		
		$text_btn   = $instance['text_btn'];
		$text_below = $instance['text_below'];
		?>
		<table>
			<tbody>
				<tr>
					<th><label for="<?php echo $this->get_field_id('text_btn'); ?>"><?php _e('The button caption:'); ?></label></th>
					<td><input type="text" id="<?php echo $this->get_field_id('text_btn'); ?>" name="<?php echo $this->get_field_name('text_btn'); ?>" value="<?php echo $text_btn; ?>">	</td>
				</tr>
				<tr>
					<th><label for="<?php echo $this->get_field_id('text_below'); ?>"><?php _e('Text below button:'); ?></label></th>
					<td><textarea name="<?php echo $this->get_field_name('text_below'); ?>" id="<?php echo $this->get_field_id('text_below'); ?>" cols="30" rows="10" style="width: 100%;"> <?php echo $text_below; ?></textarea></td>
				</tr>				
			</tbody>
		</table>		
		<?php
	}

	function update( $new_instance, $old_instance ) 
	{
		$instance               = $old_instance;		
		$instance['text_btn']   = strip_tags($new_instance['text_btn']);
		$instance['text_below'] = $new_instance['text_below'];
		
		return $instance;
	}

}