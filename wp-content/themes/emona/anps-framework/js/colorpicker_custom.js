jQuery(document).ready(function( $ ) {  
    var currentlyClickedElement = '';
  	
    $('.color-pick-color').bind("click", function(){ 
        currentlyClickedElement = this;
    });
  	
    $('.color-pick-color').ColorPicker({
        onSubmit: function(hsb, hex, rgb, el) {
            $(el).css("background","#"+hex);
            $(el).attr("data-value", "#"+hex);
            $(el).parent().children(".color-pick").val("#"+hex);
            $(el).ColorPickerHide();
        },
        onBeforeShow: function () {
            $(this).ColorPickerSetColor($(this).attr("data-value"));
        },
        onChange: function (hsb, hex, rgb) {
            $(currentlyClickedElement).css("background","#"+hex);
            $(currentlyClickedElement).attr("data-value", "#"+hex);
            $(currentlyClickedElement).parent().children(".color-pick").val("#"+hex);
        }
    })
    .bind('keyup', function(){
        $(this).ColorPickerSetColor(this.value);
    });
	 
 
    $('.color-pick').bind('keyup', function(){
        $(this).parent().children(".color-pick-color").css("background", $(this).val());
    });
    
    // 17 - var default = new Array("" , "", "", "", "", "");
    var default_val = new Array("#0ea7c3" , "#13bfdf", "#fff", "#444", "#000", "#adeaf5");
    var green =       new Array("#31bc90" , "#3cdca9", "#fff", "#444", "#000", "#53e2b5");
    var brown =       new Array("#cd7646" , "#e1814d", "#fff", "#444", "#000", "#f49c6c");
    var red =         new Array("#d15151" , "#e95b5b", "#fff", "#444", "#000", "#f76c6d");
    var darkBlue =    new Array("#34495e" , "#425c76", "#fff", "#444", "#000", "#587a9c");
    var purple =      new Array("#8e44ad" , "#a450c7", "#fff", "#444", "#000", "#c569eb");
    var orange =      new Array("#e67e22" , "#f78724", "#fff", "#444", "#000", "#f79a48");
    var grey =        new Array("#7f8c8d" , "#97a6a7", "#fff", "#444", "#000", "#afc1c2");
    $("#predefined_colors").bind("change", function(){
    	
        var table;
    	
        switch( $(this).val() ) {
            case "default" :
                table = default_val;
                break;
            case "green" :
                table = green;
                break;
            case "brown" :
                table = brown;
                break;
            case "red" :
                table = red;
                break;
            case "darkBlue" :
                table = darkBlue;
                break;
            case "purple" :
                table = purple;
                break;
            case "orange" :
                table = orange;
                break;
            case "grey" :
                table = grey;
                break;
        }
    	
        $(".color-pick").each(function(index){
            $(".color-pick").eq(index).val(table[index]);
            $(".color-pick").eq(index).parent().children(".color-pick-color").css("background", table[index]);
            $(".color-pick").eq(index).parent().children(".color-pick-color").attr("data-value", table[index]);
        });
    });
    $(".input-type").change(function(){
        if($(this).val() == "dropdown") {
            $(this).parent().parent().children(".validation").hide();
            $(this).parent().parent().children(".label-place-val").children("label").html("Values");
        }
        else {
            $(this).parent().parent().children(".validation").show();
            $(this).parent().parent().children(".label-place-val").children("label").html("Placeholder");
        }
    });
});