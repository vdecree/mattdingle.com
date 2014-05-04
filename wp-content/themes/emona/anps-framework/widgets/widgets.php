<?php
/* Get all widgets */
function get_all_widgets() {
    $dir = get_template_directory() . '/anps-framework/widgets';
    if ($handle = opendir($dir)) {
        $arr = array();
        // Get all files and store it to array
        while (false !== ($entry = readdir($handle))) {
            $arr[] = $entry;
        }
        closedir($handle); 
      
        /* Remove widgets, ., .. */
        unset($arr[remove_widget('widgets.php', $arr)], $arr[remove_widget('.', $arr)], $arr[remove_widget('..', $arr)]);
        return $arr;
    }
}
/* Remove widget function */
function remove_widget($name, $arr) {
    return array_search($name, $arr);
}
/* Include all widgets */ 
foreach(get_all_widgets() as $item) {
    include_once get_template_directory() . '/anps-framework/widgets/'.$item;
} 
/** Register sidebars by running widebox_widgets_init() on the widgets_init hook. */
add_action('widgets_init', 'anps_widgets_init');
function anps_widgets_init() {
    // Area 1, located at the top of the sidebar.
    register_sidebar(array(
        'name' => __('Sidebar', ANPS_TEMPLATE_LANG),
        'id' => 'primary-widget-area',
        'description' => __('The primary widget area', ANPS_TEMPLATE_LANG),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Secondary Sidebar', ANPS_TEMPLATE_LANG),
        'id' => 'secondary-widget-area',
        'description' => __('Secondary widget area', ANPS_TEMPLATE_LANG),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Top bar left', ANPS_TEMPLATE_LANG),
        'id' => 'top-bar-left',
        'description' => __('Can only contain Text, Search, Custom menu and WPML Languge selector widgets', ANPS_TEMPLATE_LANG),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Top bar right', ANPS_TEMPLATE_LANG),
        'id' => 'top-bar-right',
        'description' => __('Can only contain Text, Search, Custom menu and WPML Languge selector widgets', ANPS_TEMPLATE_LANG),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    $footer_columns = get_option('footer_style', '2');
    if($footer_columns=='1') {
        register_sidebar(array(
            'name' => __('Footer left', ANPS_TEMPLATE_LANG),
            'id' => 'footer-left',
            'description' => __('Footer left area', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer right', ANPS_TEMPLATE_LANG),
            'id' => 'footer-right',
            'description' => __('Footer right area', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )); 
    } elseif($footer_columns=='2'  || $footer_columns=='0') {
        register_sidebar(array(
            'name' => __('Footer 1', ANPS_TEMPLATE_LANG),
            'id' => 'footer-1',
            'description' => __('Footer 1', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 2', ANPS_TEMPLATE_LANG),
            'id' => 'footer-2',
            'description' => __('Footer 2', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )); 
        register_sidebar(array(
            'name' => __('Footer 3', ANPS_TEMPLATE_LANG),
            'id' => 'footer-3',
            'description' => __('Footer 3', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 4', ANPS_TEMPLATE_LANG),
            'id' => 'footer-4',
            'description' => __('Footer 4', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } elseif($footer_columns=='3') {
        register_sidebar(array(
            'name' => __('Footer 1', ANPS_TEMPLATE_LANG),
            'id' => 'footer-1',
            'description' => __('Footer 1', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 2', ANPS_TEMPLATE_LANG),
            'id' => 'footer-2',
            'description' => __('Footer 2', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )); 
        register_sidebar(array(
            'name' => __('Footer 3', ANPS_TEMPLATE_LANG),
            'id' => 'footer-3',
            'description' => __('Footer 3', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 4', ANPS_TEMPLATE_LANG),
            'id' => 'footer-4',
            'description' => __('Footer 4', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        
        register_sidebar(array(
            'name' => __('Footer left', ANPS_TEMPLATE_LANG),
            'id' => 'footer-left',
            'description' => __('Footer left area', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer right', ANPS_TEMPLATE_LANG),
            'id' => 'footer-right',
            'description' => __('Footer right area', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )); 
    }
}