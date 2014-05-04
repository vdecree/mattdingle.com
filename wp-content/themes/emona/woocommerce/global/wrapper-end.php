<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
?>

<?php
$meta = get_post_meta(get_option('woocommerce_shop_page_id'));

$num_of_sidebars = 0;
$left_sidebar = 0;
if (isset($meta['sbg_selected_sidebar']) && !is_product()) {
    $left_sidebar = $meta['sbg_selected_sidebar'];
    if($left_sidebar[0] != "0") {
        $num_of_sidebars++;   
    }
}

$right_sidebar = 0;
if (isset($meta['sbg_selected_sidebar_replacement']) && !is_product()) {
    $right_sidebar = $meta['sbg_selected_sidebar_replacement'];
    if($right_sidebar[0] != "0") {
        $num_of_sidebars++;   
    }
}

?>
<?php if (isset($right_sidebar[0]) && $right_sidebar[0] != "0"): ?>
<aside class="sidebar right col-md-<?php if($num_of_sidebars == 1) { echo "3"; } else if($num_of_sidebars == 2) { echo "3"; } ?> clearfix">
    <ul>
        <?php dynamic_sidebar($right_sidebar[0]); ?>
    </ul>
</aside>   
<?php endif; ?>

	</div>
</div>