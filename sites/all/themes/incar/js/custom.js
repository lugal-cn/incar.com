jQuery(document).ready(function($) {
  $('.nav-toggle').click(function() {
    $('#main-menu div ul:first-child').slideToggle(250);
    return false;
  });
  
  if( ($(window).width() > 640) || ($(document).width() > 640) ) {
    toggleMobile();
      $('#main-menu li').mouseenter(function() {
        $(this).children('ul').css('display', 'none').stop(true, true).slideToggle(250).css('display', 'block').children('ul').css('display', 'none');
      });
      $('#main-menu li').mouseleave(function() {
        $(this).children('ul').stop(true, true).fadeOut(250).css('display', 'block');
      })
        } else {
        toggleMobile();
    $('#main-menu li').each(function() {
      if($(this).children('ul').length)
        $(this).append('<span class="drop-down-toggle"><span class="drop-down-arrow"></span></span>');
    });
    $('.drop-down-toggle').click(function() {
      $(this).parent().children('ul').slideToggle(250);
    });
  }
  
  $("#toolbar-menu li a").each(function(){
	$(this).unbind("click");
	var anchor = $(this).attr("href");
	anchor = anchor.split("#");
	// console.log(anchor);
	$(this).bind("click", function(){
	  window.location = "#" + anchor[1];
	  return false;
	});
  });

  $(window).resize(function(){
    toggleMobile();
  });

  $(".menu-navigation-container ul li a").each(function(){
    var href = $(this).attr("href");
    //console.log(href.substr(1,1));
    if (href.substr(1,1) == "#") {
      var anchor = href.substr(2);
      //console.log("anchor = " + anchor);
      $(this).unbind("click");
      $(this).bind("click", function(){
        goToByScroll(anchor);
        //$('#main-menu div ul:first-child').slideToggle(250);
        return false;
      });
    }
  });
  
  $("#toolbar-menu li a").each(function() {
    var href = $(this).attr("href");
    //console.log(href.substr(1,1));
    if (href.substr(1,1) == "#") {
      var anchor = href.substr(2);
      //console.log("anchor = " + anchor);
      $(this).unbind("click");
      $(this).bind("click", function(){
        goToByScroll(anchor);
        $('#main-menu div ul:first-child').slideToggle(250);
        return false;
      });
    }
  });
  
  function goToByScroll(id) {
    $("html,body").animate({scrollTop: $("#"+id).offset().top - 30}, "slow");
    //console.log("goToByScroll call");
    return false;
  }
  
  function toggleScroll() {
    if ($("html").offset().top < -30) {
      if( ($(window).width() > 640) || ($(document).width() > 640) ) {
        $("#inner_header_wrapper").attr("style", "height: 30px; overflow: hidden;");
        $("#logo a img").attr("style", "height: 30px;");
        $("#header .menu_wrapper").attr("style", "width: 60%;line-height: 30px;");  
      }
    }
    else {
      if( ($(window).width() > 640) || ($(document).width() > 640) ) {
        $("#inner_header_wrapper").attr("style", "height: 90px; overflow: hidden;");
        $("#logo a img").attr("style", "height: auto;");
        $("#header .menu_wrapper").attr("style", "width: 60%;line-height: 90px;");
      }
    }
  }
  
  toggleScroll();
  
  function toggleMobile() {
    if( ($(window).width() > 640) || ($(document).width() > 640) ) {
      //console.log("resize > 640");
      $("#toolbar").show();
      $("body").attr("style", "padding-top: 40px;");
      $("#main-menu").removeClass("nav-toggle");
      $("#logo").show();
      $("#main-menu ul.menu").show();
      $("#header .menu_wrapper").attr("style", "width: 60%;line-height: 90px;");
      $("#inner_header_wrapper").attr("style", "height: 90px; overflow: hidden;");
    }
    else {
      //console.log("resize < 640");
      $("#main-menu").addClass("nav-toggle");
      $("body").attr("style", "padding-top: 0px;");
      $("#toolbar").hide();
      $("#logo").hide();
      $("#header .menu_wrapper").attr("style", "width: 100%; line-height: 20px;");
      $("#inner_header_wrapper").attr("style", "height: auto; overflow: auto;");
    }
  }
  
  $(window).scroll(function(){
    //console.log("windows scrolling now, top: " + $("html").offset().top);
    toggleScroll();
  });
});