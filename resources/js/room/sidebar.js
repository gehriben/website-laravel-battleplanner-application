
$( ".toggletag" ).click(function() {

    if ( $(this).hasClass("toggled")) {
        
        $( ".toggletag" ).animate({
            left: "0px",
        }, 500 );

        $( ".nav-side-menu" ).animate({
            width: "0px",
        }, 500 );
        
        $(this).removeClass("toggled")
        var innerElem =  $('.toggletag .fa-arrow-left');
        innerElem.removeClass("fa-arrow-left");
        innerElem.addClass("fa-arrow-right");
    } else{
        
        $( ".nav-side-menu" ).animate({
            width: "300px",
        }, 500 );

        $( ".toggletag" ).animate({
            left: "300px",
        }, 500 );

        $(this).addClass("toggled")

        var innerElem =  $('.toggletag .fa-arrow-right');
        innerElem.removeClass("fa-arrow-right");
        innerElem.addClass("fa-arrow-left");
    }
    
});