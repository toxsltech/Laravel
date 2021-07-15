$(document).ready(function(){
  //HamBurger
  var forEach=function(t,o,r){if("[object Object]"===Object.prototype.toString.call(t))for(var c in t)Object.prototype.hasOwnProperty.call(t,c)&&o.call(r,t[c],c,t);else for(var e=0,l=t.length;l>e;e++)o.call(r,t[e],e,t)};
  var hamburgers = document.querySelectorAll(".hamburger");
  if (hamburgers.length > 0) {
    forEach(hamburgers, function(hamburger) {
      hamburger.addEventListener("click", function() {
        this.classList.toggle("is-active");
      }, false);
    });
  }


  autosize();
  function autosize(){
    var text = $('.autosize');
    text.each(function(){
      $(this).attr('rows',6);
      resize($(this));
    });
    text.on('input', function(){
      resize($(this));
    });
    function resize ($text) {
      $text.css('height', 'auto');
      $text.css('height', $text[0].scrollHeight+'px');
    }
  }

  //WOW
  new WOW().init();

  //padding-top
  $('.inner-page').css('padding-top', $('#main-header').height() + 'px');

  //top
  $('.wishlist').css('top', $('.discover_cards .discover_content').height() + 30 + 'px');

  //same-height
  $('.profile_bg img').css('height', $('.profile_bg img').width() + 'px');


  $('.navbar-toggler').click(function(){
    $('#navbarNav').toggleClass('menu-show');
    $(this).toggleClass('collapsed');
    $('body').toggleClass('menu-open');
  });

  $('.owl-carousel').owlCarousel({
    loop:true,
    nav:false,
    dots: false,
    animateOut: 'fadeOut',
    margin:0,
    responsiveClass:true,
    autoplay:true,
    autoplayTimeout:1500,
    autoplayHoverPause:true,
    responsive:{
      0:{
        items:1,
      },
      600:{
        items:3,
      },
      1000:{
        items:5,
      }
    }
  });
  var readURL = function(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('.profile-pic').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }
  $(".file-upload").on('change', function(){
    readURL(this);
  });

  $(".upload-button").on('click', function() {
    $(".file-upload").click();
  });


  $(".add-location-butn").click(function(){
    $(".add_location_form").show();
  });

});

$(window).scroll(function() {
  var scroll = $(window).scrollTop();
  if (scroll >= 100) {
    $("body").addClass("stickys");
  }
  else {
    $("body").removeClass("stickys");
  }

});

$(window).resize( function() {
  //same-height
  $('.profile_bg img').css('height', $('.profile_bg img').width() + 'px');

  //top
  $('.wishlist').css('top', $('.discover_cards .discover_content').height() + 30 + 'px');
});
