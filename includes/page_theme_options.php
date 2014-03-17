<?php
class GCOptionsPage{
    //                          __              __      
    //   _________  ____  _____/ /_____ _____  / /______
    //  / ___/ __ \/ __ \/ ___/ __/ __ `/ __ \/ __/ ___/
    // / /__/ /_/ / / / (__  ) /_/ /_/ / / / / /_(__  ) 
    // \___/\____/_/ /_/____/\__/\__,_/_/ /_/\__/____/  
    const PARENT_PAGE = 'themes.php';
    const LABEL_KEY   = 'options';
    const NONE        = 666;
    const EVERY_DAY   = 1;
    const EVERY_WEEK  = 2;
    const EVERY_MONTH = 3;
    const EVERY_YEAR  = 4;
    const CUSTOM      = 5;
    //                __  _                 
    //   ____  ____  / /_(_)___  ____  _____
    //  / __ \/ __ \/ __/ / __ \/ __ \/ ___/
    // / /_/ / /_/ / /_/ / /_/ / / / (__  ) 
    // \____/ .___/\__/_/\____/_/ /_/____/  
    //     /_/                              
    private $options;

    //                    __  __              __    
    //    ____ ___  ___  / /_/ /_  ____  ____/ /____
    //   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
    //  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
    // /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        add_submenu_page(self::PARENT_PAGE, __('Theme options'), __('Theme options'), 'administrator', __FILE__, array($this, 'create_admin_page'), 'favicon.ico'); 
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        $this->options = $this->getAllOptions();       

        ?>
        <div class="wrap">
            <?php screen_icon(); ?>                 
            <form method="post" action="options.php">
            <?php                
                settings_fields('gc_options_page');   
                do_settings_sections(__FILE__);
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Get all options
     */
    public function getAllOptions()
    {
        return get_option('gcoptions');
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting('gc_options_page', 'gcoptions', array($this, 'sanitize'));
        add_settings_section('default_settings', __('Options'), null, __FILE__); 

        add_settings_field('youtube_video', __('YouTube video on front page'), array($this, 'youtube_video_callback'), __FILE__, 'default_settings');
        add_settings_field('techbridge_url', __('Techbridge URL'), array($this, 'techbridge_url_callback'), __FILE__, 'default_settings');
        add_settings_field('nsf_url', __('National science foundation URL'), array($this, 'nsf_url_callback'), __FILE__, 'default_settings');
        add_settings_field('twitter_url', __('Twitter URL'), array($this, 'twitter_url_callback'), __FILE__, 'default_settings');
        add_settings_field('facebook_url', __('Facebook URL'), array($this, 'facebook_url_callback'), __FILE__, 'default_settings');
        add_settings_field('designed_by_url', __('Designed by URL'), array($this, 'designed_by_url_callback'), __FILE__, 'default_settings');
        add_settings_field('tools_per_page', __('Tools per page'), array($this, 'tools_per_page_callback'), __FILE__, 'default_settings');
        add_settings_field('tools_per_page_dash', __('Tools per page on Dashboard'), array($this, 'tools_per_page_dash_callback'), __FILE__, 'default_settings');
        add_settings_field('take_survey_url', __('Take survey URL'), array($this, 'take_survey_url_callback'), __FILE__, 'default_settings');
        add_settings_field('hide_check_back_soon', __('Hide "Check back soon for new materials!" box.'), array($this, 'hide_check_back_soon_callback'), __FILE__, 'default_settings');
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize($input)
    {
        $new_input = array();     

        if(isset($input['youtube_video'])) $new_input['youtube_video']               = strip_tags($input['youtube_video']);
        if(isset($input['techbridge_url'])) $new_input['techbridge_url']             = strip_tags($input['techbridge_url']);
        if(isset($input['nsf_url'])) $new_input['nsf_url']                           = strip_tags($input['nsf_url']);
        if(isset($input['twitter_url'])) $new_input['twitter_url']                   = strip_tags($input['twitter_url']);
        if(isset($input['facebook_url'])) $new_input['facebook_url']                 = strip_tags($input['facebook_url']);
        if(isset($input['designed_by_url'])) $new_input['designed_by_url']           = strip_tags($input['designed_by_url']);
        if(isset($input['tools_per_page'])) $new_input['tools_per_page']             = intval($input['tools_per_page']);
        if(isset($input['tools_per_page_dash'])) $new_input['tools_per_page_dash']   = intval($input['tools_per_page_dash']);
        if(isset($input['take_survey_url'])) $new_input['take_survey_url']           = strip_tags($input['take_survey_url']);
        if(isset($input['hide_check_back_soon'])) $new_input['hide_check_back_soon'] = (bool) $input['hide_check_back_soon'];
        

        return $new_input;
    }

    /**
     * Return check text to input control
     * @param  boolean $bool
     * @return string
     */
    public function checked($bool = false)
    {
        if($bool) return 'checked';
        return '';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function youtube_video_callback()
    {
        printf('<input type="text" id="youtube_video" name="gcoptions[youtube_video]" value="%s" />', isset($this->options['youtube_video']) ? esc_attr($this->options['youtube_video']) : '');
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function techbridge_url_callback()
    {
        printf('<input type="text" id="techbridge_url" name="gcoptions[techbridge_url]" value="%s" />', isset($this->options['techbridge_url']) ? esc_attr($this->options['techbridge_url']) : '');
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function nsf_url_callback()
    {
        printf('<input type="text" id="nsf_url" name="gcoptions[nsf_url]" value="%s" />', isset($this->options['nsf_url']) ? esc_attr($this->options['nsf_url']) : '');
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function twitter_url_callback()
    {
        printf('<input type="text" id="twitter_url" name="gcoptions[twitter_url]" value="%s" />', isset($this->options['twitter_url']) ? esc_attr($this->options['twitter_url']) : '');
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function facebook_url_callback()
    {
        printf('<input type="text" id="facebook_url" name="gcoptions[facebook_url]" value="%s" />', isset($this->options['facebook_url']) ? esc_attr($this->options['facebook_url']) : '');
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function designed_by_url_callback()
    {
        printf('<input type="text" id="designed_by_url" name="gcoptions[designed_by_url]" value="%s" />', isset($this->options['designed_by_url']) ? esc_attr($this->options['designed_by_url']) : '');
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function tools_per_page_callback()
    {
        printf('<input type="text" id="tools_per_page" name="gcoptions[tools_per_page]" value="%s" />', isset($this->options['tools_per_page']) ? $this->options['tools_per_page'] : '');
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function tools_per_page_dash_callback()
    {
        printf('<input type="text" id="tools_per_page_dash" name="gcoptions[tools_per_page_dash]" value="%s" />', isset($this->options['tools_per_page_dash']) ? $this->options['tools_per_page_dash'] : '');
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function take_survey_url_callback()
    {
        printf('<input type="text" id="take_survey_url" name="gcoptions[take_survey_url]" value="%s" />', isset($this->options['take_survey_url']) ? $this->options['take_survey_url'] : '');
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function hide_check_back_soon_callback()
    {
        printf('<input type="checkbox" id="hide_check_back_soon" name="gcoptions[hide_check_back_soon]" %s />', isset($this->options['hide_check_back_soon']) ? $this->checked($this->options['hide_check_back_soon'] == 'on') : '');
    }


}
// =========================================================
// LAUNCH
// =========================================================
$GLOBALS['gcoptions'] = new GCOptionsPage();