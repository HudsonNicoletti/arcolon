(function($){

  var $window       = $(window),
      $body         = $("body"),
      $header       = $("header"),
      $nav          = $header.find("nav"),
      $menu_toggle  = $nav.find(".toggle"),
      $menu         = $nav.find("ul"),
      $menuitem     = $menu.find("li a"),
      $section      = $("section"),
      $slider       = $section.filter(".slider")
      $slides       = $slider.find(".slides-container"),
      $tips         = $section.filter(".tips"),
      $tipcarousel  = $tips.find(".tips-container")
      $gallery      = $section.filter(".gallery"),
      $galleryImgs  = $gallery.find(".gallery-container"),
      $contact      = $section.filter(".contact"),
      $map          = $contact.find("#googleMap");

      $("form[role='ajax']").submit(function(){

          var $this   = $(this),
              action  = $this.attr("action"),
              method  = $this.attr("method"),
              results = $this.find(".result"),
              inputs  = $this.find("input:not(:file):not(:submit) , textarea"),
              files   = $this.find("input:file"),
              content = new FormData( $this );

              //  Loop & append inputs
              for( var i = 0;  i < inputs.length ; ++i )
              {
                  content.append( $(inputs[i]).attr("name") , $(inputs[i]).val() ); // Add all fields automatic
              }

              //  Loop & append files with file data
              if( files.length  ) {
                  for( var i = 0;  i < files.length ; ++i )
                  {
                      if(files[i].files[i] != undefined)
                      {
                          content.append(files.eq(i).attr("name"), files[i].files[i], files[i].files[i].name );// add files if exits
                      }
                  }
              }

              //  Submit data
              $.ajax({
                  url:  action,           //  Action  ( PHP SCRIPT )
                  type: method,           //  Method
                  data: content,          //  Data Created
                  processData: false,     //  Tell jQuery not to process the data
                  contentType: false,     //  Tell jQuery not to set contentType
                  dataType: "json",       //  Accept JSON response
                  cache: false,           //  Disale Cashing
                  success: function( response )
                  {
                    (response.data.status) ? results.addClass("success") : results.addClass("error");
                    results.html(response.data.message);
                    setTimeout(function(){
                      results.removeClass();
                      results.html("");
                    }, 5000)
                  }
              });

          return false;
      });

      $menu_toggle.on("click",function(){
        $menu_toggle.toggleClass("active");
        $menu.toggleClass("active");
      });

      $menuitem.on("click",function(){
        if($menu.hasClass("active"))
        {
          $menu_toggle.removeClass("active");
          $menu.removeClass("active");
        }
      });

      $window.scroll(function(){
          var offset = $(window).scrollTop();

          fixed_header( offset );
      });

      function sliderInit()
      {
        $slider.css({
          "margin-top" : $header.height() + 20
        })
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
        var $tips = $tipcarousel.find(".tip");
          // group by 2 automaticly for carousel
          for(var i = 0; i < $tips.length; i+=2) {
            $tips.slice(i, i+2).wrapAll("<div class='group'></div>");
          }

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

      function tipsPageInit()
      {
        var $tps      = $tips.find(".articles");
        var $articles = $tps.find("article");
        // group by 2 automaticly for carousel
        for(var i = 0; i < $articles.length; i+=2) {
          $articles.slice(i, i+2).wrapAll("<div class='group'></div>");
        }

        var owl = $tps.owlCarousel({
          loop    : true,
          autoPlay : true,
          slideSpeed : 300,
          pagination : false,
          paginationSpeed : 400,
          stopOnHover: true,
          singleItem: true,
          navigation:true,
          navContainer: "#pagination",
          navigationText: [
            "<div class=\"page-prev owl-prev\"></div>",
            "<div class=\"page-next owl-prev\"></div>"
          ],
          theme: "tips-theme"
        });
        return owl;
      }

      function galleryInit()
      {
        var owl = $galleryImgs.owlCarousel({
          loop    : true,
          autoPlay : true,
          navigation : false,
          slideSpeed : 300,
          pagination : true,
          paginationSpeed : 400,
          stopOnHover: true,
          singleItem: true,
          theme: "gallery-theme"
        });
        return owl;
      }

      function galleryWrapItems()
      {
        var $set = $('#auto-wrap').children();
        for(var i=0, len = $set.length; i < len; i+=6){
          $set.slice(i, i+6).wrapAll('<div class="gallery-images"/>');
        }
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
          { title: "Arcolon" , phone: "(43) 3336.5493" , lat: -23.3099895, lng: -51.1372692 }
        ],
            map = new google.maps.Map(document.getElementById('googleMap'),{
              center: { lat: -23.3099895, lng: -51.1372692 },
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
                  url: 'assets/public/images/content/marker.png',
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

      if($gallery.length)
      {
        galleryWrapItems();
        galleryInit();
      }

      if($map.length)
      {
        google.maps.event.addDomListener(window, 'load', googlemaps() );
      }

      if($body.hasClass("tips"))
      {
        tipsPageInit()
      }

      $.scrollIt({
        topOffset: -120,
        activeClass: 'active'
      });

})(jQuery);
