$.ajaxSetup({

    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

});



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


function ajax_loader_f(render, search_id) {

    var lang = $("input[name='lang']").val();

    render.forEach(function (item) {

        $.ajax({
            url: "/ajax_flight",
            type: "POST",
            cache: true,
            data: {render: item, search_id: search_id, lang: lang},
            dataType: 'html',
            beforeSend: function () {
            },
            success: function (data) {

                x='#flight_main_container'+item;

                $("#ajax_flight_loader").hide();
                $(x).html(JSON.parse(data).html);
                $('#side_filter_main_container .theiaStickySidebar').html(JSON.parse(data).side_filter);
                slide_filter_init();

            },
            error: function () {

            }
        });


    });


}


function other_days_f(render, search_id) {


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