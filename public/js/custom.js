var ajax_loader_f;
jQuery(document).ready(function ($) {


    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });


    /* Menu Mobile */
    var $menu_show = $('.mobile-toggle'), $menu = $('header #menu-main'), $list = $("ul.nav-menu li a"),
        $menu_list = $('header li.has-dropdown'), $menu_ul = $('ul.sub-menu'), $cart_model = $('.cart-model'),
        $cart_link = $('#cart-link'), $search_bar = $('#search_bar'), $search_close = $('.close-search'),
        $search_bot = $('#search-header'), $fixed_header = $('#fixed-header'),
        $fixed_header_dark = $('#fixed-header-dark'), $sticky_content = $('.sticky-content'),
        $sticky_sidebar = $('.sticky-sidebar');

    $menu_show.click(function (event) {
        $menu.slideToggle();
    });


    $list.click(function (event) {
        var submenu = this.parentNode.getElementsByTagName("ul").item(0);
        //S'il existe un sous menu sinon c'est un lien terminal
        if (submenu != null) {
            event.preventDefault();
            $(submenu).slideToggle();
        }
    });


    $(window).resize(function () {
        if ($(window).width() > 1024) {
            $("#menu-main > ul, nav > #menu-main  li  ul").removeAttr("style");
        }
    });


    /* Cart */
    $cart_link.click(function () {
        $cart_model.slideToggle("fast");
    });

    $(window).click(function () {
        $cart_model.hide("fast");
    });
    $cart_link.click(function (event) {
        event.stopPropagation();
    });
    /* Cart */


    /* Search */
    $search_bot.click(function () {
        $search_bar.slideToggle("fast");
    });
    $search_close.click(function () {
        $search_bar.hide("fast");
    });


    /* owl Slider  */
    var owl = $(".travelers-say");
    var owl2 = $(".slider-1");
    var owl3 = $(".travelers-say-3");

    owl.add(owl2).owlCarousel({
        dotsContainer: '#carousel-custom-dots', items: 1, //10 items above 1000px browser width
        itemsDesktop: [1000, 2], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 2], // betweem 900px and 601px
        itemsTablet: [600, 1], //2 items between 600 and 0
        itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option
    });
    owl3.owlCarousel({
        dotsContainer: '#carousel-custom-dots', items: 3, //10 items above 1000px browser width
        itemsDesktop: [1000, 3], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 3], // betweem 900px and 601px
        itemsTablet: [600, 1], //2 items between 600 and 0
        itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option
    });

    /* Tooltip  */
    $('[data-toggle="tooltip"]').tooltip()


    /* Light Box */
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });


    /*  $fixed_header */
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 300) {
            $fixed_header.addClass('fixed-header');
            $fixed_header_dark.addClass('fixed-header-dark');
        } else {
            $fixed_header.removeClass('fixed-header');
            $fixed_header_dark.removeClass('fixed-header-dark');
        }

        if ($(window).scrollTop() >= 20) {
            $('#btn-back-to-top').show();
        } else {
            $('#btn-back-to-top').hide();
        }

    });


    /**************
     Sticky Sidebar
     **************/

    $sticky_content.theiaStickySidebar({
        additionalMarginTop: 30
    });
    $sticky_sidebar.theiaStickySidebar({
        additionalMarginTop: 30
    });


    /**************
     One Page
     **************/
    $(".nav-btn").click(function () {
        $(this).addClass("active");
        $(this).siblings().removeClass("active");

        var i = $(this).index();
        $('#nav-indicator').css('left', i * 100 + 'px');

        var name = $(this).attr("data-row-id");
        var id = "#" + name;
        var top = $(id).first().offset().top - 60;
        $('html, body').animate({
            scrollTop: top + 'px'
        }, 300);

    });

    /****************************************************
     Div Center
     /****************************************************/
    var $logo = $('.div-center'), $header_output = $('.with-center');


    $(window).resize(function () {
        $logo.css({
            "padding-top": ($header_output.height() - ($logo.outerHeight() + 100)) / 2,
            "padding-bottom": ($header_output.height() - ($logo.outerHeight() + 100)) / 2
        });
    });
    $(window).resize();


//    my code

    $(".way").click(function () {
        $(this).addClass("active_tab");
        $(this).siblings().removeClass("active_tab");

        var i = $(this).data("toggle");
        var x = $(this).data("id");

        $("input[name='search_type']").val(i);

        var r = ".round_trip" + x;
        var r_i = ".daterange" + x;
        var o = ".one_way" + x;
        var o_i = ".date" + x;


        if (i == "R") {
            $(r).removeClass("display_none");
            $(o).addClass("display_none");
            $(r_i).removeAttr("disabled").attr("data-validation", "1");
            $(o_i).attr("disabled", "disabled").attr("data-validation", "0");
            $(".multi_date").attr("disabled", "disabled").attr("data-validation", "0");
            $('#round_trip').addClass("active_nav");
            $('#multi').removeClass("active_nav");
            $('#search_form_main_container').addClass("col-lg-6");
            $('#search_form_main_container').removeClass("col-lg-10");
            $('.filter-tabs').removeClass("col-lg-3");
            $('.filter-tabs').addClass("col-lg-4");
            $('.filter-output').removeClass("col-lg-9");
            $('.filter-output').addClass("col-lg-8");
        } else if (i == "O") {
            $(r).addClass("display_none");
            $(o).removeClass("display_none");
            $(r_i).attr("disabled", "disabled").attr("data-validation", "0");
            $(".multi_date").attr("disabled", "disabled").attr("data-validation", "0");
            $(o_i).removeAttr("disabled").attr("data-validation", "1");
            $('#round_trip').addClass("active_nav");
            $('#multi').removeClass("active_nav");
            $('#search_form_main_container').addClass("col-lg-6");
            $('#search_form_main_container').removeClass("col-lg-10");
            $('.filter-tabs').removeClass("col-lg-3");
            $('.filter-tabs').addClass("col-lg-4");
            $('.filter-output').removeClass("col-lg-9");
            $('.filter-output').addClass("col-lg-8");
        } else {
            $(r_i).attr("disabled", "disabled").attr("data-validation", "0");
            $(o_i).attr("disabled", "disabled").attr("data-validation", "0");
            $(".multi_date").removeAttr("disabled").attr("data-validation", "1");
            $('#round_trip').removeClass("active_nav");
            $('#multi').addClass("active_nav");
            $('#search_form_main_container').addClass("col-lg-10");
            $('#search_form_main_container').removeClass("col-lg-6");
            $('.filter-tabs').removeClass("col-lg-4");
            $('.filter-tabs').addClass("col-lg-3");
            $('.filter-output').removeClass("col-lg-8");
            $('.filter-output').addClass("col-lg-9");
        }


    });

    $(".count_h_up").click(function () {

        var input = $(this).siblings("input");
        var max = input.attr("data-max");
        var value = parseInt(input.val());
        if (value < max) {
            value = value + 1;
            input.val(value)
        }

    });
    $(".count_h_down").click(function () {

        var input = $(this).siblings("input");
        var min = input.attr("data-min");
        var value = parseInt(input.val());
        if (value > min) {
            value = value - 1;
            input.val(value)
        }


    });


    $(".airport_search").keyup(function () {

        var parent = $(".origin");

        $(this).attr("data-validation", "0");

        var data = $(this).val();
        var sec = $(this).data("sec");
        var l = data.length;
        var lang = $("input[name='lang']").val();
        var search_result = ".search_result" + sec;

        if (l > 2) {
            // ajax
            $.ajax({
                url: "/AutoComplete",
                type: "POST",
                data: {data: data, sec: sec, lang: lang},
                beforeSend: function () {
                },
                success: function (data) {

                    $(search_result).html(data);
                    if (window.matchMedia("(max-width: 767px)").matches) {
                        $('html,body').animate({
                            scrollTop: parent.offset().top
                        }, 1000);
                    }

                },
                error: function () {

                }
            });

            // end ajax
        } else {
            $(search_result).html("");

        }
    }).click(function () {

        $(this).select();

    });


    $('.search_form').submit(function () {


        // get all inputs into an array.
        var values = $(this).find(':input');

        var value = {};
        var validation = {};
        var country = {};
        var code = {};
        var date;
        values.each(function () {
            value[this.name] = $(this).val();
            validation[this.name] = $(this).attr("data-validation");
            country[this.name] = $(this).attr("data-country");
            code[this.name] = $(this).attr("data-code");
        });

        var origin_valid = parseInt(validation["origin"]);
        var destination_valid = parseInt(validation["destination"]);

        var adl = parseInt(value["adl"]);
        var chl = parseInt(value["chl"]);
        var inf = parseInt(value["inf"]);

        var origin = value["origin"];
        var destination = value["destination"];
        var origin_country = country["origin"];
        var destination_country = country["destination"];

        let search_type = $("input[name='search_type']").val();
        let multi_validation = 1;
        let multi_date_validation = 1;
        let multi_date_order_validation = 1;

        if (search_type == "M") {
            let count = $(".add_multi").data('count');
            if (!parseInt(validation["origin1"]) || !parseInt(validation["destination1"]) || !parseInt(validation["origin2"]) || !parseInt(validation["destination2"]) || (count >= 3 && (!parseInt(validation["origin3"]) || !parseInt(validation["destination3"]))) || (count >= 4 && (!parseInt(validation["origin4"]) || !parseInt(validation["destination4"])))) {
                multi_validation = 0;
            }

            if (!parseInt(validation["date1"]) || value["date1"] == "" || !parseInt(validation["date2"]) || value["date2"] == "" || (count >= 3 && (!parseInt(validation["date3"]) || value["date3"] == "")) || (count >= 4 && (!parseInt(validation["date4"]) || value["date4"] == ""))) {
                multi_date_validation = 0;
            }
            if (moment(value["date1"], "DD.MM.YYYY") >= moment(value["date2"], "DD.MM.YYYY") || (count >= 3 && moment(value["date2"], "DD.MM.YYYY") >= moment(value["date3"], "DD.MM.YYYY")) || (count >= 4 && moment(value["date3"], "DD.MM.YYYY") >= moment(value["date4"], "DD.MM.YYYY"))) {
                multi_date_order_validation = 0;
            }

        }

        var d_time = value["daterange_d"];
        var r_time = value["daterange_r"];
        var o_time = value["date"];
        var d_time_v = validation["daterange_d"];
        var r_time_v = validation["daterange_r"];
        var o_time_v = validation["date"];

        var d_day = d_time.substring(0, 2);
        var d_month = parseInt(d_time.substring(3, 5)) - 1;
        var d_year = d_time.substring(6, 10);
        var d_day_week = new Date(d_year, d_month, d_day);
        d_day_week = d_day_week.getDay();

        var r_day = r_time.substring(0, 2);
        var r_month = parseInt(r_time.substring(3, 5)) - 1;
        var r_year = r_time.substring(6, 10);
        var r_day_week = new Date(r_year, r_month, r_day);
        r_day_week = r_day_week.getDay();
        var o_day = o_time.substring(0, 2);
        var o_month = parseInt(o_time.substring(3, 5)) - 1;
        var o_year = o_time.substring(6, 10);
        var o_day_week = new Date(o_year, o_month, o_day);
        o_day_week = o_day_week.getDay();
        if (origin_valid == 0 && search_type != "M") {

            alert($("input[name='u_f_a']").val());
            event.preventDefault();

        } else if (destination_valid == 0 && search_type != "M") {

            alert($("input[name='u_t_a']").val());
            event.preventDefault();

        } else if (search_type == "M" && !multi_validation) {

            alert($("input[name='u_t_a']").val());
            event.preventDefault();

        } else if (origin == destination && search_type != "M") {

            alert($("input[name='same_error']").val());
            event.preventDefault();
        } else if (search_type == "M" && !multi_date_validation) {

            alert($("input[name='u_d']").val());
            event.preventDefault();
        } else if (search_type == "M" && !multi_date_order_validation) {

            alert($("input[name='u_d_o']").val());
            event.preventDefault();
        }
            // else if (origin_country == destination_country && origin_country == "IR") {
            //     alert($("input[name='local_error']").val());
            //     event.preventDefault();
        // }
        else if ((d_time == "" || r_time == "" || d_time_v == 0) && (o_time == "" || o_time_v == 0) && search_type != "M") {

            alert($("input[name='u_d']").val());
            event.preventDefault();

        } else if (adl + chl + inf > 9) {

            alert($("input[name='t_n_e']").val());
            event.preventDefault();

        } else if (inf > adl) {

            alert($("input[name='i_w_a']").val());
            event.preventDefault();

        } else {

            if (d_time_v == 1) {
                date = d_time;
                date_day_week = d_day_week;
            } else {
                date = o_time;
                date_day_week = o_day_week;
            }

            if (d_time_v == 0) {
                r_time = '-';
                r_day_week = "";
            }
            search_loader_show(code["origin"], code["destination"], value["origin"], value["destination"], adl, chl, inf, date, r_time, date_day_week, r_day_week);

        }

    });
    $('.cip_search_form').submit(function () {


        // get all inputs into an array.
        var values = $(this).find(':input');

        var value = {};
        var validation = {};
        var country = {};
        var code = {};
        var date;
        values.each(function () {
            value[this.name] = $(this).val();
            validation[this.name] = $(this).attr("data-validation");
            country[this.name] = $(this).attr("data-country");
            code[this.name] = $(this).attr("data-code");
        });

        var origin_valid = parseInt(validation["cip_airport"]);
        var airline_valid = parseInt(validation["airline"]);

        var adl = parseInt(value["adl"]);
        var chl = parseInt(value["chl"]);
        var inf = parseInt(value["inf"]);

        var origin = value["cip_airport"];


        var time = value["cip_date"];
        var d = time.slice(0, 2);
        var m = time.slice(3, 5);

        m = parseInt(m) - 1;

        var y = time.slice(6, 10);

        date = new Date(y, m, d);

        date.setDate(date.getDate() - 1);

        var today = new Date();

        if (origin_valid == 0) {

            alert($("input[name='u_a']").val());
            event.preventDefault();

        } else if (airline_valid == 0) {

            alert($("input[name='u_airline']").val());
            event.preventDefault();

        } else if (time == "") {

            alert($("input[name='u_d']").val());
            event.preventDefault();

        } else if (date <= today) {

            alert($("input[name='cip_min_2_day']").val());
            event.preventDefault();

        }


    });


    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 6, spaceBetween: 30, slidesPerGroup: 1, loop: true, breakpoints: {
            768: {
                slidesPerView: 1,
            }, 992: {
                slidesPerView: 3,
            }
        }, autoplay: {
            delay: 2500, disableOnInteraction: false,
        }, loopFillGroupWithBlank: true, pagination: {
            el: '.swiper-pagination', clickable: true,
        },

    });


    // pagination code
    // jQuery(document).on('click', '.my_pagination', function (e) {
    //     e.preventDefault();
    //
    //     var is_none_stop = $("input[name='is_none_stop']").val();
    //
    //     var x = parseInt($(this).attr('data-count'));
    //     var y = parseInt($(this).attr('data-target'));
    //     x = x + 1;
    //
    //     var start = x * 25 - 25;
    //
    //     filtering(start, 25, 0, is_none_stop, y);
    //
    // });
    // pagination code

    // filter code
    // filter code

    // only button filter
    // only button filter

    // airline list filter
    // jQuery(document).on('click', '.airline_list_filter', function () {
    //
    //     var id = $(this).data("id")
    //
    //     var lang = $("input[name='lang']").val();
    //     var search_id = $("input[name='sch_id']").val();
    //     var order = $(".active_order").attr('data-target');
    //
    //     $('.flight_sidebar_container input:enabled').prop('checked', true);
    //
    //     var is_none_stop = $("input[name='is_none_stop']").val();
    //
    //     var x = $(".my_pagination").attr('data-count');
    //
    //
    //     // ajax
    //     $.ajax({
    //         url: "/select_flight", type: "POST", cache: true, data: {
    //             search_id: search_id, lang: lang, order: order, id: id, is_none_stop: is_none_stop
    //         }, dataType: 'html', beforeSend: function () {
    //             ajax_show(1);
    //         }, success: function (data) {
    //
    //             $(".flight_main_container").remove();
    //             $(".ajax_flight_loader_container").remove();
    //             $('#flight_main_container0').html(JSON.parse(data).html);
    //
    //             var count = $(".flight_container").length;
    //             $(".pagination_count_span").html(count);
    //
    //             if ($(".flight_container").length == JSON.parse(data).count) {
    //                 $(".my_pagination").hide();
    //             } else {
    //                 $(".my_pagination").show();
    //
    //             }
    //
    //             $(".pagination_total_span").html(JSON.parse(data).count);
    //
    //             ajax_show(0);
    //
    //             var te = "#fl" + id;
    //             $('html,body').animate({
    //                 scrollTop: $(te).offset().top
    //             }, 1000);
    //
    //         }, error: function () {
    //             ajax_show(0);
    //         }
    //     });
    //
    //     // end ajax
    //
    //
    // })
    // airline list filter


    // choose all airline
    // choose all


    // slide time filter

    function slide_filter_init() {
        $(".slide_filter").slider({
            range: true,
            step: 30,
            min: 0,
            max: $("input[name='max_waiting']").val(),
            values: [0, $("input[name='max_waiting']").val()],
            slide: function (event, ui) {

                var target = "#" + $(this).attr('data-target');


                var start_hour = parseInt(ui.values[0] / 60);
                var start_min = parseInt(ui.values[0] % 60);
                var end_hour = parseInt(ui.values[1] / 60);
                var end_min = parseInt(ui.values[1] % 60);
                if (start_hour < 10) start_hour = "0" + start_hour;
                if (start_min < 10) start_min = "0" + start_min;
                if (end_hour < 10) end_hour = "0" + end_hour;
                if (end_min < 10) end_min = "0" + end_min;

                $(target).val("" + start_hour + ":" + start_min + " - " + end_hour + ":" + end_min);


            },
            stop: function (event, ui) {

                var start_min = ui.values[0];
                var end_min = ui.values[1];

                var is_none_stop = $("input[name='is_none_stop']").val();

                var x = $(".my_pagination").attr('data-count');

                $(this).attr('data-start', start_min);
                $(this).attr('data-end', end_min);


                var length = x * 25;
                var start = 0;
                filtering(start, length, 1, is_none_stop);

                $('html,body').animate({
                    scrollTop: $(".flight_post_body").offset().top
                }, 1000);


            }

        });

        $(".slide_filter").each(function () {

            $(this).slider({
                values: [0, $("input[name='max_waiting']").val()]
            });

            var target = "#" + $(this).attr('data-target');
            var start_hour = 0;  //parseInt($(this).slider("values", 0) / 60);
            var start_min = 0;  //parseInt($(this).slider("values", 0) % 60);
            var end_hour = $("input[name='max_waiting']").val() / 60;    //parseInt($(this).slider("values", 1) / 60);
            var end_min = 0;   //parseInt($(this).slider("values", 1) % 60);
            if (start_hour < 10) start_hour = "0" + start_hour;
            if (start_min < 10) start_min = "0" + start_min;
            if (end_hour < 10) end_hour = "0" + end_hour;
            if (end_min < 10) end_min = "0" + end_min;
            $(target).val("" + start_hour + ":" + start_min + " - " + end_hour + ":" + end_min);
        });
    }

    // slide_filter_init();
    // slide time filter

    function nouislidefilter_init() {
        var rangeSlider1 = document.getElementById("slide_filter1");
        var rangeSlider2 = document.getElementById("slide_filter2");

        var lang = $("input[name='lang']").val();
        var dir;
        if (lang == "fa") {
            dir = "rtl";
        } else {
            dir = "ltr";
        }

        if (rangeSlider1) {
            noUiSlider.create(rangeSlider1, {
                start: [parseInt($('#slide_filter1').attr('data-start')), Math.min(parseInt($('#slide_filter1').attr('data-end')), parseInt($("input[name='max_waiting']").val()))],
                direction: dir,
                connect: true,
                step: 30,
                range: {
                    'min': 0, 'max': parseInt($("input[name='max_waiting']").val())
                }
            });
            rangeSlider1.noUiSlider.on('update', function (values, handle) {
                var target = "#" + $("#slide_filter1").attr('data-target');
                var start_hour = parseInt(values[0] / 60);
                var start_min = parseInt(values[0] % 60);
                var end_hour = parseInt(values[1] / 60);
                var end_min = parseInt(values[1] % 60);
                if (start_hour < 10) start_hour = "0" + start_hour;
                if (start_min < 10) start_min = "0" + start_min;
                if (end_hour < 10) end_hour = "0" + end_hour;
                if (end_min < 10) end_min = "0" + end_min;
                $(target).val("" + start_hour + ":" + start_min + " - " + end_hour + ":" + end_min);
            });

            rangeSlider1.noUiSlider.on('set', function (values, handle) {
                var start_min = values[0];
                var end_min = values[1];
                var is_none_stop = $("input[name='is_none_stop']").val();
                var x = $(".my_pagination").attr('data-count');
                $("#slide_filter1").attr('data-start', start_min);
                $("#slide_filter1").attr('data-end', end_min);
                var length = x * 25;
                var start = 0;
                filtering(start, length, 1, is_none_stop);
                $('html,body').animate({
                    scrollTop: $(".flight_post_body").offset().top
                }, 1000);
            });
        }
        if (rangeSlider2) {
            noUiSlider.create(rangeSlider2, {
                start: [0, parseInt($("input[name='max_waiting']").val())], connect: true, step: 30, range: {
                    'min': 0, 'max': parseInt($("input[name='max_waiting']").val())
                }
            });
            rangeSlider2.noUiSlider.on('update', function (values, handle) {
                var target = "#" + $("#slide_filter2").attr('data-target');
                var start_hour = parseInt(values[0] / 60);
                var start_min = parseInt(values[0] % 60);
                var end_hour = parseInt(values[1] / 60);
                var end_min = parseInt(values[1] % 60);
                if (start_hour < 10) start_hour = "0" + start_hour;
                if (start_min < 10) start_min = "0" + start_min;
                if (end_hour < 10) end_hour = "0" + end_hour;
                if (end_min < 10) end_min = "0" + end_min;
                $(target).val("" + start_hour + ":" + start_min + " - " + end_hour + ":" + end_min);
            });

            rangeSlider2.noUiSlider.on('set', function (values, handle) {
                var start_min = values[0];
                var end_min = values[1];
                var is_none_stop = $("input[name='is_none_stop']").val();
                var x = $(".my_pagination").attr('data-count');
                $("#slide_filter2").attr('data-start', start_min);
                $("#slide_filter2").attr('data-end', end_min);
                var length = x * 25;
                var start = 0;
                filtering(start, length, 1, is_none_stop);
                $('html,body').animate({
                    scrollTop: $(".flight_post_body").offset().top
                }, 1000);
            });
        }

        $(".slide_filter").each(function () {


            var target = "#" + $(this).attr('data-target');
            var start_hour = parseInt($('#slide_filter1').attr('data-start')) / 60;  //parseInt($(this).slider("values", 0) / 60);
            var start_min = 0;  //parseInt($(this).slider("values", 0) % 60);
            var end_hour = Math.min(parseInt($('#slide_filter1').attr('data-end')), parseInt($("input[name='max_waiting']").val())) / 60;    //parseInt($(this).slider("values", 1) / 60);
            var end_min = 0;   //parseInt($(this).slider("values", 1) % 60);
            if (start_hour < 10) start_hour = "0" + start_hour;
            if (start_min < 10) start_min = "0" + start_min;
            if (end_hour < 10) end_hour = "0" + end_hour;
            if (end_min < 10) end_min = "0" + end_min;
            $(target).val("" + start_hour + ":" + start_min + " - " + end_hour + ":" + end_min);
        });


    }

    function nouislidefilter_homepage_init() {
        var rangeSlider1 = document.getElementById("slide_filter_home");
        var lang = $("input[name='lang']").val();
        var dir;
        if (lang == "fa") {
            dir = "rtl";
        } else {
            dir = "ltr";
        }

        if (rangeSlider1) {
            noUiSlider.create(rangeSlider1, {
                start: [parseInt($("input[name='wait0']").val()), parseInt($("input[name='wait1']").val())],
                direction: dir,
                connect: true,
                step: 30,
                range: {
                    'min': 0, 'max': parseInt($("input[name='max_waiting']").val())
                }
            });
            rangeSlider1.noUiSlider.on('update', function (values, handle) {
                var target = "#" + $("#slide_filter_home").attr('data-target');
                var start_hour = parseInt(values[0] / 60);
                var start_min = parseInt(values[0] % 60);
                var end_hour = parseInt(values[1] / 60);
                var end_min = parseInt(values[1] % 60);
                if (start_hour < 10) start_hour = "0" + start_hour;
                if (start_min < 10) start_min = "0" + start_min;
                if (end_hour < 10) end_hour = "0" + end_hour;
                if (end_min < 10) end_min = "0" + end_min;
                $(target).val("" + start_hour + ":" + start_min + " - " + end_hour + ":" + end_min);
            });
            rangeSlider1.noUiSlider.on('set', function (values, handle) {
                var start_min = values[0];
                var end_min = values[1];

                $('input[name="wait0"]').val(start_min);
                $('input[name="wait1"]').val(end_min);
            });

        }

        $(".slide_filter").each(function () {


            var target = "#" + $(this).attr('data-target');
            var start_hour = parseInt($("input[name='wait0']").val()) / 60;  //parseInt($(this).slider("values", 0) / 60);
            var start_min = 0;  //parseInt($(this).slider("values", 0) % 60);
            var end_hour = parseInt($("input[name='wait1']").val()) / 60;    //parseInt($(this).slider("values", 1) / 60);
            var end_min = 0;   //parseInt($(this).slider("values", 1) % 60);
            if (start_hour < 10) start_hour = "0" + start_hour;
            if (start_min < 10) start_min = "0" + start_min;
            if (end_hour < 10) end_hour = "0" + end_hour;
            if (end_min < 10) end_min = "0" + end_min;
            $(target).val("" + start_hour + ":" + start_min + " - " + end_hour + ":" + end_min);
        });

    }


    // if ($('input[name="page"]').val() == "flight") {
    //     nouislidefilter_init();
    // } else if ($('input[name="page"]').val() == "home") {
    //     nouislidefilter_homepage_init();
    // }


    var is_none_stop = $("input[name='is_none_stop']").val();

    // filtering(0, 25, 2, is_none_stop);

    function set_filter_array() {

        var filter_array = [];
        var filter_array2 = [];
        var i = 0;
        var j = 0;

        // generate an array for check box filter
        $('.filter_input:not(:checked)').each(function () {

            var name = this.name;
            var value = $(this).val();
            var return_val = $(this).attr('data-return');

            filter_array[i] = [name, "!=", value];
            filter_array2[j] = [name, "!=", value];

            if (name == "ValidatingAirlineCode") {
                i++;
                filter_array[i] = ["depart_first_airline", "!=", value];
                i++;
                filter_array[i] = ["return_first_airline", "!=", value];
            }

            i++;
            j++;
            if (return_val) {
                name = "return_" + name;
                filter_array[i] = [name, "!=", value];
                filter_array2[j] = [name, "!=", value];

                i++;
                j++;
            }
        });


        // generate an array for slide filter
        $(".slide_filter").each(function () {

            var target = $(this).attr('data-target');
            var start_min = $(this).attr('data-start');
            var end_min = $(this).attr('data-end');
            var return_val = $(this).attr('data-return');

            filter_array[i] = [target, ">=", start_min];
            filter_array2[j] = [target, ">=", start_min];
            i++;
            j++;
            filter_array[i] = [target, "<=", end_min];
            filter_array2[j] = [target, "<=", end_min];
            i++;
            j++;

            if (return_val) {
                target = "return_" + target;
                filter_array[i] = [target, ">=", start_min];
                filter_array2[j] = [target, ">=", start_min];
                i++;
                j++;
                filter_array[i] = [target, "<=", end_min];
                filter_array2[j] = [target, "<=", end_min];
                i++;
                j++;
            }
        });

        return [filter_array, filter_array2];
    }

    // function for filter and pagination
    function filtering(start, length, parent, is_none_stop, pagin_id = 0) {

        var lang = $("input[name='lang']").val();
        var search_id = $("input[name='sch_id']").val();
        var order = $(".active_order").attr('data-target');


        $('#ajax_flight_main_container').html("");


        fi = set_filter_array();
        filter_array = fi[0];
        filter_array2 = fi[1];

        // ajax
        $.ajax({
            url: "/filter", type: "POST", cache: true, data: {
                search_id: search_id,
                lang: lang,
                order: order,
                start: start,
                length: length,
                filter: filter_array,
                filter2: filter_array2,
                is_none_stop: is_none_stop,
                render: pagin_id
            }, dataType: 'html', beforeSend: function () {
                ajax_show(1);
            }, success: function (data) {

                pagin_container = '#my_pagination' + pagin_id;
                $(pagin_container).remove();

                post_content = '#flight_main_container' + pagin_id;
                if (parent == 0) {
                    var old_data = $(post_content).html();
                    $(post_content).html(old_data + JSON.parse(data).html);
                } else if (parent == 1) {
                    $(".flight_main_container").remove();
                    // $(".ajax_flight_loader_container").remove();
                    $(post_content).html(JSON.parse(data).html);

                } else if (parent == 2) {
                    $(".flight_main_container").remove();
                    $(post_content).html(JSON.parse(data).html);

                }
                pagination_count_span = pagin_container + " .pagination_count_span";

                pagination_counter = pagin_container + " .my_pagination";

                x = parseInt((start + length) / 25);
                $(pagination_counter).attr('data-count', x);

                flight_container = post_content + " .flight_container";

                var count = $(flight_container).length;
                $(pagination_count_span).html(count);

                if ($(flight_container).length == JSON.parse(data).count) {
                    $(pagin_container).hide();
                } else {
                    $(pagin_container).show();

                }
                pagination_total_span = pagin_container + " .pagination_total_span";
                $(pagination_total_span).html(JSON.parse(data).count);

                ajax_show(0);

            }, error: function () {
                ajax_show(0);
            }
        });

        // end ajax
    }

    // function for filter and pagination


    jQuery(document).on('click', '#baggage_rules', function (e) {

        var flight_token = $(this).attr('data-token');
        var lang = $("input[name='lang']").val();

        // ajax
        $.ajax({
            url: "/bagRules",
            type: "POST",
            cache: true,
            data: {flight_token: flight_token, lang: lang},
            dataType: 'html',
            beforeSend: function () {
                ajax_show(1);

            },
            success: function (data) {
                $('#rules_modal_container').html(JSON.parse(data));
                $('#rules_modal').modal('show');
                ajax_show(0);

            },
            error: function () {
                ajax_show(0);

            }
        });

        // end ajax


        $('#mymodal').modal('show');

    });


    jQuery(document).on('change', '#contact_person', function () {

        var value = (this.value);

        if (value == 0) {

            $('#arranger_name').slideDown();

        } else {
            $('#arranger_name').slideUp();

        }

    });


    $('#passengers_submit').click(function (e) {

        e.preventDefault();


        var name;
        var value;
        var req = {};
        var input = $('#passenger_form input:enabled , #passenger_form select');
        // var count=$('input[name=count]').val();

        input.each(function () {

            name = this.name;
            value = $(this).val();

            req[name] = value;

        });

        // req['count']=count;


        $.ajax({
            url: "/passengers/check", type: "POST", data: {
                request: req
            }, beforeSend: function () {
                ajax_show(1);

            }, success: function (data) {

                $('input , select').removeClass('error');
                $('span.error_alert').html("").hide();

                if (data.errors) {
                    jQuery.each(data.errors, function (key, value) {

                        var text = 'input[name=' + key + '] , select[name=' + key + ']';

                        $(text).siblings('span.error_alert').html(value).show();
                        $(text).addClass('error');

                    });

                    var top = $('#passenger_form').offset().top - 40;
                    $('html, body').animate({
                        scrollTop: top + 'px'
                    }, 300);

                } else {

                    window.location.href = data.url;

                }

                ajax_show(0);

            }, error: function () {
                ajax_show(0);
            }
        });

    });

    $('.login_form_submit').click(function (e) {
        e.preventDefault();

        var name;
        var value;
        var req = {};
        var input = $('#login_form input');

        input.each(function () {

            name = this.name;
            value = $(this).val();

            req[name] = value;

        });

        $.ajax({
            url: "/profile/log", type: "POST", data: {
                request: req
            }, beforeSend: function () {
                ajax_show(1);

            }, success: function (data) {

                $('.error_alert').html("").hide();

                if (data.errors) {
                    jQuery.each(data.errors, function (key, value) {

                        var text = 'input[name=' + key + ']';

                        $(text).siblings('span.error_alert').html(value).show();

                    });


                } else if (data.message) {

                    $("#not_confirmed").html(data.message).show();

                } else if (data.loginError) {

                    $("#login_error").html(data.loginError).show();

                } else if (data.success) {
                    if ($("input[name='route']").val() == 'passengers') {

                        location.reload();
                    } else {
                        document.location.href = "/";

                    }
                }

                ajax_show(0);

            }, error: function () {
                ajax_show(0);
            }
        });


    });

    $('.passenger_form_element').click(function () {

        $(this).removeClass('error');
        $(this).siblings('span.error_alert').html("").hide();

    });


    jQuery(document).on('change', '#select_country', function () {

        var value = (this.value);
        var target = $(this).attr('data-target');

        var dom = $("input[name='domestic']").val();

        var div = "#national_id_div" + target;
        var div_input = "#national_id_div" + target + " input";
        var div_pass = "#passport_number_div" + target;
        var div_pass_input = "#passport_number_div" + target + " input";

        var div_exp = "#passport_exp_div" + target;
        var div_exp_input = "#passport_exp_div" + target + " input";

        var div_issue = "#passport_issue_div" + target;
        var div_issue_input = "#passport_issue_div" + target + " input";

        if (value == "IR" && dom == 1) {

            $(div_pass).hide().slideUp();
            $(div_pass_input).attr('disabled', 'disabled');

            $(div_exp).hide().slideUp();
            $(div_exp_input).attr('disabled', 'disabled');

            $(div_issue).hide().slideUp();
            $(div_issue_input).attr('disabled', 'disabled');

            $(div).slideDown();
            $(div_input).removeAttr('disabled');
        } else {
            $(div).hide().slideUp();
            $(div_input).attr('disabled', 'disabled');
            $(div_pass).slideDown();
            $(div_pass_input).removeAttr('disabled');

            $(div_exp).slideDown();
            $(div_exp_input).removeAttr('disabled');

            $(div_issue).slideDown();
            $(div_issue_input).removeAttr('disabled');

        }

    });


    $("#refresh_search").click(function (e) {


        var return_date = $(this).attr('data-return_date');
        var return_date_day = $(this).attr('data-return_date_day');
        if (return_date == "") {
            return_date = "-";
            return_date_day = ""
        }
        search_loader_show($(this).attr('data-origin'), $(this).attr('data-destination'), $(this).attr('data-origin_name'), $(this).attr('data-destination_name'), $(this).attr('data-adl'), $(this).attr('data-chl'), $(this).attr('data-inf'), $(this).attr('data-depart_date'), return_date, $(this).attr('data-depart_date_day'), return_date_day);
    });


    $('#use_user_info').change(function () {

        if ($(this).prop('checked')) {
            $('#pass1 .passengers_body input , #pass1 .passengers_body select').each(function () {

                data = $(this).attr('data-user');

                $(this).val(data);

            });
        } else {
            $('#pass1 .passengers_body input , #pass1 .passengers_body select').val("");
        }

    });

    function search_loader_show(origin, destination, origin_name, destination_name, adl, chl, inf, depart_date, return_date, depart_date_day, return_date_day) {

        var depart_word = $("input[name='trs_depart_date']").val();
        var return_word = $("input[name='trs_return_date']").val();
        var adult_word = $("input[name='trs_adult']").val();
        var child_word = $("input[name='trs_child']").val();
        var infant_word = $("input[name='trs_infant']").val();
        $('.airport .from_airport').html(origin);
        $('.airport .to_airport').html(destination);
        $('.airport .from_airport_name').html(origin_name);
        $('.airport .to_airport_name').html(destination_name);
        $('.search_date .depart_date').html(depart_word + " : " + turn_day_of_week(depart_date_day) + " " + depart_date);
        if (return_date != '-') $('.search_date .return_date').html(return_word + " : " + turn_day_of_week(return_date_day) + " " + return_date);

        if (adl) $('.passenger_number .passenger1').html(adult_word + " : " + adl);
        if (chl) $('.passenger_number .passenger2').html(child_word + " : " + chl);
        if (inf) $('.passenger_number .passenger3').html(infant_word + " : " + inf);


        $('#search_loader').modal('show');
    }

    function turn_day_of_week(code) {

        code = parseInt(code);
        switch (code) {
            case 0 :
                day = $("input[name='trs_sunday_short']").val();
                break;
            case 1 :
                day = $("input[name='trs_monday_short']").val();
                break;
            case 2 :
                day = $("input[name='trs_Tuesday_short']").val();
                break;
            case 3 :
                day = $("input[name='trs_Wednesday_short']").val();
                break;
            case 4 :
                day = $("input[name='trs_Thursday_short']").val();
                break;
            case 5 :
                day = $("input[name='trs_Friday_short']").val();
                break;
            case 6 :
                day = $("input[name='trs_saturday_short']").val();
                break;
            default :
                day = "";
                break;
        }

        return day;
    }

    $("#create_payment_error_modal").modal('show');
    $(".passenger_login_modal").modal('show');


    $('.tablinks').click(function () {

        var target = $(this).attr('data-target');

        $('.tablinks').removeClass('active');

        $(this).addClass('active');

        $('.tabcontent').hide();

        $('#' + target).show();


    });

    jQuery(document).on('click', '.deal_button', function () {
        ajax_show(1);
    });


    $('#cip_passengers_submit').click(function (e) {

        e.preventDefault();


        var name;
        var value;
        var req = {};
        var input = $('#cip_passenger_form input[type!=checkbox]:enabled , #cip_passenger_form input[type=checkbox]:checked:enabled , #cip_passenger_form select:enabled');
        // var count=$('input[name=count]').val();

        input.each(function () {

            name = this.name;
            value = $(this).val();


            req[name] = value;

        });

        // req['count']=count;


        $.ajax({
            url: "/CipPassengers/check", type: "POST", data: {
                request: req
            }, beforeSend: function () {
                ajax_show(1);

            }, success: function (data) {

                $('input , select').removeClass('error');
                $('span.error_alert').html("").hide();

                var i = 0;
                var scroll_text;
                if (data.errors) {
                    jQuery.each(data.errors, function (key, value) {

                        var text = 'input[name=' + key + '] , select[name=' + key + ']';

                        $(text).siblings('span.error_alert').html(value).show();
                        $(text).addClass('error');

                        if (i == 0) {
                            scroll_text = text;
                        }
                        i = 1;
                    });

                    var top = $(scroll_text).offset().top - 100;
                    $('html, body').animate({
                        scrollTop: top + 'px'
                    }, 300);

                } else {

                    window.location.href = data.url;

                }

                ajax_show(0);

            }, error: function () {
                ajax_show(0);
            }
        });

    });


    function ajax_show(act) {

        // if (act == 1) $('.ajax_loader').show(); else $('.ajax_loader').hide();

    }


    jQuery(document).on('click', '.filter_drop_down_link', function () {

        var widget = $(this).siblings('.widget_content');
        var icon = $(this).children('.filter_drop_down');
        if (widget.css("display") == "none") {
            widget.slideDown("slow");
            icon.html('▼')
        } else {
            widget.slideUp("slow");
            icon.html('▲')
        }

    });

    $('.cip_search').focus(function () {

        $('.search_result_cip').show();

    });


    jQuery(document).on('change', '.cip_dir_input', function () {

        val = $(this).val();

        flying_from = $("input[name='fly_from']").val();
        flying_to = $("input[name='fly_to']").val();

        if (val == 2) {

            $('.cip_airport').removeClass('cip_airport_destination').addClass('cip_airport_origin');
            $('.cip_search').attr('placeholder', flying_from);
            // $('.cip_date_label1').show();
            // $('.cip_date_label2').hide();

        } else {
            $('.cip_airport').removeClass('cip_airport_origin').addClass('cip_airport_destination');
            $('.cip_search').attr('placeholder', flying_to);
            // $('.cip_date_label1').hide();
            // $('.cip_date_label2').show();
        }

    });

    jQuery(document).on('change', '#country_dial_code', function () {

        var code = $(this).val();

        $('#dial_code_label').html(code);

    });

    $('#cip_count_button').click(function () {

        $('.cip_count_container').show();

    });


    $(".airline_search").keyup(function () {

        $(this).attr("data-validation", "0");

        var data = $(this).val();
        var sec = $(this).data("sec");
        var l = data.length;
        var lang = $("input[name='lang']").val();
        var search_result = ".search_result" + sec;

        if (l > 1) {
            // ajax
            $.ajax({
                url: "/AutoCompleteAirline",
                type: "POST",
                data: {data: data, sec: sec, lang: lang},
                beforeSend: function () {
                },
                success: function (data) {

                    $(search_result).html(data);

                },
                error: function () {

                }
            });

            // end ajax
        } else {
            $(search_result).html("");

        }
    }).click(function () {

        $(this).select();

    });


    $(".cip_detail_link").change(function () {

        var item = $(this).attr('data-target');
        item = "." + item;

        var values = $(item).find(':input');


        if ($(this).prop('checked') == true) {

            $(item).slideDown("slow");
            values.removeAttr('disabled');

        } else {
            $(item).slideUp("slow");
            values.attr('disabled', 'disabled');
        }

    });


    jQuery(document).on('change', '.transfer_number_select', function () {

        var target = parseInt($(this).attr('data-target'));
        var lang = $("input[name='lang']").val();
        var dir = $("input[name='cip_dir']").val();


        var n = $(this).val();

        var req = {};
        req["number"] = n;
        req["target"] = target;
        req["dir"] = dir;

        var div = ".transfer_form_data_container" + target;

        $.ajax({
            url: "/transfer_data", type: "POST", data: {
                request: req, lang: lang
            }, beforeSend: function () {


            }, success: function (data) {

                $(div).html(data);


            }, error: function () {

            }
        });


    });


    $(".passenger_header_dropdown").click(function () {


        var up = $(this).find(".cip_dropdown_sign").children('.up');
        var down = $(this).find(".cip_dropdown_sign").children('.down');

        if ($(up).hasClass('display_none')) {

            $(up).removeClass('display_none');
            $(down).addClass('display_none');
        } else {
            $(up).addClass('display_none');
            $(down).removeClass('display_none');
        }

    });


    $('.add_cip_person').click(function () {

        var div = $('.host_person_container.display_none').first();

        div.removeClass('display_none');

        div.find(':input').removeAttr('disabled');


    });

    $('.remove_cip_person').click(function () {

        var div = $('.host_person_container').not('.display_none').last();

        div.addClass('display_none');

        div.find(':input').attr('disabled', 'disabled');


    });


    ajax_loader_f = function (render, search_id, direction = 1) {

        var lang = $("input[name='lang']").val();

        var json_filter = $("#json_filter").val();

        var l_render = render.length;
        $('#render_number_counter').val(l_render);
        let ajax_url;
        if (direction != 4) {
            ajax_url = "/ajax_flight";
        } else {
            ajax_url = "/ajax_flight_multi";
        }

        render.forEach(function (item) {

            $.ajax({
                url: ajax_url, type: "POST", cache: true, data: {
                    render: item, search_id: search_id, lang: lang, filter: json_filter
                }, dataType: 'html', beforeSend: function () {
                }, success: function (data) {

                    x = '#flight_main_container' + item;

                    var new_render_number_c = parseInt($('#render_number_counter').val()) - 1;
                    $('#render_number_counter').val(new_render_number_c);

                    if (!new_render_number_c) {
                        $("#ajax_flight_loader").hide();
                        $(".ajax_flight_header_before").hide();
                    }
                    $(".ajax_flight_header_after").show();
                    $(x).html(JSON.parse(data).html);
                    $('#side_filter_main_container .theiaStickySidebar #modal-body-div .side_filter_content').html(JSON.parse(data).side_filter);
                    $('#airline_list_main_container').html(JSON.parse(data).airline_list);
                    nouislidefilter_init();
                    var is_none_stop = $("input[name='is_none_stop']").val();
                    // filtering(0, 25, 1, is_none_stop);

                }, error: function () {

                }
            });


        });


    }

    other_days_f = function (render, search_id) {


        $.ajax({
            url: "/ajax_flight_other_days",
            type: "POST",
            cache: true,
            data: {render: render, search_id: search_id},
            dataType: 'html',
            beforeSend: function () {
            },
            success: function (data) {

                $("#ajax_other_day").hide();
                $('#other_days_div').html(JSON.parse(data).html);

            },
            error: function () {

            }
        });

    }
//    end my code

    jQuery(document).on('mouseover', '.aircraft_name i', function () {
        $(this).siblings('.aircraft_description').addClass('display_block_important');
    });
    jQuery(document).on('mouseleave', '.aircraft_name i', function () {
        $(this).siblings('.aircraft_description').removeClass('display_block_important');
    });


    $(".other_days").click(function (e) {
        ajax_show(1);
        $(".search_bar_data").attr('data-target', "");
    });

    $(window).bind("pageshow", function (event) {
        ajax_show(0);
    });

    $("#btn-back-to-top").click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 300);
    });

    $("#mobile_filter_button").click(function () {
        $("#modal-div").addClass("modal").addClass("show").addClass("d-block");
        $("#modal-dialog-div").addClass("modal-dialog");
        $("#modal-content-div").addClass("modal-content");
        $("#modal-body-div").addClass("modal-body");
        $("#side_filter_main_container").removeClass('d-none');
        $("body").addClass('modal-open');
        $("#modal-backdrop-div").addClass('modal-backdrop').addClass('fade').addClass('show');
    });

    $(".filter_modal_close").click(function () {
        $("#modal-div").removeClass("modal").removeClass("show").removeClass('d-block');
        $("#modal-dialog-div").removeClass("modal-dialog");
        $("#modal-content-div").removeClass("modal-content");
        $("#modal-body-div").removeClass("modal-body");
        $("#side_filter_main_container").addClass("d-none");
        $("body").removeClass('modal-open');
        $("#modal-backdrop-div").removeClass('modal-backdrop').removeClass('fade').removeClass('show');

    });

    $(".add_multi").click(function () {
        let count = $(this).data('count');
        if (count == 2) {
            $(".addition_multi3").show();
            $(this).data('count', 3);
        }

        if (count == 3) {
            $(".addition_multi4").show();
            $(this).data('count', 4);
            $(this).hide();
        }

    });
    $(".remove_multi").click(function () {
        let mul = $(this).data('mul');

        let div = ".addition_multi" + mul;

        $(div).hide();

        let add_multi = $(".add_multi");
        let count = add_multi.data('count');
        add_multi.show().data('count', count - 1);

    });

});

function select_airport(sec, x, country) {

    var search_result = ".search_result" + sec;
    var airport_search = ".airport_search" + sec;

    var data1 = $(x).find(".airport_name_container .airport_name").html();
    var data2 = $(x).find(".airport_code_container .airport_code").html();
    var data = data1 + "-(" + data2 + ")";
    $(search_result).html("");
    $(airport_search).val(data).attr("data-validation", "1").attr("data-country", country).attr('data-code', data2);

}

function select_airport_cip(x, country) {

    var search_result = ".search_result_cip";
    var airport_search = ".cip_search";

    var data1 = $(x).find(".airport_name_container .airport_name").html();
    var data2 = $(x).find(".airport_code_container .airport_code").html();
    var data = data1 + "-(" + data2 + ")";
    $(search_result).hide();
    $(airport_search).val(data).attr("data-validation", "1").attr("data-country", country).attr('data-code', data2);

}

function select_airline(sec, x) {

    var search_result = ".search_result" + sec;
    var airline_search = ".airline_search";

    var data1 = $(x).find(".airport_name_container .airport_name").html();
    var data2 = $(x).find(".airport_code_container .airport_code").html();
    var data = data1 + "-(" + data2 + ")";
    $(search_result).html("");
    $(airline_search).val(data).attr("data-validation", "1").attr("data-country", country).attr('data-code', data2);

}


function add_cip_count() {

    var values = $(".cip_search_form").find(':input');


    var passenger = $("input[name='passenger_counting_js']").val();
    var passengers = $("input[name='passengers_counting_js']").val();

    var value = {};


    values.each(function () {
        value[this.name] = $(this).val();

    });

    var adl = parseInt(value["adl"]);
    var chl = parseInt(value["chl"]);
    var inf = parseInt(value["inf"]);

    var counter;

    var sum = adl + chl + inf;

    if (sum == 1) {
        counter = passenger;
    } else {
        counter = passengers;
    }

    $('#cip_count_button').val(sum + " " + counter);

}


jQuery(document).mouseup(function (e) {
    var container = $(".search_result");
    var container2 = $(".airport_search");
    var container3 = $(".cip_search");
    var container4 = $(".search_result_cip");

    var cip_count = $('.cip_count_container');

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0 && !container2.is(e.target) && container2.has(e.target).length === 0) {
        container.html("");
    }

    if (!container3.is(e.target) && container3.has(e.target).length === 0 && !container4.is(e.target) && container4.has(e.target).length === 0) {
        container4.hide();
    }


    if (!cip_count.is(e.target) && cip_count.has(e.target).length === 0) {
        cip_count.hide();
        add_cip_count();
    }


});
