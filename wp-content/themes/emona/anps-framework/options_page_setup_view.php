<?php 
	include_once 'classes/Options.php';
	$page_data = $options->get_page_setup_data();
	if (isset($_GET['save_page_setup'])) {  
		$options->save_page_setup();}
		?>
		<form action="themes.php?page=theme_options&sub_page=options_page_setup&save_page_setup" method="post">
			<div class="content-top"><input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>" />
				<div class="clear"></div>
			</div>
			<div class="content-inner">

			<!-- Page setup -->

			<h3><?php _e("Page setup:", ANPS_TEMPLATE_LANG); ?></h3>

			<!-- Error page -->
			<div class="input">
			<label for="error_page">
			<?php _e("404 error page", ANPS_TEMPLATE_LANG); ?></label>
			<select name="error_page">
				<option value="0">*** Select ***</option>
				<?php 
					$pages = get_pages();
					foreach ($pages as $item) :
						if ($page_data['error_page'] == $item->ID) {
							$selected = 'selected="selected"';
						}
						else {         
							$selected = '';
						}
				?>      <option value="<?php echo $item->ID; ?>" <?php echo $selected; ?>><?php echo $item->post_title; ?></option>                 <?php endforeach; ?>            </select>        </div> <!-- Footer -->        <div class="input">            <label for="footer_style"><?php _e("Footer style", ANPS_TEMPLATE_LANG); ?></label>            <select name="footer_style">                <option value="0">*** Select ***</option>                <?php $pages = array("1"=>'2 columns', "2" => '4 columns', "3" => '2+4 columns');                foreach ($pages as $key => $item) :                    if (get_option('footer_style') == $key)                         $selected = 'selected="selected"';                    else                         $selected = '';                    ?>                    <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $item; ?></option>                 <?php endforeach; ?>            </select>        </div>        <hr/>        



			<!-- Blog page -->
			<h3><?php _e("Blog page:", ANPS_TEMPLATE_LANG); ?></h3>
			<div class="input">
			<label for="before_blog"><?php _e("Before blog content", ANPS_TEMPLATE_LANG); ?></label>
			<?php $value2 = get_option('anps_before_blog', ''); 
			wp_editor($value2, 'before_blog', array(                'wpautop'       => true,                'media_buttons' => false,                'textarea_name' => 'anps_before_blog',                'textarea_rows' => 10,                'teeny'         => true,                )); ?>        </div>    </div>    <div class="content-top" style="border-style: solid none; margin-top: 70px">        <input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>">        <div class="clear"></div>    </div></form>