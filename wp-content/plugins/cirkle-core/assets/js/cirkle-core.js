(function ($) {
    "use strict";

    function cirkleStateByCountry() {
        $('#user_country').on('change', function() { 
            let value = $(this).val();  
            stateByCountry( value, '#user_state' ); 
        });
        let user_country = $('#user_country :selected').val(); 
        if ( user_country ) {
            let user_state = $('#user_country').data('state');  
            stateByCountry( user_country, '#user_state', user_state );
        }
    }

    function stateByCountry( user_country, selector, user_state = '' ) {
        $.ajax({
            type: "POST",
            data: {
                action: "state_by_country", 
                value: user_country,
                user_state,
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
        /*-------------------------------------
         Select2 activation code
         -------------------------------------*/
        if ($('select.select2-search').length) {
            
            $('select.select2-search').select2({
                theme: 'classic',
                dropdownAutoWidth: true
            });
        }
        cirkleStateByCountry();
    });

    // Window Load+Resize
    $(window).on('load resize', function () {
        // Elementor Frontend Load
        $(window).on('elementor/frontend/init', function () {
            if (elementorFrontend.isEditMode()) {
                elementorFrontend.hooks.addAction('frontend/element_ready/widget', function () {
                    cirkleStateByCountry();
                });
            }
        });
    });

})(jQuery);