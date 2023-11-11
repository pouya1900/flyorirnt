@extends('layouts.front')
@section('style')
    <link rel="stylesheet" href="css/nouislider.min.css">

@endsection

@section('content')

    @include('front.home.search_filter')
    @php($slider='front.slider.slider_'.$lang)
    @include($slider)
    @include('front.partials.scroll_airlines')
    @include('front.home.our_services')
    {{--@include('front.home.top_city')--}}
    @include('front.partials.search_loader')
    @endsection



@section('script')



    <script type="text/javascript">
        var userLanguage1 = "{{$lang=="de" ? "de" : "en"}}";
        var startDate1, endDate1, startInstance1, endInstance1;

        var fillInputs1 = function () {
            if (startInstance1 && endInstance1) {
                startInstance1.$elem.val(startDate1 ? startDate1.locale(startInstance1.config.format).format(startInstance1.config.format) : "");
                endInstance1.$elem.val(endDate1 ? endDate1.locale(endInstance1.config.format).format(endInstance1.config.format) : "");
            }
            ;
        }

        $("#daterange1").caleran({

            locale: userLanguage1,

            format:"DD.MM.YYYY",

            startOnMonday: true,

            minDate: moment(),

            showFooter: false,

            startEmpty: $("#daterange1").val() === "",

            startDate: $("#daterange1").val(),

            endDate: $("#daterange2").val(),

            enableKeyboard: false,

            oninit: function (instance1) {

                startInstance1 = instance1;

                if (!instance1.config.startEmpty && instance1.config.startDate) {

                    instance1.$elem.val(instance1.config.startDate.locale(instance1.config.format).format(instance1.config.format));

                    startDate1 = instance1.config.startDate.clone();

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

            onrangeselect: function(instance1){

                instance1.globals.delayInputUpdate = true;

                startDate1 = instance1.config.startDate;

                endDate1 = instance1.config.endDate;

                setTimeout(fillInputs1, 20);

                instance1.hideDropdown();

                instance1.globals.delayInputUpdate = false;

            },
            ondraw:function(){
                fillInputs1();
            }

        });
        $("#daterange2").caleran({

            locale: userLanguage1,

            format:"DD.MM.YYYY",

            startOnMonday: true,

            showFooter: false,

            minDate: moment(),

            startEmpty: $("#daterange2").val() === "",

            startDate: $("#daterange1").val(),

            endDate: $("#daterange2").val(),

            enableKeyboard: false,

            autoCloseOnSelect: false,

            oninit: function (instance1) {

                endInstance1 = instance1;

                if (!instance1.config.startEmpty && instance1.config.endDate) {

                    instance1.$elem.val(instance1.config.endDate.locale(instance1.config.format).format(instance1.config.format));

                    endDate1 = instance1.config.endDate.clone();

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

            onafterselect: function (instance, start1, end1) {

                startDate1 = start1.clone();

                endDate1 = end1.clone();

                endInstance1.hideDropdown();

                startInstance1.config.endDate = endDate1.clone();

                startInstance1.globals.firstValueSelected = true;

                fillInputs1();

                endInstance1.globals.startSelected = true;

                endInstance1.globals.endSelected = false;

            },

            onrangeselect: function(instance1){

                instance1.globals.delayInputUpdate = true;

                startDate1 = instance1.config.startDate;

                endDate1 = instance1.config.endDate;

                setTimeout(fillInputs1, 20);

                instance1.hideDropdown();

                instance1.globals.delayInputUpdate = false;

            },
            ondraw:function(){
                fillInputs1();
            }

        });

    </script>


    <script type="text/javascript">

        var userLanguage1 = "{{$lang=="de" ? "de" : "en"}}";

        $("#date1").caleran({

            locale: userLanguage1,
            format:"DD.MM.YYYY",
            startOnMonday: true,
            singleDate: true,
            minDate: moment(),
            startEmpty: $("#date1").val() === "",
            autoCloseOnSelect: true
        });

        $("#date_multi1").caleran({

            locale: userLanguage1,
            format:"DD.MM.YYYY",
            startOnMonday: true,
            singleDate: true,
            minDate: moment(),
            startEmpty: $("#date_multi1").val() === "",
            autoCloseOnSelect: true
        });

        $("#date_multi2").caleran({

            locale: userLanguage1,
            format:"DD.MM.YYYY",
            startOnMonday: true,
            singleDate: true,
            minDate: moment(),
            startEmpty: $("#date_multi2").val() === "",
            autoCloseOnSelect: true
        });

        $("#date_multi3").caleran({

            locale: userLanguage1,
            format:"DD.MM.YYYY",
            startOnMonday: true,
            singleDate: true,
            minDate: moment(),
            startEmpty: $("#date_multi3").val() === "",
            autoCloseOnSelect: true
        });

        $("#date_multi4").caleran({

            locale: userLanguage1,
            format:"DD.MM.YYYY",
            startOnMonday: true,
            singleDate: true,
            minDate: moment(),
            startEmpty: $("#date_multi4").val() === "",
            autoCloseOnSelect: true
        });
    </script>


    <script type="text/javascript">

        var userLanguage1 = "{{$lang=="de" ? "de" : "en"}}";

        $("#cip_date").caleran({

            locale: userLanguage1,
            format:"DD.MM.YYYY",
            startOnMonday: true,
            singleDate: true,
            minDate: moment(),
            startEmpty: $("#cip_date").val() === "",
            autoCloseOnSelect: true
        });
    </script>
    {{--DATE picker for another date--}}

    {{--<script type="text/javascript">--}}
        {{--var userLanguage = "{{$lang=="de" ? "de" : "en"}}";--}}
        {{--var startDate, endDate, startInstance, endInstance;--}}
        {{--var fillInputs = function () {--}}
            {{--startInstance.$elem.val(startDate ? startDate.locale(startInstance.config.format).format(startInstance.config.format) : "");--}}
            {{--endInstance.$elem.val(endDate ? endDate.locale(endInstance.config.format).format(endInstance.config.format) : "");--}}
        {{--};--}}


        {{--$("#daterange3").caleran({--}}

            {{--locale: userLanguage,--}}

            {{--format:"DD.MM.YYYY",--}}

            {{--startOnMonday: true,--}}

            {{--minDate: moment(),--}}


            {{--showFooter: false,--}}

            {{--startEmpty: $("#daterange3").val() === "",--}}

            {{--startDate: $("#daterange3").val(),--}}

            {{--endDate: $("#daterange4").val(),--}}

            {{--enableKeyboard: false,--}}

            {{--oninit: function (instance) {--}}

                {{--startInstance = instance;--}}

                {{--if (!instance.config.startEmpty && instance.config.startDate) {--}}

                    {{--instance.$elem.val(instance.config.startDate.locale(instance.config.format).format(instance.config.format));--}}

                    {{--startDate = instance.config.startDate.clone();--}}

                {{--}--}}

            {{--},--}}

            {{--onbeforeshow: function (instance) {--}}

                {{--if (startDate) {--}}

                    {{--startInstance.config.startDate = startDate;--}}

                    {{--endInstance.config.startDate = startDate;--}}

                {{--}--}}

                {{--if (endDate) {--}}

                    {{--startInstance.config.endDate = endDate.clone();--}}

                    {{--endInstance.config.endDate = endDate.clone();--}}

                {{--}--}}

                {{--fillInputs();--}}

                {{--instance.updateHeader();--}}

                {{--instance.reDrawCells();--}}

            {{--},--}}

            {{--onfirstselect: function (instance, start) {--}}

                {{--startDate = start.clone();--}}

                {{--startInstance.globals.startSelected = false;--}}

                {{--startInstance.hideDropdown();--}}

                {{--endInstance.showDropdown();--}}

                {{--endInstance.config.minDate = startDate.clone();--}}

                {{--endInstance.config.startDate = startDate.clone();--}}

                {{--endInstance.config.endDate = null;--}}

                {{--endInstance.globals.startSelected = true;--}}

                {{--endInstance.globals.endSelected = false;--}}

                {{--endInstance.globals.firstValueSelected = true;--}}

                {{--endInstance.setDisplayDate(start);--}}

                {{--if (endDate && startDate.isAfter(endDate)) {--}}

                    {{--endInstance.globals.endDate = endDate.clone();--}}

                {{--}--}}

                {{--endInstance.updateHeader();--}}

                {{--endInstance.reDrawCells();--}}

                {{--fillInputs();--}}

            {{--},--}}

            {{--onrangeselect: function(instance){--}}

                {{--instance.globals.delayInputUpdate = true;--}}

                {{--startDate = instance.config.startDate;--}}

                {{--endDate = instance.config.endDate;--}}

                {{--setTimeout(fillInputs, 20);--}}

                {{--instance.hideDropdown();--}}

                {{--instance.globals.delayInputUpdate = false;--}}

            {{--}--}}

        {{--});--}}
        {{--$("#daterange4").caleran({--}}

            {{--locale: userLanguage,--}}

            {{--format:"DD.MM.YYYY",--}}

            {{--startOnMonday: true,--}}

            {{--minDate: moment(),--}}


            {{--showFooter: false,--}}

            {{--startEmpty: $("#daterange4").val() === "",--}}

            {{--startDate: $("#daterange3").val(),--}}

            {{--endDate: $("#daterange4").val(),--}}

            {{--enableKeyboard: false,--}}

            {{--autoCloseOnSelect: false,--}}

            {{--oninit: function (instance) {--}}

                {{--endInstance = instance;--}}

                {{--if (!instance.config.startEmpty && instance.config.endDate) {--}}

                    {{--instance.$elem.val(instance.config.endDate.locale(instance.config.format).format(instance.config.format));--}}

                    {{--endDate = instance.config.endDate.clone();--}}

                {{--}--}}

            {{--},--}}

            {{--onbeforeshow: function (instance) {--}}

                {{--if (startDate) {--}}

                    {{--startInstance.config.startDate = startDate;--}}

                    {{--endInstance.config.startDate = startDate;--}}

                {{--}--}}

                {{--if (endDate) {--}}

                    {{--startInstance.config.endDate = endDate.clone();--}}

                    {{--endInstance.config.endDate = endDate.clone();--}}

                {{--}--}}

                {{--fillInputs();--}}

                {{--instance.updateHeader();--}}

                {{--instance.reDrawCells();--}}

            {{--},--}}

            {{--onafterselect: function (instance, start, end) {--}}

                {{--startDate = start.clone();--}}

                {{--endDate = end.clone();--}}

                {{--endInstance.hideDropdown();--}}

                {{--startInstance.config.endDate = endDate.clone();--}}

                {{--startInstance.globals.firstValueSelected = true;--}}

                {{--fillInputs();--}}

                {{--endInstance.globals.startSelected = true;--}}

                {{--endInstance.globals.endSelected = false;--}}

            {{--},--}}

            {{--onrangeselect: function(instance){--}}

                {{--instance.globals.delayInputUpdate = true;--}}

                {{--startDate = instance.config.startDate;--}}

                {{--endDate = instance.config.endDate;--}}

                {{--setTimeout(fillInputs, 20);--}}

                {{--instance.hideDropdown();--}}

                {{--instance.globals.delayInputUpdate = false;--}}

            {{--}--}}

        {{--});--}}

    {{--</script>--}}


    {{--date picker for another--}}
    {{--<script type="text/javascript">--}}
        {{--$("#date2").caleran({--}}
            {{--locale: userLanguage,--}}
            {{--format:"DD.MM.YYYY",--}}
            {{--singleDate: true,--}}
            {{--minDate: moment(),--}}
            {{--startEmpty: $("#date2").val() === "",--}}
            {{--autoCloseOnSelect: true--}}
        {{--});--}}
    {{--</script>--}}
    <script type="text/javascript" src="js/nouislider.min.js"></script>

@endsection
