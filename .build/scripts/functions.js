(function($){

  var $window       = $(window),
      $header       = $("header"),
      $nav          = $header.find("nav"),
      $menu_toggle  = $nav.find(".toggle"),
      $menu         = $nav.find("ul"),
      $section      = $("section"),
      $slider       = $section.filter(".slider")
      $slides       = $slider.find(".slides-container"),
      $tips         = $section.filter(".tips"),
      $tipcarousel  = $tips.find(".tips-container")
      $contact      = $section.filter(".contact"),
      $map          = $contact.find("#googleMap");

      $menu_toggle.on("click",function(){
        $menu_toggle.toggleClass("active");
        $menu.toggleClass("active");
      });

      $window.scroll(function(){
          var offset = $(window).scrollTop();

          fixed_header( offset );
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

      function tipsInit()
      {
        var owl = $tipcarousel.owlCarousel({
          loop    : true,
          autoPlay : true,
          navigation : false,
          slideSpeed : 300,
          pagination : true,
          paginationSpeed : 400,
          stopOnHover: true,
          singleItem: true,
          theme: "tips-theme"
        });
        return owl;
      }

      function fixed_header(offset)
      {
        if( offset >= $header.height() )
        {
          $header.addClass("fixed");
        }
        if( offset < $header.height() )
        {
          $header.removeClass("fixed");
        }
      }

      function googlemaps()
      {
        var coords = [
          { title: "Arcolon" , phone: "(43) 3336.5493" , lat: -23.3178821, lng: -51.1645811 }
        ],
            map = new google.maps.Map(document.getElementById('googleMap'),{
              center: { lat: -23.3178821, lng: -51.1645811 },
              mapTypeId: google.maps.MapTypeId.ROADMAP,
              zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE,
              },
              scrollwheel: false,
              draggable: false,
              zoom: 18
            });

        for(var i = 0; i < coords.length; i++ )
        {
          var infoWindow = new google.maps.InfoWindow(),
              position   = new google.maps.LatLng(coords[i].lat, coords[i].lng),
              marker     = new google.maps.Marker({
                position: position,
                map: map,
                title: 'Arcolon - Ar Condicionado',
                icon : {
                  url: 'assets/images/content/marker.png',
                  origin: new google.maps.Point(0,0),
                  anchor: new google.maps.Point(40,68)    // 27 for Px from the X axis (tip of pointer) and 42 For Px from the Y axis (Height)
                }
              });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                infoWindow.setContent("<div class='map-marker'><div class='marker-title'>"+coords[i].title+"</div><div class='marker-item-title'>Telefone:<span>"+coords[i].phone+"</span></div></div>");
                infoWindow.open(map, marker);
              }
            })(marker, i));
        }
      }


      if($slides.length)
      {
        sliderInit();
      }

      if($tips.length)
      {
        tipsInit();
      }

      if($map.length)
      {
        google.maps.event.addDomListener(window, 'load', googlemaps() );
      }

})(jQuery);
