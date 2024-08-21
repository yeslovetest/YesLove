(function ($) {
    "use strict";

    $(".page-content").click(function(){
        $('.cirkle-search-result').addClass('search-result-dislogbox');
    });

    function cirkle_ajax_search() {
        $('#top-search-form-two input').on('keyup', function () {
            let value = $(this).val();
            if (value.length >= 3) {
                $('.cirkle-search-result').removeClass('search-result-dislogbox');

                //get members
                $.ajax({
                    type: "POST",
                    data: {
                        action: "ajax_search_member",
                        value: value
                    },
                    dataType: "html",
                    url: CirkleObj.ajaxurl,
                    beforeSend: function () {
                        $('.cirkle-search-member-content').html('<span class="loader"></span>');
                    },
                    success: function (resp) {
                        let content = JSON.parse(resp);
                        if (content.data.length) {
                            $('.cirkle-search-member-content').html(content.data);
                            $('.cirkle-search-member').removeClass('no-member-found');
                        } else {
                            $('.cirkle-search-member-content').html('<li class="no-result">No Member Found</li>');
                            $('.cirkle-search-member').addClass('no-member-found');
                        }
                    },
                });

                //get groups
                $.ajax({
                    type: "POST",
                    data: {
                        action: "ajax_search_group",
                        value: value
                    },
                    dataType: "html",
                    url: CirkleObj.ajaxurl,
                    beforeSend: function () {
                        $('.cirkle-search-group-content').html('<span class="loader"></span>');
                    },
                    success: function (resp) {
                        let content = JSON.parse(resp);
                        if (content.data.length) {
                            $('.cirkle-search-group-content').html(content.data);
                            $('.cirkle-search-group').removeClass('no-group-found');
                        } else {
                            $('.cirkle-search-group-content').html('<li class="no-result">No Group Found</li>');
                            $('.cirkle-search-group').addClass('no-group-found');
                        }
                    },
                });

                //get posts
                $.ajax({
                    type: "POST",
                    data: {
                        action: "ajax_search_post",
                        value: value
                    },
                    dataType: "html",
                    url: CirkleObj.ajaxurl,
                    beforeSend: function () {
                        $('.cirkle-search-post-content').html('<span class="loader"></span>');
                    },
                    success: function (resp) {
                        let content = JSON.parse(resp);
                        if (content.data.length) {
                            $('.cirkle-search-post-content').html(content.data);
                            $('.cirkle-search-post').removeClass('no-post-found');
                        } else {
                            $('.cirkle-search-post-content').html('<li class="no-result">No Post Found</li>');
                            $('.cirkle-search-post').addClass('no-post-found');
                        }
                    },
                });

                //get posts
                $.ajax({
                    type: "POST",
                    data: {
                        action: "ajax_search_product",
                        value: value
                    },
                    dataType: "html",
                    url: CirkleObj.ajaxurl,
                    beforeSend: function () {
                        $('.cirkle-search-product-content').html('<span class="loader"></span>');
                    },
                    success: function (resp) {
                        let content = JSON.parse(resp);
                        if (content.data.length) {
                            $('.cirkle-search-product-content').html(content.data);
                            $('.cirkle-search-product').removeClass('no-product-found');
                        } else {
                            $('.cirkle-search-product-content').html('<li class="no-result">No Product Found</li>');
                            $('.cirkle-search-product').addClass('no-product-found');
                        }
                    },
                });

            } else {
                $('.cirkle-search-result').addClass('search-result-dislogbox');
            }
        });
    }

    function cirkle_scripts_load() {
        /*-------------------------------------
            Slick Carousel
        -------------------------------------*/
        $(".slick-carousel").slick();

        // Ajax Function
        var page = 2;
        $(document).on("click", "#loadMore", function (event) {
            event.preventDefault();

            jQuery("#loadMore").addClass("loading-lazy");

            var $container = jQuery(".product-list-wrap");
            $.ajax({
                type: "GET",
                data: {
                    action: "load_more_ports",
                    numPosts: 2,
                    pageNumber: page,
                },
                dataType: "html",
                url: CirkleObj.ajaxurl,
                success: function (html) {
                    var $data = jQuery(html);
                    if ($data.length) {
                        $container.append(html);
                        jQuery("#loadMore").removeClass("loading-lazy");
                    } else {
                        jQuery("#loadMore").html("No More Products");
                        jQuery("#loadMore").removeClass("loading-lazy");
                    }
                    setTimeout(function () {
                        revealPosts();
                    }, 500);
                },
            });
            page++;
        });

        /* helper functions */
        function revealPosts() {
            var posts = $(".single-product-item:not(.reveal)");
            var i = 0;
            setInterval(function () {
                if (i >= posts.length) return false;
                var el = posts[i];
                $(el).addClass("reveal");
                i++;
            }, 100);
        }

        // Woo Cart Item Remove Ajax
        if ($(".header-shop-cart").length) {
            $(document).on("click", ".remove-cart-item", function () {
                var product_id = $(this).attr("data-product_id");
                var loader_url = $(this).attr("data-url");
                var main_parent = $(this).parents(".dropdown-cart");
                var parent_li = $(this).parents("li.cart-item");
                parent_li.find(".remove-item-overlay").css({display: "block"});
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: CirkleObj.ajaxurl,
                    data: {
                        action: "cirkle_product_remove",
                        product_id: product_id,
                    },
                    success: function (data) {
                        main_parent.html(data["mini_cart"]);
                        $(document.body).trigger("wc_fragment_refresh");
                    },
                    error: function (xhr, status, error) {
                        $(".header-shop-cart")
                            .children("ul.minicart")
                            .html(
                                '<li class="cart-item"><p class="cart-update-pbm text-center">' +
                                CirkleObj.cart_update_pbm +
                                "</p></li>"
                            );
                    },
                });
                return false;
            });
        }

    }

    /*-------------------------------------
    On Scroll
    -------------------------------------*/

    $(window).on("scroll", function () {
        if ($(window).scrollTop() >= $("body").offset().top + 50) {
            $("body").addClass("mn-top");
        } else {
            $("body").removeClass("mn-top");
        }

        // Back Top Button
        if ($(window).scrollTop() > 500) {
            $(".scrollup").addClass("back-top");
        } else {
            $(".scrollup").removeClass("back-top");
        }

        // Sticky Header
        if ($("body").hasClass("sticky-header")) {
            var stickyPlaceHolder = $("#rt-sticky-placeholder"),
                hasAdminBar = $("body").hasClass("admin-bar"),
                menu = $("#header-menu"),
                menuH = menu.outerHeight(),
                topHeaderH = $("#header-topbar").outerHeight() || 0,
                middleHeaderH = $("#header-middlebar").outerHeight() || 0,
                targrtScroll = topHeaderH + middleHeaderH + (hasAdminBar ? 32 : 0);
            if ($(window).scrollTop() > targrtScroll) {
                menu.addClass("rt-sticky");
                stickyPlaceHolder.height(menuH);
            } else {
                menu.removeClass("rt-sticky");
                stickyPlaceHolder.height(0);
            }
        }
    });

    // Fixing for hover effect at IOS /
    $('*').on('touchstart', function () {
        $(this).trigger('hover');
    }).on('touchend', function () {
        $(this).trigger('hover');
    });

    /*---------------------------------------
    On Click Section Switch
    --------------------------------------- */
    $('[data-type="section-switch"]').on("click", function () {
        if (
            location.pathname.replace(/^\//, "") ===
            this.pathname.replace(/^\//, "") &&
            location.hostname === this.hostname
        ) {
            var target = $(this.hash);
            if (target.length > 0) {
                target = target.length
                    ? target
                    : $("[name=" + this.hash.slice(1) + "]");
                $("html,body").animate(
                    {
                        scrollTop: target.offset().top,
                    },
                    1000
                );
                return false;
            }
        }
    });

    /*-------------------------------------
    Page Preloader
    -------------------------------------*/
    $("#preloader").fadeOut("slow", function () {
        $(this).remove();
    });

    // $(".user-top-header ul li a").attr( "target", "_blank" );

    /*-------------------------------------
    Side menu class Add
    --------------------------------------*/
    $("#wrapper").on("click", ".toggler-open", function (event) {
        event.preventDefault();

        var $this = $(this),
            wrapp = $(this).parents("body").find("#wrapper"),
            wrapMask = $("<div / >").addClass("closeMask"),
            sideMenuSelect = ".fixed-sidebar";

        if (!$this.parents(sideMenuSelect).hasClass("lg-menu-open")) {
            wrapp.addClass("open").append(wrapMask);
            $this.parents(sideMenuSelect).addClass("lg-menu-open");
        } else {
            removeSideMenu();
        }

        function removeSideMenu() {
            wrapp.removeClass("open").find(".closeMask").remove();
            $this.parents(sideMenuSelect).removeClass("lg-menu-open");
        }

        $(".toggler-close, .closeMask").on("click", function () {
            removeSideMenu();
        });
    });

    function mobile_nav_class() {

        var a = $('.offscreen-navigation .cirkle-main-menu');

        if (a.length) {
            $(".menu-item-has-children").append("<span></span>");
            $(".page_item_has_children").append("<span></span>");

            a.children("li").addClass("menu-item-parent");

            $('.menu-item-has-children > span').on('click', function () {
                var _self = $(this),
                    sub_menu = _self.parent().find('>.sub-menu');
                if (_self.hasClass('open')) {
                    sub_menu.slideUp();
                    _self.removeClass('open');
                } else {
                    sub_menu.slideDown();
                    _self.addClass('open');
                }
            });
            $('.page_item_has_children > span').on('click', function () {
                var _self = $(this),
                    sub_menu = _self.parent().find('>.children');
                if (_self.hasClass('open')) {
                    sub_menu.slideUp();
                    _self.removeClass('open');
                } else {
                    sub_menu.slideDown();
                    _self.addClass('open');
                }
            });
        }

        $('.mean-bar .sidebarBtn').on('click', function (e) {
            e.preventDefault();
            if ($('.rt-slide-nav').is(":visible")) {
                $('.rt-slide-nav').slideUp();
                $('body').removeClass('slidemenuon');
            } else {
                $('.rt-slide-nav').slideDown();
                $('body').addClass('slidemenuon');
            }
        });
    }

    mobile_nav_class();

    /*-------------------------------------
    Chat Conversation Box
    -------------------------------------*/

    $("#chat-head-toggle").on("click", function () {
        $(this).parents(".fixed-sidebar").toggleClass("chat-head-hide");
    });

    $(".chat-plus-icon").on("click", function () {
        $(this).siblings(".file-attach-icon").toggleClass("show");
    });

    $(".chat-shrink").on("click", function () {
        $(this).parents("#chat-box-modal").toggleClass("shrink");
    });

    $(".chat-open").on("click", function () {
        $("#chat-box-modal").toggleClass("modal-show");
        setTimeout(function () {
            $("#chat-box-modal").removeClass("shrink");
        }, 300);
    });

    $(".drop-btn").on("click", function () {
        var $this = $(this),
            elment = $(".drop-menu"),
            maskWrap = $("<div / >").addClass("closeMask");
        if (!elment.hasClass("show")) {
            $this.siblings(elment).addClass("show");
            $("#wrapper").addClass("open").append(maskWrap);
        } else {
            $this.siblings(elment).removeClass("show");
            $("#wrapper").find(".closeMask").remove();
        }
        $(".closeMask").on("click", function () {
            $this.siblings(elment).removeClass("show");
            $("#wrapper").find(".closeMask").remove();
        });
    });

    /*-------------------------------------
    Section background image
    -------------------------------------*/
    $("[data-bg-image]").each(function () {
        var img = $(this).data("bg-image");
        $(this).css({
            backgroundImage: "url(" + img + ")",
        });
    });

    $('.grid').masonry({
        // options
        itemSelector: '.grid-item'
    });


    /*-------------------------------------
        Product View
    -------------------------------------*/
    $(".user-view-trigger").on("click", function (e) {
        var self = $(this),
            data = self.attr("data-type"),
            target = $("#user-view");
        self.parents(".user-view-switcher").find("li.active").removeClass("active");
        self.parent("li").addClass("active");
        target
            .children(".row")
            .find(">div")
            .animate({opacity: 0}, 200, function () {
                if (data === "user-grid-view") {
                    target.removeClass("user-list-view");
                    target.addClass("user-grid-view");
                } else if (data === "user-list-view") {
                    target.removeClass("user-grid-view");
                    target.addClass("user-list-view");
                }
                target.children(".row").find(">div").animate(
                    {
                        opacity: 1,
                    },
                    100
                );
            });
        e.preventDefault();
        return false;
    });

    /*-------------------------------------
     Quantity Holder
     -------------------------------------*/
    $(document).on(
        "click",
        ".quantity .input-group-btn .quantity-btn",
        function () {
            var $input = $(this).closest(".quantity").find(".input-text");

            if ($(this).hasClass("quantity-plus")) {
                $input.trigger("stepUp").trigger("change");
            }

            if ($(this).hasClass("quantity-minus")) {
                $input.trigger("stepDown").trigger("change");
            }
        }
    );

    /*-------------------------------------
        ElevateZoom
    -------------------------------------*/

    $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
        elevateZoom();
    });

    function elevateZoom() {
        if ($.fn.elevateZoom !== undefined) {
            $(".zoom_01").elevateZoom({
                zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 500,
                zoomWindowFadeOut: 200,
            });
        }
    }

    elevateZoom();

    /*-------------------------------------
        Tooltip
    -------------------------------------*/
    $('[data-toggle="tooltip"]').tooltip();

    /*-------------------------------------
        Select2 activation code
    -------------------------------------*/
    if ($("select.select2").length) {
        $("select.select2").select2({
            theme: "classic",
            dropdownAutoWidth: true,
            width: "100%",
            minimumResultsForSearch: Infinity,
        });
    }

    /*-------------------------------------
        Video Popup
    -------------------------------------*/
    var yPopup = $(".popup-youtube");
    if (yPopup.length) {
        yPopup.magnificPopup({
            disableOn: 700,
            type: "iframe",
            mainClass: "mfp-fade",
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false,
        });
    }

    /*-------------------------------------
     Gallery Popup
    -------------------------------------*/
    if ($(".zoom-gallery").length) {
        $(".zoom-gallery").each(function () {
            $(this).magnificPopup({
                delegate: "a.popup-zoom",
                type: "image",
                gallery: {
                    enabled: true,
                },
            });
        });
    }

    /*-------------------------------------
        Sal Init
    -------------------------------------*/
    sal({
        threshold: 0.05,
        once: true,
    });

    if ($(window).outerWidth() < 1025) {
        var scrollAnimations = sal();
        scrollAnimations.disable();
    }

    /*-------------------------------------
    Jquery Serch Box
    -------------------------------------*/
    $('a[href="#header-search"]').on("click", function (event) {
        event.preventDefault();
        var target = $("#header-search");
        target.addClass("open");
        setTimeout(function () {
            target.find("input").focus();
        }, 600);
        return false;
    });

    $("#header-search, #header-search button.close").on(
        "click keyup",
        function (event) {
            if (
                event.target === this ||
                event.target.className === "close" ||
                event.keyCode === 27
            ) {
                $(this).removeClass("open");
            }
        }
    );

    // Window Load+Resize
    // $(window).on("load resize", function () {
    //     // Elementor Frontend Load
    //     $(window).on("elementor/frontend/init", function () {
    //         if (elementorFrontend.isEditMode()) {
    //             elementorFrontend.hooks.addAction(
    //                 "frontend/element_ready/widget",
    //                 function () {
                        
    //                 }
    //             );
    //         }
    //     });
    // });

    // Elementor Frontend Load
    $(window).on('elementor/frontend/init', function () {
        if (elementorFrontend.isEditMode()) {
            elementorFrontend.hooks.addAction('frontend/element_ready/widget', function () {
               cirkle_scripts_load();
            });
        }
    });

    // Window Load
    $(window).on("load", function () {
        cirkle_scripts_load();
    });

    // RTReaction js
    $(document).ready(function () {
        if (typeof rtreact_list !== "undefined") {
            var template = wp.template("rtreact-list");
            var template_html = template({reactions: rtreact_list});
            $(".post-react").each(function (item) {
                var _item = $(this);
                if (!_item.find(".react-list").length) {
                    _item.append(template_html);
                }
            });
        }

        cirkle_ajax_search();

        if (CirkleObj.buddypress) {
            $('#aw-whats-new-submit')
                .unbind()
                .on('click', function (e) {
                    e.preventDefault();
                    var last_date_recorded = 0,
                        button = $(this),
                        form = button.closest('form#whats-new-form'),
                        inputs = {}, post_data;

                    // Get all inputs and organize them into an object {name: value}
                    $.each(form.serializeArray(), function (key, input) {
                        // Only include public extra data
                        if ('_' !== input.name.substr(0, 1) && 'whats-new' !== input.name.substr(0, 9)) {
                            if (!inputs[input.name]) {
                                inputs[input.name] = input.value;
                            } else {
                                // Checkboxes/dropdown list can have multiple selected value
                                if (!Array.isArray(inputs[input.name])) {
                                    inputs[input.name] = new Array(inputs[input.name], input.value);
                                } else {
                                    inputs[input.name].push(input.value);
                                }
                            }
                        }
                    });

                    form.find('*').each(function (i, elem) {
                        if (elem.nodeName.toLowerCase() === 'textarea' || elem.nodeName.toLowerCase() === 'input') {
                            $(elem).prop('disabled', true);
                        }
                    });

                    /* Remove any errors */
                    $('div.error').remove();
                    button.addClass('loading');
                    button.prop('disabled', true);
                    form.addClass('submitted');

                    /* Default POST values */
                    var object = '';
                    var item_id = $('#whats-new-post-in').val();
                    var content = $('#whats-new').val();
                    var firstrow = $('#buddypress ul.activity-list li').first();
                    var activity_row = firstrow;
                    var timestamp = null;

                    // Checks if at least one activity exists
                    if (firstrow.length) {

                        if (activity_row.hasClass('load-newest')) {
                            activity_row = firstrow.next();
                        }

                        timestamp = activity_row.prop('class').match(/date-recorded-([0-9]+)/);
                    }

                    if (timestamp) {
                        last_date_recorded = timestamp[1];
                    }

                    /* Set object for non-profile posts */
                    if (item_id > 0) {
                        object = $('#whats-new-post-object').val();
                    }

                    post_data = $.extend({
                        action: 'post_update',
                        'cookie': bp_get_cookies(),
                        '_wpnonce_post_update': $('#_wpnonce_post_update').val(),
                        'content': content,
                        'object': object,
                        'item_id': item_id,
                        'since': last_date_recorded,
                        '_bp_as_nonce': $('#_bp_as_nonce').val() || ''
                    }, inputs);

                    $.post(ajaxurl, post_data, function (response) {
                        form.find('*').each(function (i, elem) {
                            if (elem.nodeName.toLowerCase() === 'textarea' || elem.nodeName.toLowerCase() === 'input') {
                                $(elem).prop('disabled', false);
                            }
                        });

                        /* Check for errors and append if found. */
                        if (response[0] + response[1] === '-1') {
                            form.prepend(response.substr(2, response.length));
                            $('#' + form.attr('id') + ' div.error').hide().fadeIn(200);
                        } else {
                            var event = new CustomEvent('cirkle_bp_activity_updated', {detail: "dsds"});
                            document.dispatchEvent(event);
                            if (0 === $('ul.activity-list').length) {
                                $('div.error').slideUp(100).remove();
                                $('#message').slideUp(100).remove();
                                $('div.activity').append('<ul id="activity-stream" class="activity-list item-list">');
                            }

                            if (firstrow.hasClass('load-newest')) {
                                firstrow.remove();
                            }

                            $('#activity-stream').prepend(response);

                            if (!last_date_recorded) {
                                $('#activity-stream li:first').addClass('new-update just-posted');
                            }

                            if (0 !== $('#latest-update').length) {
                                var l = $('#activity-stream li.new-update .activity-content .activity-inner p').html(),
                                    v = $('#activity-stream li.new-update .activity-content .activity-header p a.view').attr('href'),
                                    ltext = $('#activity-stream li.new-update .activity-content .activity-inner p').text(),
                                    u = '';

                                if (ltext !== '') {
                                    u = l + ' ';
                                }

                                u += '<a href="' + v + '" rel="nofollow">' + BP_DTheme.view + '</a>';

                                $('#latest-update').slideUp(300, function () {
                                    $('#latest-update').html(u);
                                    $('#latest-update').slideDown(300);
                                });
                            }

                            $('li.new-update').hide().slideDown(300);
                            $('li.new-update').removeClass('new-update');
                            $('#whats-new').val('');
                            form.get(0).reset();

                            // reset vars to get newest activities
                            /** global activity_last_recorded */
                            newest_activities = '';
                            activity_last_recorded = 0;
                        }

                        $('#whats-new-options').slideUp();
                        $('#whats-new-form textarea').animate({
                            height: '2.2em'
                        });
                        $('#aw-whats-new-submit').prop('disabled', true).removeClass('loading');
                        $('#whats-new-content').removeClass('active');
                    });

                    return false;
                });

        }
    });

    $(document).on("click", ".post-react .react-list li", function (e) {
        e.preventDefault();
        var _self = $(this),
            reaction_id = parseInt(_self.data("id"), 10) || 0,
            activity = _self.closest(".activity-item"),
            pr_wrap = $(".post-reaction", activity),
            activity_id = activity.attr("id"),
            post_id = activity_id ? activity_id.replace("activity-", "") : 0,
            post_id = parseInt(post_id, 10) || 0;

        var single_blog_wrap = $(".user-single-blog");
        if (!post_id && single_blog_wrap.length) {
            var blog_id = single_blog_wrap.attr("id");
            post_id = blog_id ? blog_id.replace("post-", "") : 0;
            post_id = parseInt(post_id, 10) || 0;
            pr_wrap = $(".blog-post-reactions");
        }
        if (reaction_id && post_id) {
            $.ajax({
                url: CirkleObj.ajaxurl,
                beforeSend: function () {
                },
                method: "POST",
                data: {
                    action: "rtreact_create_post_reaction",
                    reaction_id: reaction_id,
                    post_id: post_id,
                },
            })
                .done(function (res) {
                    if (res.success) {
                        pr_wrap.html(res.data.reactions_html);
                    }
                })
                .fail(function () {
                    alert("error");
                });
        } else {
            alert("Missing required argument");
        }
        return false;
    });

    $(document)
        .on('click', '#mpp-activity-upload-buttons a', function (e) {
            e.preventDefault();
            var $container = jq('#mpp-upload-dropzone-activity').closest('.mpp-media-upload-container');
            if ($container.hasClass('mpp-upload-container-active')) {
                $container.slideDown('slow', function () {
                    $(this).removeClass('mpp-upload-container-active').addClass('mpp-upload-container-inactive');
                });
            }
            return false;
        })
        .on('mpp:uploader:upload:complete', function (self, up, files) {
            $('#aw-whats-new-submit').removeAttr('disabled').removeClass('loading');
        });


    var WooCommerce = {
        wishlist_icon: function wishlist_icon() {
            $(document).on('click', '.rdtheme-wishlist-icon', function () {
                if ($(this).hasClass('rdtheme-add-to-wishlist')) {
                    var $obj = $(this),
                        productId = $obj.data('product-id'),
                        afterTitle = $obj.data('title-after');
                    var data = {
                        'action': 'cirkle_add_to_wishlist',
                        'context': 'frontend',
                        'nonce': CirkleObj.wishlist_nonce,
                        'add_to_wishlist': productId
                    };
                    $.ajax({
                        url: CirkleObj.ajaxurl,
                        type: 'POST',
                        data: data,
                        beforeSend: function beforeSend() {
                            $obj.find('.wishlist-icon').hide();
                            // $obj.find('.wl-btn-text').hide();
                            $obj.find('.ajax-loading').show();
                            $obj.addClass('rdtheme-wishlist-ajaxloading');
                        },
                        success: function success(data) {
                            if (data['result'] != 'error') {
                                $obj.find('.ajax-loading').hide();
                                $obj.removeClass('rdtheme-wishlist-ajaxloading');
                                $obj.find('.wishlist-icon').removeClass('far fa-heart').addClass('fas fa-heart').show();
                                $obj.removeClass('rdtheme-add-to-wishlist').addClass('rdtheme-remove-from-wishlist');
                                $obj.attr('title', afterTitle);
                                $obj.find('.wl-btn-text').text(afterTitle);
                                $(".wl-btn-text").text(function (index, text) {
                                    return text.replace("Add to Wishlist", "Added in Wishlist! View Wishlist");
                                });
                            } else {
                                console.log(data['message']);
                            }
                        }
                    });
                    return false;
                }
            });
        }
    };

    $(document).ready(function () {
        WooCommerce.wishlist_icon();
    });

})(jQuery);
