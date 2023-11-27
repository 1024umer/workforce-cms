// Hamburger Menu

gsap.registerPlugin(ScrollTrigger);

const tl = gsap.timeline({
  paused: true,
  scrollTrigger: {
    trigger: "body",
    scrub: 1,
    end: 'bottom'
  }
});
tl.to("[data-scrub]", { xPercent: 600, yPercent: 400, scale: 3, rotate: 360, opacity: 1 });
$(".hambergur").on("click", () => {

  $(".fullscreen").toggleClass("active").removeClass("reverse_anim");

});



$(".close").on("click", () => {

  $(".fullscreen").toggleClass("reverse_anim");

});


$('.rw-slider').slick({
  arrows: true,
  prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa-solid fa-angle-left'></i></button>",
  nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
});

$('.rob-slider').slick({
  arrows: true,
  prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa-solid fa-angle-left'></i></button>",
  nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
  infinite: true,
  speed: 300,
  slidesToShow: 1,
  dots: true,
  slidesToScroll: 1,
  // responsive: [
  //   {
  //     breakpoint: 1024,
  //     settings: {
  //       slidesToShow: 3,
  //       slidesToScroll: 3,
  //       infinite: true,
  //       dots: true
  //     }
  //   },
  //   {
  //     breakpoint: 600,
  //     settings: {
  //       slidesToShow: 2,
  //       slidesToScroll: 2
  //     }
  //   },
  //   {
  //     breakpoint: 480,
  //     settings: {
  //       slidesToShow: 1,
  //       slidesToScroll: 1
  //     }
  //   }
  // ]
});

$('.team-slider').slick({
  arrows: true,
  prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa-solid fa-angle-left'></i></button>",
  nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
  infinite: true,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});

// PARTICLES
// ParticlesJS Config.
particlesJS("particles-js", {
  "particles": {
    "number": {
      "value": 80,
      "density": {
        "enable": true,
        "value_area": 700
      }
    },
    "color": {
      "value": "#ffffff"
    },
    "shape": {
      "type": "circle",
      "stroke": {
        "width": 0,
        "color": "#000000"
      },
      "polygon": {
        "nb_sides": 5
      },
    },
    "opacity": {
      "value": 0.2,
      "random": false,
      "anim": {
        "enable": false,
        "speed": 1,
        "opacity_min": 0.1,
        "sync": false
      }
    },
    "size": {
      "value": 3,
      "random": true,
      "anim": {
        "enable": false,
        "speed": 40,
        "size_min": 0.1,
        "sync": false
      }
    },
    "line_linked": {
      "enable": true,
      "distance": 150,
      "color": "#ffffff",
      "opacity": 0.4,
      "width": 1
    },
    "move": {
      "enable": true,
      "speed": 6,
      "direction": "none",
      "random": false,
      "straight": false,
      "out_mode": "out",
      "bounce": false,
      "attract": {
        "enable": false,
        "rotateX": 600,
        "rotateY": 1200
      }
    }
  },
  "interactivity": {
    "detect_on": "canvas",
    "events": {
      "onhover": {
        "enable": true,
        "mode": "grab"
      },
      "onclick": {
        "enable": true,
        "mode": "push"
      },
      "resize": true
    },
    "modes": {
      "grab": {
        "distance": 140,
        "line_linked": {
          "opacity": 1
        }
      },
      "bubble": {
        "distance": 400,
        "size": 40,
        "duration": 2,
        "opacity": 8,
        "speed": 3
      },
      "repulse": {
        "distance": 200,
        "duration": 0.4
      },
      "push": {
        "particles_nb": 4
      },
      "remove": {
        "particles_nb": 2
      }
    }
  },
  "retina_detect": true
});


$(".nav-item").click(function(){
  var name = $(this).data("name")
  $(".nav-item").each(function(i,e){
    if($(e).data("name") == name){
        $(e).addClass("active")
        $(e).find("a").addClass("active")
        $(e).find("a").addClass("show")
        $("#all-cities").html($(e).data("city"))
    }else{
        $(e).removeClass("active")
        $(e).find("a").removeClass("active")
        $(e).find("a").removeClass("show")
    }
  })
  
  $(".tab-pane").each(function(i,e){
    if($(e).prop("id") == name){
        $(e).addClass("show")          
        $(e).addClass("active")
    }else{
        $(e).removeClass("show")
        $(e).removeClass("active")
    }
  })
  
  
  });
  
  
  
  
  
  
  
  
  
  
  
  
  
  function visible(partial) {
    var $t = partial,
        $w = jQuery(window),
        viewTop = $w.scrollTop(),
        viewBottom = viewTop + $w.height(),
        _top = $t.offset().top,
        _bottom = _top + $t.height(),
        compareTop = partial === true ? _bottom : _top,
        compareBottom = partial === true ? _top : _bottom;

    return ((compareBottom <= viewBottom) && (compareTop >= viewTop) && $t.is(':visible'));

}

$(window).scroll(function(){

  if(visible($('.count-digit')))
    {
      if($('.count-digit').hasClass('counter-loaded')) return;
      $('.count-digit').addClass('counter-loaded');
      
$('.count-digit').each(function () {
  var $this = $(this);
  jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
    duration: 5000,
    easing: 'swing',
    step: function () {
      $this.text(Math.ceil(this.Counter));
    }
  });
});
    }
})

    
