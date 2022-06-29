<script>

    $(".DOB_date").caleran({

        locale:"{{$lang=="de" ? "de" : "en"}}",
        startEmpty: true,
        startOnMonday: true,
        maxDate: moment(),
        showFooter: false,
        autoCloseOnSelect:true,
        format:"DD.MM.YYYY",

        DOBCalendar: true,





    });
    $(".EXP_date").caleran({

        locale:"{{$lang=="de" ? "de" : "en"}}",
        startEmpty: true,
        startOnMonday: true,
        minDate: moment(),
        showFooter: false,
        autoCloseOnSelect:true,
        format:"DD.MM.YYYY",

        DOBCalendar: true,





    });


</script>