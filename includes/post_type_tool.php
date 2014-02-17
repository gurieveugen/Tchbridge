<?php

class PostTypeTool{
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct()
	{
		// =========================================================
		// Hooks and actions
		// =========================================================
		add_action('init', array($this, 'createPostTypeTool'));		
		add_action('add_meta_boxes', array($this, 'metaBoxToolsOptions'));
		add_action('save_post', array($this, 'saveToolsOptions'), 0);	
		add_image_size('tool-img', 100, 100, true);
		add_image_size('tool-small-img', 60, 40, false);
	}

	/**
	 * Create Tools post type and his taxonomies
	 */
	public function createPostTypeTool()
	{

		$post_labels = array(
			'name'               => __('Tool'),
			'singular_name'      => __('Tool'),
			'add_new'            => __('Add new'),
			'add_new_item'       => __('Add new tool'),
			'edit_item'          => __('Edit tool'),
			'new_item'           => __('Add new tool'),
			'all_items'          => __('Tools'),
			'view_item'          => __('View Tool'),
			'search_items'       => __('Search tools'),
			'not_found'          => __('Tools no found'),
			'not_found_in_trash' => __('Tools no found in trash'),
			'parent_item_colon'  => '',
			'menu_name'          => __('Tools'));

		$post_args = array(
			'labels'             => $post_labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'tool' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'taxonomies'         => array('tool_cat'),
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ));

		$tax_labels = array(
			'name'              => __('Tools categories'),
			'singular_name'     => __('Tool category'),
			'search_items'      => __('Search tools categories'),
			'all_items'         => __('All tools categories'),
			'parent_item'       => __('Parent tool category'),
			'parent_item_colon' => __('Parent tool category'),
			'edit_item'         => __('Edit tool category'),
			'update_item'       => __('Update tool category'),
			'add_new_item'      => __('Add new tool category'),
			'new_item_name'     => __('New tool category name'),
			'menu_name'         => __('Tools categories'));

		$tax_args = array(
			'hierarchical'      => true,
			'labels'            => $tax_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'tool_cat' ));

		register_post_type('tool', $post_args);
		register_taxonomy('tool_cat', array('tool'), $tax_args);
	}

	/**
	 * Get members objects
	 * @param  integer $count 
	 * @param  boolean $rand  
	 * @return array
	 */
	public function getTools($args = null)
	{
		$options  = $GLOBALS['gcoptions']->getAllOptions(); 
		$defaults = array(
			'posts_per_page'   => intval($options['tools_per_page']),
			'offset'           => 0,
			'order'            => 'DESC',
			'post_type'        => 'tool',
			'post_status'      => 'publish',			
			'suppress_filters' => true );
		if($args) $arr = array_merge($defaults, $args);
		else $arr = $defaults;

		$tools = get_posts($arr);
		foreach ($tools as $key => $value) 
		{
			$value->meta     = get_post_meta($value->ID, 'tools_options', true);
			$out[$value->ID] = $value;
		}
		return $out; 
	}

	/**
	 * Add GCEvents meata box
	 */
	public function metaBoxToolsOptions($post_type)
	{
		$post_types = array('tool');
		if(in_array($post_type, $post_types))
		{
			add_meta_box('metaBoxToolsOptions', __('Tools Options'), array($this, 'metaBoxToolsOptionsRender'), $post_type, 'side', 'high');	
		}
		
	}

	/**
	 * render Slider Meta box
	 */
	public function metaBoxToolsOptionsRender($post)
	{
		$tools_options    = get_post_meta($post->ID, 'tools_options', true);		
		wp_nonce_field( 'tools_options_box', 'tools_options_box_nonce' );

		?>	
		<div class="gcslider">				
			<p>
				<label for="tools_options_question"><?php _e('Question'); ?>:</label>
				<textarea name="tools_options[question]" id="tools_options_question" class="w100" cols="25" rows="10"><?php echo $tools_options['question']; ?></textarea>				
			</p>	
		</div>	

		<div class="gcslider">				
			<p>
				<label for="tools_options_tool_tip"><?php _e('Tool tip'); ?>:</label>
				<textarea name="tools_options[tool_tip]" id="tools_options_tool_tip" cols="25" class="w100" rows="10"><?php echo $tools_options['tool_tip']; ?></textarea>
			</p>	
		</div>	
		<?php
	}

	/**
	 * Save post
	 * @param  integer $post_id
	 * @return integer
	 */
	public function saveToolsOptions($post_id)
	{
		// =========================================================
		// Check nonce
		// =========================================================
		if(!isset( $_POST['tools_options_box_nonce'])) return $post_id;
		if(!wp_verify_nonce($_POST['tools_options_box_nonce'], 'tools_options_box')) return $post_id;
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
		if(isset($_POST['tools_options']))
		{
			update_post_meta($post_id, 'tools_options', $_POST['tools_options']);
		}

		return $post_id;
	}
}

// =========================================================
// LAUNCH
// =========================================================
$GLOBALS['post_type_tool'] = new PostTypeTool();