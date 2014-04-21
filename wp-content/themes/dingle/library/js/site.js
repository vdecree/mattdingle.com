jQuery(document).ready(function() {
  // jQuery('body').addClass('js');
  // var jQuerymenu = jQuery('#menu'),
  //   jQuerymenulink = jQuery('.menu-link');
  //
  // jQuerymenulink.click(function() {
  //   jQuerymenulink.toggleClass('active');
  //   jQuerymenu.toggleClass('active');
  //   return false;
  // });
  var responsiveNav = document.getElementById('js-nav');
  var responsiveNavBreakpoint = 820;

  responsiveNav.addEventListener('click', function(){
      if(window.innerWidth < responsiveNavBreakpoint){
          responsiveNav.classList.toggle("nav--open");
      }
  });

  jQuery(".gig__date:nth-child(3n)").css({
    marginRight: "0"
  });
});

equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     jQueryel,
     topPosition = 0;
 jQuery(container).each(function() {

   jQueryel = jQuery(this);
   jQuery(jQueryel).height('auto')
   topPostion = jQueryel.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = jQueryel.height();
     rowDivs.push(jQueryel);
   } else {
     rowDivs.push(jQueryel);
     currentTallest = (currentTallest < jQueryel.height()) ? (jQueryel.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

jQuery(window).load(function() {
  equalheight("div[class*='gig__date-']");
});


jQuery(window).resize(function(){
  equalheight("div[class*='gig__date-']");
});
