<?php if ( post_password_required() ) : ?>
<p><?php _e( 'This post is password protected. Enter the password to view any comments.', ANPS_TEMPLATE_LANG); ?></p>
<?php return; endif; ?>
<?php if ( have_comments() ) : ?>
    <h2 class="comment-heading"><?php echo __('Comments', ANPS_TEMPLATE_LANG) . " (".get_comments_number().")"; ?></h2>
	<ul class="comment-list">
        <?php
    	   wp_list_comments(array( 'callback' => 'anps_comment' )); 
        ?>
	</ul>
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
	<?php previous_comments_link( __( '&larr; Older Comments', ANPS_TEMPLATE_LANG) ); ?>
	<?php next_comments_link( __( 'Newer Comments &rarr;', ANPS_TEMPLATE_LANG) ); ?>
<?php endif; ?>
<?php else :
	if ( ! comments_open() ) :
?>
	<p><?php _e( 'Comments are closed.', ANPS_TEMPLATE_LANG); ?></p>
<?php endif; ?>
<?php endif; ?>
    
        
<?php 
if(!isset($fields)) {
    $fields =  array(
        'author' => '<input type="text" id="author" name="author" placeholder="'. __( 'Name', ANPS_TEMPLATE_LANG).'">',
        'email'  => '<input type="text" id="email" name="email" placeholder="'. __( 'E-mail', ANPS_TEMPLATE_LANG).'">'
    ); 
}
if ( is_user_logged_in() ) {
    $defaults = array(
    'fields'               => apply_filters( 'comment_form_default_fields', $fields),
    'comment_field'        => '<textarea id="message" placeholder="' . __("Message", ANPS_TEMPLATE_LANG) . '" name="comment" rows="5"></textarea>',
    'must_log_in'          => '<p class="must-log-in">You must be logged in to leave a reply.</p>',
    'logged_in_as'         => '<h2 class="comment-heading">' . __('Leave a reply', ANPS_TEMPLATE_LANG) . '</h2><div id="comment-form">',
    'comment_notes_before' => '<h2 class="comment-heading">' . __('Leave a reply', ANPS_TEMPLATE_LANG) . '</h2><div id="comment-form">',
    'title_reply' => '',
    'comment_notes_after'  => '<button data-form="submit" class="btn-style-1 btn-lg">Submit</button>
                               <button data-form="clear" class="btn-style-1 btn-lg">Clear</button>                          
                               </div>',
    'id_form'              => 'commentform',
    'id_submit'            => 'submit'
 );
} else {
    $defaults = array(
    'fields'               => apply_filters( 'comment_form_default_fields', $fields),
    'comment_field'        => '</div><div class="col-md-6"><textarea id="message" placeholder="' . __("Message", ANPS_TEMPLATE_LANG) . '" name="comment" rows="5"></textarea>',
    'must_log_in'          => '<p class="must-log-in">You must be logged in to leave a reply.</p>',
    'logged_in_as'         => '<h2 class="comment-heading">' . __('Leave a reply', ANPS_TEMPLATE_LANG) . '</h2><div id="comment-form">',
    'comment_notes_before' => '<h2 class="comment-heading">' . __('Leave a reply', ANPS_TEMPLATE_LANG) . '</h2><div id="comment-form"><div class="col-md-6">',
    'title_reply' => '',
    'comment_notes_after'  => '<button data-form="submit" class="btn-style-1 btn-lg">Submit</button>
                               <button data-form="clear" class="btn-style-1 btn-lg">Clear</button> 
                               </div></div>',
    'id_form'              => 'commentform',
    'id_submit'            => 'submit'
 );
}
comment_form( $defaults ); 