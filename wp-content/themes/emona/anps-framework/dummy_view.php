<?php 
include_once 'classes/Dummy.php';

if (isset($_GET['save_dummy']))
            $dummy->save();
?>
<script type="text/javascript"> 
    function dummy () {
        var reply = confirm("WARNING: You have already insert dummy content and by inserting it again, you will have duplicate content.\r\n\We recommend doing this ONLY if something went wrong the first time and you have already cleared the content.");         
        return reply;
    }   
</script>
<form action="themes.php?page=theme_options&sub_page=dummy_content&save_dummy" method="post">
    <div class="content-inner">
        <h3><?php _e("Insert dummy content: posts, pages, categories", ANPS_TEMPLATE_LANG); ?></h3>
        <p><?php _e("If you are new to wordpress or have problems creating posts or pages that look like the theme preview you can import dummy posts and pages here that will definitley help to understand how those tasks are done.", ANPS_TEMPLATE_LANG); ?></p>                   
        <center><input type="submit" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php _e("Insert dummy content", ANPS_TEMPLATE_LANG); ?>" /></center>
    </div>
</form>