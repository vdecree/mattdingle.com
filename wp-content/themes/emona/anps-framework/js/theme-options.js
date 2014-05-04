jQuery(document).ready(function($) {
    $(".style-images").each(function( index ) {
        if( $("input[type=radio]").eq(index).is(':checked')) {
            $(".style-images").eq( index ).css({
                "border":"2px solid #2187c0",
                "cursor":"default"
            });
        }
    });
        
    $(".style-images").click(function(){
            
        $("input[type=radio]").eq( $(this).index(".style-images") ).click();
            
        $(".style-images").each(function( index ) {
            $(".style-images").eq( index ).css({
                "border":"2px solid #efefef",
                "cursor":"pointer"
            });
        });
            
        $(this).css({
            "border":"2px solid #2187c0",
            "cursor":"default"
        });
    });
});