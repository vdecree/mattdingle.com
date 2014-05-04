<?php 
	require_once("../../../../wp-blog-header.php"); 
	$images =& get_children( 'post_type=attachment&post_mime_type=image' );
?>
<h2 class="h2">Icon:</h2>
<div id="readmore_wrapper">
    <div id="readmore_1">
    <label>Icon:</label>
    <div>
        <select name="icon" id="icon">
          <option value="adjust">adjust</option>
          <option value="align-center">align-center</option>
          <option value="align-justify">align-justify</option>
          <option value="align-left">align-left</option>
          <option value="align-right">align-right</option>
          <option value="arrow-down">arrow-down</option>
          <option value="arrow-left">arrow-left</option>
          <option value="arrow-right">arrow-right</option>
          <option value="arrow-up">arrow-up</option>
          <option value="asterisk">asterisk</option>
          <option value="backward">backward</option>
          <option value="ban-circle">ban-circle</option>
          <option value="barcode">barcode</option>
          <option value="bell">bell</option>
          <option value="bold">bold</option>
          <option value="book">book</option>
          <option value="bookmark">bookmark</option>
          <option value="briefcase">briefcase</option>
          <option value="bullhorn">bullhorn</option>
          <option value="calendar">calendar</option>
          <option value="camera">camera</option>
          <option value="certificate">certificate</option>
          <option value="check">check</option>
          <option value="chevron-down">chevron-down</option>
          <option value="chevron-left">chevron-left</option>
          <option value="chevron-right">chevron-right</option>
          <option value="chevron-up">chevron-up</option>
          <option value="circle-arrow-down">circle-arrow-down</option>
          <option value="circle-arrow-left">circle-arrow-left</option>
          <option value="circle-arrow-right">circle-arrow-right</option>
          <option value="circle-arrow-up">circle-arrow-up</option>
          <option value="cloud">cloud</option>
          <option value="cloud-download">cloud-download</option>
          <option value="cloud-upload">cloud-upload</option>
          <option value="cog">cog</option>
          <option value="collapse-down">collapse-down</option>
          <option value="collapse-up">collapse-up</option>
          <option value="comment">comment</option>
          <option value="compressed">compressed</option>
          <option value="copyright-mark">copyright-mark</option>
          <option value="credit-card">credit-card</option>
          <option value="cutlery">cutlery</option>
          <option value="dashboard">dashboard</option>
          <option value="download">download</option>
          <option value="download-alt">download-alt</option>
          <option value="earphone">earphone</option>
          <option value="edit">edit</option>
          <option value="eject">eject</option>
          <option value="envelope">envelope</option>
          <option value="euro">euro</option>
          <option value="exclamation-sign">exclamation-sign</option>
          <option value="expand">expand</option>
          <option value="export">export</option>
          <option value="eye-close">eye-close</option>
          <option value="eye-open">eye-open</option>
          <option value="facetime-video">facetime-video</option>
          <option value="fast-backward">fast-backward</option>
          <option value="fast-forward">fast-forward</option>
          <option value="file">file</option>
          <option value="film">film</option>
          <option value="filter">filter</option>
          <option value="fire">fire</option>
          <option value="flag">flag</option>
          <option value="flash">flash</option>
          <option value="floppy-disk">floppy-disk</option>
          <option value="floppy-open">floppy-open</option>
          <option value="floppy-remove">floppy-remove</option>
          <option value="floppy-save">floppy-save</option>
          <option value="floppy-saved">floppy-saved</option>
          <option value="folder-close">folder-close</option>
          <option value="folder-open">folder-open</option>
          <option value="font">font</option>
          <option value="forward">forward</option>
          <option value="fullscreen">fullscreen</option>
          <option value="gbp">gbp</option>
          <option value="gift">gift</option>
          <option value="glass">glass</option>
          <option value="globe">globe</option>
          <option value="hand-down">hand-down</option>
          <option value="hand-left">hand-left</option>
          <option value="hand-right">hand-right</option>
          <option value="hand-up">hand-up</option>
          <option value="hd-video">hd-video</option>
          <option value="hdd">hdd</option>
          <option value="header">header</option>
          <option value="headphones">headphones</option>
          <option value="heart">heart</option>
          <option value="heart-empty">heart-empty</option>
          <option value="home">home</option>
          <option value="import">import</option>
          <option value="inbox">inbox</option>
          <option value="indent-left">indent-left</option>
          <option value="indent-right">indent-right</option>
          <option value="info-sign">info-sign</option>
          <option value="italic">italic</option>
          <option value="leaf">leaf</option>
          <option value="link">link</option>
          <option value="list">list</option>
          <option value="list-alt">list-alt</option>
          <option value="lock">lock</option>
          <option value="log-in">log-in</option>
          <option value="log-out">log-out</option>
          <option value="magnet">magnet</option>
          <option value="map-marker">map-marker</option>
          <option value="minus">minus</option>
          <option value="minus-sign">minus-sign</option>
          <option value="emona">move</option>
          <option value="music">music</option>
          <option value="new-window">new-window</option>
          <option value="off">off</option>
          <option value="ok">ok</option>
          <option value="ok-circle">ok-circle</option>
          <option value="ok-sign">ok-sign</option>
          <option value="open">open</option>
          <option value="paperclip">paperclip</option>
          <option value="pause">pause</option>
          <option value="pencil">pencil</option>
          <option value="phone">phone</option>
          <option value="phone-alt">phone-alt</option>
          <option value="picture">picture</option>
          <option value="plane">plane</option>
          <option value="play">play</option>
          <option value="play-circle">play-circle</option>
          <option value="plus">plus</option>
          <option value="plus-sign">plus-sign</option>
          <option value="print">print</option>
          <option value="pushpin">pushpin</option>
          <option value="qrcode">qrcode</option>
          <option value="question-sign">question-sign</option>
          <option value="random">random</option>
          <option value="record">record</option>
          <option value="refresh">refresh</option>
          <option value="registration-mark">registration-mark</option>
          <option value="remove">remove</option>
          <option value="remove-circle">remove-circle</option>
          <option value="remove-sign">remove-sign</option>
          <option value="repeat">repeat</option>
          <option value="resize-full">resize-full</option>
          <option value="resize-horizontal">resize-horizontal</option>
          <option value="resize-small">resize-small</option>
          <option value="resize-vertical">resize-vertical</option>
          <option value="retweet">retweet</option>
          <option value="road">road</option>
          <option value="save">save</option>
          <option value="saved">saved</option>
          <option value="screenshot">screenshot</option>
          <option value="sd-video">sd-video</option>
          <option value="search">search</option>
          <option value="send">send</option>
          <option value="share">share</option>
          <option value="share-alt">share-alt</option>
          <option value="shopping-cart">shopping-cart</option>
          <option value="signal">signal</option>
          <option value="sort">sort</option>
          <option value="sort-by-alphabet">sort-by-alphabet</option>
          <option value="sort-by-alphabet-alt">sort-by-alphabet-alt</option>
          <option value="sort-by-attributes">sort-by-attributes</option>
          <option value="sort-by-attributes-alt">sort-by-attributes-alt</option>
          <option value="sort-by-order">sort-by-order</option>
          <option value="sort-by-order-alt">sort-by-order-alt</option>
          <option value="sound-5-1">sound-5-1</option>
          <option value="sound-6-1">sound-6-1</option>
          <option value="sound-7-1">sound-7-1</option>
          <option value="sound-dolby">sound-dolby</option>
          <option value="sound-stereo">sound-stereo</option>
          <option value="star">star</option>
          <option value="star-empty">star-empty</option>
          <option value="stats">stats</option>
          <option value="step-backward">step-backward</option>
          <option value="step-forward">step-forward</option>
          <option value="stop">stop</option>
          <option value="subtitles">subtitles</option>
          <option value="tag">tag</option>
          <option value="tags">tags</option>
          <option value="tasks">tasks</option>
          <option value="text-height">text-height</option>
          <option value="text-width">text-width</option>
          <option value="th">th</option>
          <option value="th-large">th-large</option>
          <option value="th-list">th-list</option>
          <option value="thumbs-down">thumbs-down</option>
          <option value="thumbs-up">thumbs-up</option>
          <option value="time">time</option>
          <option value="tint">tint</option>
          <option value="tower">tower</option>
          <option value="transfer">transfer</option>
          <option value="trash">trash</option>
          <option value="tree-conifer">tree-conifer</option>
          <option value="tree-deciduous">tree-deciduous</option>
          <option value="unchecked">unchecked</option>
          <option value="upload">upload</option>
          <option value="usd">usd</option>
          <option value="user">user</option>
          <option value="volume-down">volume-down</option>
          <option value="volume-off">volume-off</option>
          <option value="volume-up">volume-up</option>
          <option value="warning-sign">warning-sign</option>
          <option value="wrench">wrench</option>
          <option value="zoom-in">zoom-in</option>
          <option value="zoom-out">zoom-out</option>
        </select>
    </div>
    </div>
    <div id="readmore_1">
        <label>Icon title:</label>
        <input id="icon-title" type="text" />
    </div>   
    
    <div id="readmore_1">
        <label>Link: </label>
        <input id="link" type="text" />
    </div>
    
    <div id="readmore_1">
        <label>Target: </label>
        <select id="target">
            <option value=""></option>
            <option value="_blank">_blank</option>
            <option value="_self">_self</option>
            <option value="_parent">_parent</option>
            <option value="_top">_top</option>
        </select><br>
    </div>
    <div id="readmore_1">
        <label>Position: </label>
        <select id="position">
            <option value=""></option>
            <option value="top">top</option>
            <option value="left">left</option>
            <option value="right">right</option>
        </select><br>
    </div>
    <div id="readmore_1">
        <label>Text: </label>
        <textarea id="text" cols="30" rows="10"></textarea>
    </div>
     
</div>
<div class="submit-wrapper">
<input type="button" class="submit" value="Insert" onclick="anps_getValue()" />
</div>
<script>
function anps_getValue() { 
    var values = '';
    var icon, iconTitle, link, target, text, position;
    icon = document.getElementById('icon').value;
    iconTitle = document.getElementById('icon-title').value;
    link = document.getElementById('link').value;
    target = document.getElementById('target').value;
    text = document.getElementById('text').value;
    position = document.getElementById('position').value;
    
    values = '[icon title="' + iconTitle + '" icon="' + icon + '" link="' + link + '" target="' + target + '" position="' + position + '"]' + text + '[/icon]';
    window.parent.send_to_editor(values + "<br/>");
}
</script>
<style>
    
    .half, .two_quarter {
        width: 281px;
        margin: 15px 0 15px 15px;
        height: 33px;
        float: left;
    }
    
    hr {
        border: 1px solid #dddddd;
        border-style: solid none none none;
        margin: 40px 0;
    }
    
    label {
        display: block;
        margin: 20px 0 15px 0;
        padding:  0;
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
        float: left;
    }
    
    .three_quarter {
        width: 431px;
        margin: 15px 0 15px 15px;
        height: 33px;
        float: left;
    }
    
    
    select {
            margin: 0 0 20px 0px;
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
    
    #readmore_wrapper .box {
        width:  100%;
        height: 65px;
        float: left;
        margin-top: 40px;
        border: 1px solid #dddddd;
        border-radius: 0px;
    }
    
    #readmore_wrapper {
        padding: 21px;
        font-family: Arial;
        margin: 0 auto;
        width: 355px;
    }
    
    h2.h2 {
        font-family: Arial !important;
        color: #000000;
        font-size: 16px;
        padding: 21px 0 0 21px;
    }
    
    #readmore_wrapper ul {
        display: none;
        padding:  0;
        margin:  30px 0 0 0;
    }
    
    #readmore_wrapper ul li {
        list-style: none;
        float: left;
    }
    
    #readmore_wrapper .box div {
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
    
    #readmore_wrapper .box div:hover {
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
        width: 565px;
        text-align:  center;
    }
    .submit {
        margin: 30px 0 0 0px;
    }
    
    input[type=text],
select, 
textarea {
	padding: 7px 5px;
	width: 335px;
	border: 1px solid #dddddd;
	border-radius: 0px;
}
textarea  {
    height: 100px;
}
</style>
