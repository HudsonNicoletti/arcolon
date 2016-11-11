(function($){

  var $header       = $("header"),
      $nav          = $header.find("nav"),
      $menu_toggle  = $nav.find(".toggle"),
      $menu         = $nav.find("ul"),
      $section      = $("section"),
      $slider       = $section.filter(".slider")
      $slides       = $slider.find(".slides-container");

      $menu_toggle.on("click",function(){
        $menu_toggle.toggleClass("active");
        $menu.toggleClass("active");
      });

      function sliderInit()
      {
        var owl = $slides.owlCarousel({
          autoPlay : true,
          navigation : false,
          slideSpeed : 300,
          pagination : true,
          paginationSpeed : 400,
          singleItem: true,
          stopOnHover: true,
          addClassActive: false,
          theme: "slider-theme"
        });
        return owl;
      }

      sliderInit();

})(jQuery);
