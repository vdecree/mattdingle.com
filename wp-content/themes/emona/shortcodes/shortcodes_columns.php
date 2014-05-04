<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>

<div id="readmore_1">
    
    <h2>Column layout:</h2>
    
    <label for="number_of_columns">Number of columns: </label>
    
    <select id="number_of_columns" name="number_of_columns">
        <option value="2">Select a number of columns</option>
        <option value="2">2 columns</option>
        <option value="3">3 columns</option>
        <option value="4">4 columns</option>
    </select>
    
    <ul id="columns_2">
        <li><input type="button" value="1/2"></li>
    </ul>
    
    <ul id="columns_3">
        <li><input type="button" value="1/3"></li>
        <li><input type="button" value="2/3"></li>
    </ul>
    
    <ul id="columns_4">
        <li><input type="button" value="1/4"></li>
        <li><input type="button" value="2/4"></li>
        <li><input type="button" value="3/4"></li>
    </ul>
   
    <div style="clear: both"></div> 
<div class="box">
    &nbsp;
</div>
    
    
</div>
<div class="submit-wrapper">
    <input disabled="disabled" class="disabled submit" type="button" value="Insert column layout" onclick="anps_getValue()" />
</div>
<script>

var currentNumber = 0;
var maxNumber = 0;

function checkButtons() {
    $.each("ul#columns_"+maxNumber+" input", function(index) {
        if ( parseInt($("ul#columns_"+maxNumber+" input").eq(index).val()[0]) + currentNumber  > maxNumber) {
            $("ul#columns_"+maxNumber+" input").eq(index).attr("disabled", true);
            $("ul#columns_"+maxNumber+" input").eq(index).addClass("disabled");
        } else {
            
            $("ul#columns_"+maxNumber+" input").eq(index).attr("disabled", false);
            $("ul#columns_"+maxNumber+" input").eq(index).removeClass("disabled");
        }
    });
    
    
}

jQuery(document).ready(function( $ ) {    

    

    
    $("select").change(function(){
        
        if ( $("select").val() == 1 ) {
            
            $(".box").html( '<div class="full">Full layout</div>' );
            $(".submit").removeClass("disabled");
            $(".submit").attr("disabled", false);
            $("ul").css("display","none");
        } else {
        
            currentNumber = 0;
            maxNumber = $(this).val();

            $("ul input").attr("disabled", false);
            $("ul input").removeClass("disabled");

            $("ul").css("display","none");
            $("ul#columns_" + $(this).val()).css("display","block");

            $(".box").html("");
        }
    });
    
    $("input[type='button']").click(function(){
        
        if ( !$(this).hasClass("submit")) {
        
        var columnClass = "";
        
        currentNumber += parseInt($(this).val()[0]);
        
        if( $(this).val() == "1/2" ) {
            columnClass = "half";
        }
        
        if( $(this).val() == "1/3" ) {
            columnClass = "third";
        }
        
        if( $(this).val() == "2/3" ) {
            columnClass = "two_third";
        }
        
        if( $(this).val() == "1/4" ) {
            columnClass = "quarter";
        }
        
        if( $(this).val() == "2/4" ) {
            columnClass = "two_quarter";
        }
        
        if( $(this).val() == "3/4" ) {
            columnClass = "three_quarter";
        }

        if( currentNumber == maxNumber ) {
            $(".submit").removeClass("disabled");
            $(".submit").attr("disabled", false);
        } else {
            $(".submit").addClass("disabled");
            $(".submit").attr("disabled", true);
        }
        
        
        $(".box").html( $(".box").html() + '<div class="' +  columnClass + '">' + $(this).val() + '</div>' );
        
        $('.box').find("div").unbind('click');
        $('.box').find("div").bind('click', function(event) {
            currentNumber -= parseInt($(this).html()[0]);
            $(this).remove();

            if( currentNumber == maxNumber ) {
                $(".submit").removeClass("disabled");
                $(".submit").attr("disabled", false);
            } else {
                $(".submit").addClass("disabled");
                $(".submit").attr("disabled", true);
            }
            
            checkButtons();
        });
        
        checkButtons();
        
        
        }
    });
    
});

    
function anps_getValue() { 
    
    var values = $(".box").html();
    
    if ( values == '<div class="full">Full layout</div>') {        
        window.parent.original_send_to_editor('[full_content]Full content[/full_content]');
    } else {
    
        var valuesArray = values.split("</div>");

        values = "";
        
        var numberOfValues = 0;
        
        for ( var i in valuesArray) {
            numberOfValues++;
        }
        
        var count = 1;
        for ( var i in valuesArray) {

            valuesArray[i] = valuesArray[i].replace('"','');
            valuesArray[i] = valuesArray[i].replace(' class=','');
            valuesArray[i] = valuesArray[i].replace('<div','[content_');
            
            
            if( numberOfValues -1 == count) {
                count++;
                valuesArray[i] = valuesArray[i].replace('">',' id="last"]');
            }
            else if( count == 1 ) {
                count++;
                valuesArray[i] = valuesArray[i].replace('">',' id="first"]');
            } else {
                count++;
                valuesArray[i] = valuesArray[i].replace('">',']');
            }

            var temp = valuesArray[i].search("]");
            temp = valuesArray[i].substr(0,temp + 1);
            temp = temp.replace('[','[/');
            temp = temp.replace(' id="first"','');
            temp = temp.replace(' id="last"','');

            values += valuesArray[i] + temp + "<br/>";
        }
        
        window.parent.send_to_editor(values);
    }
}
</script>
<style>
    
    .half, .two_quarter {
        width: 281px;
        margin: 15px 0 15px 15px;
        height: 33px;
        float: left;
    }
    
    .full {
        width: 579px;
        margin: 15px 15px;
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
            margin: 0 0 0 75px;
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
    }
    
    #readmore_1 h2 {
        color: #000000;
        font-size: 16px;
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
    
    .box .full:hover {
        color: #333 !important;
        cursor: default !important;
    }
    
</style>
