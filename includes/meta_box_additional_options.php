<?php

// =========================================================
// Hooks
// =========================================================
add_action('add_meta_boxes', 'metaBoxAdditionalOptions');
add_action('save_post', 'saveAdditionalOptions', 0);	

/**
 * Add GCEvents meata box
 */
function metaBoxAdditionalOptions($post_type)
{
	$post_types = array('page', 'post');
	if(in_array($post_type, $post_types))
	{
		add_meta_box('metaBoxAdditionalOptions', __('Additional Options'), 'metaBoxAdditionalOptionsRender', $post_type, 'side', 'high');	
	}
	
}

/**
 * render Slider Meta box
 */
function metaBoxAdditionalOptionsRender($post)
{
	$additional_options    = get_post_meta($post->ID, 'additional_options', true);		
	wp_nonce_field( 'additional_options_box', 'additional_options_box_nonce' );

	?>	
	<div class="gcslider">				
		<p>
			<label for="additional_options_embed_code"><?php _e('Link title ( if you leave this field blank will be displayed DOWNLOAD REPORT )'); ?>:</label>
			<input type="text" name="additional_options[link_title]" id="additional_options_link_title" class="w100" value="<?php echo $additional_options['link_title']; ?>">
		</p>	
	</div>	
	<div class="gcslider">				
		<p>
			<label for="additional_options_embed_code"><?php _e('External url ( PDF )'); ?>:</label>
			<input type="text" name="additional_options[external_url]" id="additional_options_external_url" class="w100" value="<?php echo $additional_options['external_url']; ?>">
		</p>	
	</div>		
	<div class="gcslider">				
		<p>
			<label for="additional_options_embed_code"><?php _e('Open in'); ?>:</label>
			<select name="additional_options[open_in]" id="additional_options_open_in" class="w100">
				<option value="0" <?php selected(intval($additional_options['open_in']) == 0); ?>><?php _e('New tab'); ?></option>
				<option value="1" <?php selected(intval($additional_options['open_in']) == 1); ?>><?php _e('Current tab'); ?></option>
			</select>
			
		</p>	
	</div>	
	<?php
}

/**
 * Save post
 * @param  integer $post_id
 * @return integer
 */
function saveAdditionalOptions($post_id)
{
	// =========================================================
	// Check nonce
	// =========================================================
	if(!isset( $_POST['additional_options_box_nonce'])) return $post_id;
	if(!wp_verify_nonce($_POST['additional_options_box_nonce'], 'additional_options_box')) return $post_id;
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
	if(isset($_POST['additional_options']))
	{
		update_post_meta($post_id, 'additional_options', $_POST['additional_options']);
	}

	return $post_id;
}
