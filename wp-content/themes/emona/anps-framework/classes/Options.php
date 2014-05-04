<?php 
include_once 'Framework.php';
class Options extends Framework {
    /* Save page layout data (page layout, copyright, top menu) */
    public function save_page() {
        update_option($this->prefix.'acc_info',$_POST);
        header("Location: themes.php?page=theme_options&sub_page=options");
    }
    
    /* Get page layout data */
    public function get_page_data() {
        return get_option($this->prefix.'acc_info');
    }
 
    /* Get shop data */
    public function get_shop_setup_data() {
        return get_option($this->prefix.'shop_setup');
    }
    /* Save page setup data (error, blog, portfolio page) */
    public function save_page_setup() { 
        update_option($this->prefix.'page_setup',$_POST);
        if($_POST['front_page']) {
            update_option('page_on_front',$_POST['front_page']);
            update_option('show_on_front', 'page'); 
        }
        update_option('footer_style',$_POST['footer_style']);
        update_option('anps_before_blog',stripslashes($_POST['anps_before_blog']));
        header("Location: themes.php?page=theme_options&sub_page=options_page_setup");
    }
    
    /* Get page setup data */
    public function get_page_setup_data() {
        return get_option($this->prefix.'page_setup');
    }
    
    /* Save social account data */
    public function save_social() {
        update_option($this->prefix.'social_info', $_POST);
        header("Location: themes.php?page=theme_options&sub_page=options_social_accounts");
    }
    
    /* Save page setup data (error, blog, portfolio page) */
    public function save_shop_setup() {
        $page_data = $this->get_shop_setup_data(); 
        update_option($this->prefix.'shop_setup',$_POST);
        header("Location: themes.php?page=theme_options&sub_page=shop_settings");
    }
    
    /* Get social account data */
    public function get_social() {
        return get_option($this->prefix."social_info");
    }
    
    /* Save media*/
    public function save_media() {
        update_option($this->prefix.'media_info', $_POST);
        header("Location: themes.php?page=theme_options&sub_page=options_media");
    }
    
    /* Get media */
    public function get_media() {
        return get_option($this->prefix.'media_info');
    }
}
$options = new Options();