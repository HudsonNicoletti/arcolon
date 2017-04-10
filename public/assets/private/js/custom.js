(function(){

    $("[data-duplicater]").on("click",function(){

      var _wrapper_id = $(this).data("duplicater");
      var _wrapper    = $("[data-duplicates='"+_wrapper_id+"']");
      var _template   = _wrapper.find("[data-duplicate='0']");
      var _len        = $("[data-duplicate]").length;

      var item = _template.clone().appendTo( _wrapper );
      item.attr("data-duplicate",((_len + 1) - 1));
      item.find("button[data-remove]").attr("data-remove",((_len + 1) - 1)).removeClass("hidden");

      item.find("input").val("");

      item.find("button[data-remove]").on("click",function(){
        item.remove();
      })

      return false;

    })

    CKEDITOR.on('instanceReady', function(){
       $.each( CKEDITOR.instances, function(instance) {
        CKEDITOR.instances[instance].on("change", function(e) {
            for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
        });
       });
    });

    $("form[role='form']").each(function(){

        var $form = $(this);

        $form.submit(function(){

            var $this   = $(this),
                action  = $this.attr("action"),
                method  = $this.attr("method"),
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
                      for (var j = 0; j < files[i].files.length; j++) {
                        if(files[i].files[j] != undefined)
                        {
                            content.append(files.eq(i).attr("name"), files[i].files[j], files[i].files[j].name );// add files if exits
                        }
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
                      if (response.data.status)
                      {
                         toastr.success( response.data.message, "" , {"positionClass": "toast-top-full-width"});
                      }
                      else
                      {
                        toastr.error( response.data.message, "" , {"positionClass": "toast-top-full-width"});
                      }

                      if (response.data.redirect)
                      {
                        setTimeout(function(){
                          window.location.href = response.data.redirect.location
                        }, response.data.redirect.time)
                      }
                    }
                });

            return false;
        });

    });

})();
