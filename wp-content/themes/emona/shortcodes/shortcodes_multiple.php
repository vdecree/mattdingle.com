<?php 
require_once("../../../../wp-blog-header.php"); 
wp_enqueue_script("jquery");
$posts = get_posts(array('numberposts' => -1)); ?>
<h2 class="h2">Select posts:</h2>
<div id="readmore_1">

<select id="select_values_1">
    <option value="-1">Select post</option>
    <?php foreach($posts as $item) : ?>
    <option value="<?php echo $item->ID; ?>"><?php echo $item->post_title; ?></option>
    <?php endforeach; ?>
</select>
<select id="select_values_2">
    <option value="-1">Select post</option>
    <?php foreach($posts as $item) : ?>
    <option value="<?php echo $item->ID; ?>"><?php echo $item->post_title; ?></option>
    <?php endforeach; ?>
</select>
<select id="select_values_3">
    <option value="-1">Select post</option>
    <?php foreach($posts as $item) : ?>
    <option value="<?php echo $item->ID; ?>"><?php echo $item->post_title; ?></option>
    <?php endforeach; ?>
</select>
<select id="select_values_4">
    <option value="-1">Select post</option>
    <?php foreach($posts as $item) : ?>
    <option value="<?php echo $item->ID; ?>"><?php echo $item->post_title; ?></option>
    <?php endforeach; ?>
</select>
<input type="button" class="submit" value="Create content with menu" onclick="anps_getValue()" />
</div>
<script>
function anps_getValue() { 
    var value1 = document.getElementById('select_values_1').value;
    var value2 = document.getElementById('select_values_2').value;
    var value3 = document.getElementById('select_values_3').value;
    var value4 = document.getElementById('select_values_4').value;
    
    var values = '';
    
    if(value1==-1)
        value1 = '';
    else
        values = value1;
    if(value2==-1)
        value2 = '';
    else {
        if(values!='')
            values += ', ';
        
        values += value2;
    }  
    if(value3==-1)
        value3 = '';
    else {
        if(values!='')
            values += ', ';
        
        values += value3;
    } 
    if(value4==-1)
        value4 = '';
    else {
        if(values!='')
            values += ', ';
        
        values += value4;
    } 
    window.parent.original_send_to_editor("[content_with_menu_wrapper_posts]<br/>" + values + "<br/>[/content_with_menu_wrapper_posts]<br/>");
}
</script>
<style>
    
    .half, .two_quarter {
        width: 281px;
        margin: 15px 0 15px 15px;
        height: 33px;
        float: left;
    }
    
    .third {
        width: 182px;
        margin: 15px 0 15px 15px;
        height: 33px;
        float: left;
    }
    
    .two_third {
        width: 381px;
        margin: 15px 0 15px 15px;
        height: 33px;
        float: left;
    }
    
    .quarter {
        width: 133px;
        margin: 15px 0 15px 15px;
        height: 33px;
        background: red;
        float: left;
    }
    
    .three_quarter {
        width: 431px;
        margin: 15px 0 15px 15px;
        height: 33px;
        background: red;
        float: left;
    }
    
    
    select {
            margin: 0 0 20px 75px;
            padding: 7px 5px;
            width: 335px;
            border: 1px solid #dddddd;
            border-radius: 0px;
    }
    
    select {
        cursor: pointer;
    }
    
    .hidden {
        display: none;
    }
    
    #readmore_1 .box {
        width:  100%;
        height: 65px;
        float: left;
        margin-top: 40px;
        border: 1px solid #dddddd;
        border-radius: 0px;
    }
    
    #readmore_1 {
        padding: 21px;
        font-family: Arial;
        text-align:  center;
        width: 500px;
    }
    
    h2.h2 {
        font-family: Arial !important;
        color: #000000;
        font-size: 16px;
        padding: 21px 0 0 21px;
    }
    
    #readmore_1 ul {
        display: none;
        padding:  0;
        margin:  30px 0 0 0;
    }
    
    #readmore_1 ul li {
        list-style: none;
        float: left;
    }
    
    #readmore_1 .box div {
        text-align: center;
        -webkit-border-radius: 0px;
                border-radius: 0px;
        background-color: #f9f9f9;
                background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#eee), to(#f9f9f9));
                background: -webkit-linear-gradient(top, #f9f9f9, #eee  );
                background: -moz-linear-gradient(top, #f9f9f9, #eee);
                background: -ms-linear-gradient(top, #f9f9f9, #eee);
                background: -o-linear-gradient(top, #f9f9f9, #eee);
        color:#000;
                cursor: pointer;
        border: 1px solid #dfdfdf;
        padding: 8px 0 0 0;
        height: 26px;
    }
    
    #readmore_1 .box div:hover {
        color: red;
    }
    
    input[type="button"] {
        -webkit-border-radius: 0px;
                border-radius: 0px;
        background-color: #0075b1;
                background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0075b1), to(#0585c7));
                background: -webkit-linear-gradient(top, #0585c7, #0075b1);
                background: -moz-linear-gradient(top, #0585c7, #0075b1);
                background: -ms-linear-gradient(top, #0585c7, #0075b1);
                background: -o-linear-gradient(top, #0585c7, #0075b1);
        color:#fff;
        padding: 6px 23px;
        cursor: pointer;
        border: 1px solid #005f8b;
        margin-left: 60px;
    }
    
    input[type="button"].disabled {
        background-color: #f9f9f9;
                background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#eee), to(#f9f9f9));
                background: -webkit-linear-gradient(top, #f9f9f9, #eee  );
                background: -moz-linear-gradient(top, #f9f9f9, #eee);
                background: -ms-linear-gradient(top, #f9f9f9, #eee);
                background: -o-linear-gradient(top, #f9f9f9, #eee);
        color:#000;
        border: 1px solid #dfdfdf;
        cursor: default;
    }

    .submit-wrapper {
        text-align:  center;
    }
    .submit {
        margin: 30px 0 0 0;
    }
</style>
