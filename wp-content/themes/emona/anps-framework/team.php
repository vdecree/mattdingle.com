<?php
class Team {
    public function __construct() {
        $this->register_post_type();
        register_taxonomy('team_tags', 'team', array('hierarchical' => false, 'label' => 'Tags', 'query_var' => true, 'rewrite' => true));       
    }
    
    private function register_post_type() {
        $args = array(
          'labels' => array(
              'name' =>'Team',
              'singular_name' => 'Team',
              'add_new' => 'Add new',
              'add_new_item' => 'Add new item',
              'edit_item' => 'Edit item',
              'new_item' => 'New item',
              'view_item' => 'View team',
              'search_items' => 'Search team',
              'not_found' => 'No team found'
          ),
            'query_var' => 'team',
            'rewrite' => array(
                'slug' => 'team'
            ),
            'public' => true,
            'supports' => array(
                            'title',
                            'thumbnail',
                            'editor',
                            'tags'
            )
        );
        
       register_post_type('team', $args);
    }
}