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
		add_action('admin_head', array($this, 'customStylesAndScript'));
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
			add_meta_box('metaBoxToolsOptions', __('Tools Options'), array($this, 'metaBoxToolsOptionsRender'), $post_type, 'normal', 'high');	
		}
		
	}

	/**
	 * render Slider Meta box
	 */
	public function metaBoxToolsOptionsRender($post)
	{
		$index         = 1; 
		$tools_options = get_post_meta($post->ID, 'tools_options', true);		
		wp_nonce_field( 'tools_options_box', 'tools_options_box_nonce' );
		?>	
		<table id="questions" class="questions">
			<tbody>
				<tr>
					<th>#</th>
					<th><?php _e('Question'); ?></th>
					<th><?php _e('Tool tip'); ?></th>
				</tr>
				<?php
				if($tools_options['question'])
				{
					foreach ($tools_options['question'] as $key => $value) 
					{
						echo '<tr>';
						echo '<td><b>'.$index++.'</b></td>';
						echo '<td><textarea name="tools_options[question]['.$key.']" class="w100" cols="25" rows="4">'.$tools_options['question'][$key].'</textarea></td>';
						echo '<td><textarea name="tools_options[tool_tip]['.$key.']" class="w100" cols="25" rows="4">'.$tools_options['tool_tip'][$key].'</textarea></td>';						
						echo '</tr>';	
					}	
				}
				?>				
			</tbody>
		</table>
		<button type="button" onclick="addQuestion('questions');" class="button button-large"><?php _e('Add question'); ?></button>		
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
			if(is_array($_POST['tools_options']))
			{
				foreach ($_POST['tools_options']['question'] as $key => $value) 
				{
					if($value == "")
					{
						unset($_POST['tools_options']['question'][$key]);
						unset($_POST['tools_options']['tool_tip'][$key]);
					}
				}	
			}
			
			update_post_meta($post_id, 'tools_options', $_POST['tools_options']);
		}

		return $post_id;
	}

	/**
	* Custom CSS and Script for admin backend
	*/
	public function customStylesAndScript() 
	{
	?>
		<style type="text/css">
		.questions{
			width: 100%;
			text-align: left;
			border-collapse: collapse;
			border-spacing: 0;
			margin-bottom: 30px;
		}

		.questions thead th{
			border-bottom: 2px solid #DDDDDD;
		}

		.questions tbody tr:nth-child(odd) td,
		.questions tbody tr:nth-child(odd) th {
		  background-color: #f9f9f9;
		}

		.questions tbody tr:hover td,
		.questions tbody tr:hover th {
		  background-color: #f5f5f5;
		}

		.questions tbody tr{
			border-top: 1px solid #DDDDDD;
		}

		.questions thead tr th,
		.questions tbody tr td{
			padding: 10px 5px;
		}

		.questions tbody tr td textarea{
			width: 100%;
		}
		</style>
		<script type='text/javascript'>
			function addQuestion(id)
			{			
				jQuery('#' + id + ' tbody').append('<tr><td></td><td><textarea name="tools_options[question][]" class="w100" cols="25" rows="4"></textarea></td> <td><textarea name="tools_options[tool_tip][]" class="w100" cols="25" rows="4"></textarea></td></tr>');
			}
		</script>
		<?php

	}
}

// =========================================================
// LAUNCH
// =========================================================
$GLOBALS['post_type_tool'] = new PostTypeTool();