@extends('layouts.front')
@section('style')
    <link rel="stylesheet" href="css/nouislider.min.css">

@endsection
@section('content')
    <input type="hidden" name="sch_id" value="{{$search_data["search_id"]}}">

    @include('front.flight.search_bar')
    <div class="mobile_filter_container d-lg-none">
        <div class="mobile_filter_content">
            <span id="mobile_filter_button"><i
                        class="fas fa-filter"></i> @lang('trs.filter')</span>
        </div>
    </div>
    {{--    <div class="modal fade d-lg-block" id="filter_modal" tabindex="-1" role="dialog" data-backdrop="static"--}}
    {{--         data-keyboard="false" aria-labelledby="filter_modal"--}}
    {{--         aria-hidden="true">--}}
    {{--        <div class="modal-dialog" role="document">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-body">--}}

    {{--                </div>--}}
    {{--                <div class="filter_modal_close_container">--}}
    {{--                    <span class="filter_modal_close" ><i class="fas fa-sort-amount-down"></i> @lang('trs.show_filter_result')</span>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class=" flight_page_container ">
        <div class="row margin-right-0px margin-left-0px">
            <div id="side_filter_main_container"
                 class="col-lg-2 d-lg-block d-none flight_side_bar_modal flight_sidebar_container sticky-sidebar padding-right-5px padding-left-5px">
                <div id="modal-div">
                    <div id="modal-dialog-div">
                        <div id="modal-content-div">
                            <div id="modal-body-div">
                                <div class="side_filter_content">
                                    @include('front.flight.side_filter')
                                </div>
                                <div class="d-lg-none">
                                    <div class="filter_modal_close_container">
                                        <span class="filter_modal_close"><i class="fas fa-sort-amount-down"></i> @lang('trs.show_filter_result')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-12 flight_post_body">
                <div class="flights_container">
                    @if ($other_days_loader)
                        @include('front.flight.ajax_other_day_flight_loader')
                        <div id="other_days_div"></div>
                    @else
                        <div id="airline_list_main_container">
                            @include('front.flight.airline_list')
                        </div>
                    @endif
                    @include('front.flight.reorder_flight')
                    @include('front.partials.flight_header')
                    <div id="flight_main_container0">
                        @include('front.flight.flights_list')
                    </div>
                    @if ($ajax_render)
                        @include('front.flight.ajax_flight_loader')

                        @foreach($ajax_render as $item)
                            <div id="flight_main_container{{$item}}" class="flight_main_container"></div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
        <!--// row -->

    </div>

    {{--rules modal container--}}
    <div id="rules_modal_container"></div>
    @include('front.partials.search_loader')

    <button
            type="button"
            id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <div id="modal-backdrop-div"></div>

@endsection

@section('script')

    <script type="text/javascript">
        var userLanguage1 = "{{$lang=="de" ? "de" : "en"}}";
        var startDate1, endDate1, startInstance1, endInstance1;
        var fillInputs1 = function () {
            startInstance1.$elem.val(startDate1 ? startDate1.locale(startInstance1.config.format).format(startInstance1.config.format) : "");
            endInstance1.$elem.val(endDate1 ? endDate1.locale(endInstance1.config.format).format(endInstance1.config.format) : "");
        };

        $("#daterange1").caleran({

            locale: userLanguage1,

            format: "DD.MM.YYYY",

            startOnMonday: true,

            minDate: moment(),

            showFooter: false,

            // startEmpty: $("#daterange1").val() === "",

            startDate: $("#daterange1").val(),

            endDate: $("#daterange2").val(),

            enableKeyboard: false,

            oninit: function (instance1) {
                startInstance1 = instance1;
                var x = $("#daterange1").data('start');
                instance1.config.startDate = moment(x);

                if (!instance1.config.startEmpty) {

                    instance1.$elem.val(instance1.config.startDate.locale(instance1.config.format).format(instance1.config.format));

                    endDate1 = instance1.config.startDate.clone();
                }
            },

            onbeforeshow: function (instance1) {

                if (startDate1) {

                    startInstance1.config.startDate = startDate1;

                    endInstance1.config.startDate = startDate1;

                }

                if (endDate1) {

                    startInstance1.config.endDate = endDate1.clone();

                    endInstance1.config.endDate = endDate1.clone();

                }

                fillInputs1();

                instance1.updateHeader();

                instance1.reDrawCells();

            },

            onfirstselect: function (instance, start1) {

                startDate1 = start1.clone();

                startInstance1.globals.startSelected = false;

                startInstance1.hideDropdown();

                endInstance1.showDropdown();

                endInstance1.config.minDate = startDate1.clone();

                endInstance1.config.startDate = startDate1.clone();

                endInstance1.config.endDate = null;

                endInstance1.globals.startSelected = true;

                endInstance1.globals.endSelected = false;

                endInstance1.globals.firstValueSelected = true;

                endInstance1.setDisplayDate(start1);

                if (endDate1 && startDate1.isAfter(endDate1)) {

                    endInstance1.globals.endDate = endDate1.clone();

                }

                endInstance1.updateHeader();

                endInstance1.reDrawCells();

                fillInputs1();

            },

            onrangeselect: function (instance1) {

                instance1.globals.delayInputUpdate = true;

                startDate1 = instance1.config.startDate;

                endDate1 = instance1.config.endDate;

                setTimeout(fillInputs1, 20);

                instance1.hideDropdown();

                instance1.globals.delayInputUpdate = false;

            }

        });
        $("#daterange2").caleran({

            locale: userLanguage1,

            format: "DD.MM.YYYY",

            startOnMonday: true,

            minDate: moment(),

            showFooter: false,

            // startEmpty: $("#daterange2").val() === "",

            startDate: $("#daterange1").val(),

            endDate: $("#daterange2").val(),

            enableKeyboard: false,

            autoCloseOnSelect: false,

            oninit: function (instance1) {

                endInstance1 = instance1;
                var x = $("#daterange2").data('end');
                instance1.config.endDate = moment(x);

                if (!instance1.config.startEmpty) {
                    instance1.$elem.val(instance1.config.endDate.locale(instance1.config.format).format(instance1.config.format));

                    endDate1 = instance1.config.endDate.clone();
                }

            }
            ,

            onbeforeshow: function (instance1) {

                if (startDate1) {

                    startInstance1.config.startDate = startDate1;

                    endInstance1.config.startDate = startDate1;

                }

                if (endDate1) {

                    startInstance1.config.endDate = endDate1.clone();

                    endInstance1.config.endDate = endDate1.clone();

                }

                fillInputs1();

                instance1.updateHeader();

                instance1.reDrawCells();

            }
            ,

            onafterselect: function (instance, start1, end1) {

                startDate1 = start1.clone();

                endDate1 = end1.clone();

                endInstance1.hideDropdown();

                startInstance1.config.endDate = endDate1.clone();

                startInstance1.globals.firstValueSelected = true;

                fillInputs1();

                endInstance1.globals.startSelected = true;

                endInstance1.globals.endSelected = false;

            }
            ,

            onrangeselect: function (instance1) {

                instance1.globals.delayInputUpdate = true;

                startDate1 = instance1.config.startDate;

                endDate1 = instance1.config.endDate;

                setTimeout(fillInputs1, 20);

                instance1.hideDropdown();

                instance1.globals.delayInputUpdate = false;

            }

        });

    </script>
    <script type="text/javascript">

        var userLanguage1 = "{{$lang=="de" ? "de" : "en"}}";

        $("#date1").caleran({

            locale: userLanguage1,
            format: "DD.MM.YYYY",
            startOnMonday: true,
            singleDate: true,
            minDate: moment(),
            // startEmpty: $("#date1").val() === "",
            startDate: moment($("#date1").data('start')),
            autoCloseOnSelect: true,
            oninit: function (instance2) {

                single = instance2;
                instance2.config.startDate = moment($("#date1").data('start'));
                if (!instance2.config.startEmpty) {

                    instance2.$elem.val(instance2.config.startDate.locale(instance2.config.format).format(instance2.config.format));
                }
                // endDate1 = instance2.config.startDate.clone();


            },
        });
    </script>


    <script>
        jQuery(document).ready(function ($) {
            @if ($ajax_render)
            ajax_loader_f({{json_encode($ajax_render)}}, {{$search_data["search_id"]}});
            @endif
            @if ($other_days_loader)
            other_days_f({{$search_data["render"]}}, {{$search_data["search_id"]}});
            @endif
        });
    </script>

    <script type="text/javascript" src="js/nouislider.min.js"></script>

@endsection