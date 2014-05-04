<?php
include_once 'classes/Options.php';

$page_data = $options->get_shop_setup_data();
if (isset($_GET['save_shop_setup']))
  $options->save_shop_setup();
?>
<form action="themes.php?page=theme_options&sub_page=shop_settings&save_shop_setup" method="post">   
    <div class="content-top"><input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>" /><div class="clear"></div></div>
    <div class="content-inner">
        <!-- Page setup -->
        <h3><?php _e("Shop setup:", ANPS_TEMPLATE_LANG); ?></h3>
        <!-- Shop number of columns -->
        <div class="input"> 
            <label for="shop_pagination"><?php _e("Number of columns", ANPS_TEMPLATE_LANG); ?></label>
            <?php $pag_type = array('2 column', '3 column', '4 column', '5 column'); ?>
            <select name="shop_pagination">
                <?php
                foreach ($pag_type as $item) :
                    if ($page_data['shop_pagination'] == $item) 
                        $selected = 'selected="selected"';
                    else 
                        $selected = '';
                    ?>
                    <option value="<?php echo $item; ?>" <?php echo $selected; ?>><?php echo $item; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Shop number of products -->
        <div class="input"> <?php if (!isset($page_data['shop_per_page'])) $page_data['shop_per_page'] = ''; ?>
            <label for="shop_per_page"><?php _e("Products per page", ANPS_TEMPLATE_LANG); ?></label>
            <input type="text" name="shop_per_page" value="<?php echo $page_data['shop_per_page']; ?>"/>
        </div>
        <!-- Product style -->
        <div class="input"> 
            <label for="product_style"><?php _e("Product style", ANPS_TEMPLATE_LANG); ?></label>
            <?php $pag_type = array('Style 1', 'Style 2'); ?>
            <select name="product_style">
                <?php
                foreach ($pag_type as $item) :
                    if ($page_data['product_style'] == $item) 
                        $selected = 'selected="selected"';
                    else 
                        $selected = '';
                    ?>
                    <option value="<?php echo $item; ?>" <?php echo $selected; ?>><?php echo $item; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php 
        if(!isset($page_data['shop-hide-cart']))
            $checked='';
        elseif ($page_data['shop-hide-cart'] == '-1')
            $checked = '';
        elseif ($page_data['shop-hide-cart'] == '')
            $checked = '';
        else
            $checked = 'checked';
        ?>
        <label for="shop-hide-cart"><?php _e("Hide header cart", ANPS_TEMPLATE_LANG); ?></label>
        <input class="small_input" style="margin-left: 74px" type="checkbox" name="shop-hide-cart" <?php echo $checked; ?> />
        <?php 
        if(!isset($page_data['shop-empty-stars']))
            $checked='';
        elseif ($page_data['shop-empty-stars'] == '-1')
            $checked = '';
        elseif ($page_data['shop-empty-stars'] == '')
            $checked = '';
        else
            $checked = 'checked';
        ?>
        <label for="shop-empty-stars"><?php _e("Show empty stars on products with no rating", ANPS_TEMPLATE_LANG); ?></label>
        <input class="small_input" style="margin-left: 74px" type="checkbox" name="shop-empty-stars" <?php echo $checked; ?> />
        <?php 
        if(!isset($page_data['shop-second-img']))
            $checked='';
        elseif ($page_data['shop-second-img'] == '-1')
            $checked = '';
        elseif ($page_data['shop-second-img'] == '')
            $checked = '';
        else
            $checked = 'checked';
        ?>
        <label for="shop-second-img"><?php _e("Show second image on shop product hover", ANPS_TEMPLATE_LANG); ?></label>
        <input class="small_input" style="margin-left: 74px" type="checkbox" name="shop-second-img" <?php echo $checked; ?> />
        <!-- Content before Shop page -->
        <div class="input">
        <label for="before_shop"><?php _e("Before shop content", ANPS_TEMPLATE_LANG); ?></label>
        <?php wp_editor( stripslashes($page_data['anps_before_shop']), "before_shop", $settings = array('wpautop' => true, 
                                                'media_buttons' => false, 
                                                'textarea_name' => 'anps_before_shop', 
                                                'textarea_rows' => 10, 
                                                'teeny'         => true) ); ?>
    </div></div>

    <div class="content-top" style="border-style: solid none; margin-top: 70px">
        <input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>">
        <div class="clear"></div>
    </div>
</form>