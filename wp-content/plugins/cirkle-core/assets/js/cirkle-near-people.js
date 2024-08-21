(function ($) {
    "use strict";  

    function stateByCountry( user_country, selector, user_state = '' ) {
        $.ajax({
            type: "POST",
            data: {
                action: "state_by_country", 
                value: user_country,
                user_state,
                elementor: true,
            },
            dataType: "html",
            url: CirkleCoreObj.ajaxurl,
            beforeSend: function () {   
            },
            success: function ( resp ) { 
                let content = JSON.parse(resp); 

                $(selector).html(content.data);
            },
        });
    }

    $(document).ready(function () { 
        elementor.hooks.addAction( 'panel/open_editor/widget', function( panel, model, view ) { 
            //get post type 
            $('[data-setting="user_country"]').change(function() {     
                let location = $(this).val(); 
                if ( location ) { 
                    stateByCountry( location, '[data-setting="user_state"]' );
                }
            });
             
            let location = $('[data-setting="user_country"]').val();  
            if ( location ) { 
                let user_state = model.attributes.settings.attributes.user_state;
                stateByCountry( location, '[data-setting="user_state"]', user_state );
            }
        } );
    });


})(jQuery);