<?php

class ToolOptions{
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  

	public function __construct()
	{
		// =========================================================
		// HOOKS
		// =========================================================	
		add_action('add_meta_boxes', array($this, 'metaBoxToolOptions'));
		add_action('save_post', array($this, 'saveToolOptions'), 0);
		add_filter('manage_edit-tool_columns', array($this, 'columnPosition'));	
		add_action('manage_posts_custom_column', array($this, 'columnPositionShow'), 10, 2);
	}

	/**
	 * Register new column
	 * @param  array $columns 
	 * @return array
	 */
	public function columnPosition($columns)
	{
		return array_merge($columns, array('position' => __('Position')));
	}

	/**
	 * Display new column
	 * @param  string  $column  
	 * @param  integer $post_id           
	 */
	public function columnPositionShow($column, $post_id)
	{
		$position = $this->getOptions($post_id);
		
		switch ($column) 
		{
			case 'position':
				echo $position;
				break;
		}
	}

	/**
	 * Add GCEvents meata box
	 */
	public function metaBoxToolOptions($post_type)
	{
		$post_types = array('tool');
		if(in_array($post_type, $post_types))
		{
			add_meta_box('metaBoxToolOptions', __('Tool Options'), array($this, 'metaBoxToolOptionsRender'), $post_type, 'side', 'high');	
		}
		
	}

	/**
	 * render Slider Meta box
	 */
	public function metaBoxToolOptionsRender($post)
	{		
		$position = intval(get_post_meta($post->ID, 'position', true));

		wp_nonce_field( 'tool_options_box', 'tool_options_box_nonce' );
		?>		
		<table>
			<tbody>
				<tr>
					<td><label for="tool_options_external_url"><?php _e('Position'); ?>:</label></td>
					<td><input style="width: 100%" type="text" name="position" id="tool_options_position" class="w100" style="width: 60%;" value="<?php echo $position; ?>"></td>
				</tr>				
			</tbody>
		</table>		
		<?php
	}

	/**
	 * Save post
	 * @param  integer $post_id
	 * @return integer
	 */
	public function saveToolOptions($post_id)
	{
		// =========================================================
		// Check nonce
		// =========================================================
		if(!isset( $_POST['tool_options_box_nonce'])) return $post_id;
		if(!wp_verify_nonce($_POST['tool_options_box_nonce'], 'tool_options_box')) return $post_id;
		if(defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;

		// =========================================================
		// Check the user's permissions.
		// =========================================================
		if ( 'page' == $_POST['post_type'] ) 
		{			
			if (!current_user_can( 'edit_page', $post_id)) return $post_id;
		} 
		else 
		{
			if(!current_user_can( 'edit_post', $post_id)) return $post_id;
		}

		// =========================================================
		// Save
		// =========================================================		
		if(isset($_POST['position']))
		{			
			update_post_meta($post_id, 'position', intval($_POST['position']));
		}

		return $post_id;
	}

	/**
	 * Get post options
	 * @param  integer $id 
	 * @return array     
	 */
	public function getOptions($id)
	{
		return get_post_meta($id, 'position', true);	
	}
}

// =========================================================
// Launch
// =========================================================
$GLOBALS['tool_options'] = new ToolOptions();