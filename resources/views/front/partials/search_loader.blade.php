<div class="modal fade" id="search_loader" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg search_loader_modal">
        <div class="modal-content" style="background: url('images/{{$setting->search_loader_img}}') no-repeat center;">

            <div class="search_modal_container">

                <div class="logo text-{{$setting->logo_position_search_loader ? $setting->logo_position_search_loader : "center"}}">

                    <img src="images/{{$setting->logo}}">

                </div>

                <div class="search_loader_text">

                    @lang('trs.search_best_flight')

                </div>

                <div class="row">

                    <div class="col-4 airport">
                        <span class="from_airport"></span>
                        <span class="from_airport_name"></span>

                    </div>


                    <div class="col-4">
                        <span class="arrow arrow1"> > </span>
                        <span class="arrow arrow2"> > </span>
                        <span class="arrow arrow3"> > </span>
                    </div>


                    <div class="col-4 airport">
                        <span class="to_airport"></span>
                        <span class="to_airport_name"></span>
                    </div>

                </div>

                <div class="search_date">
                    <span class="depart_date"></span>
                    <span class="return_date"></span>

                </div>

                <div class="passenger_number">
                    <span class="passenger1"></span>
                    <span class="passenger2"></span>
                    <span class="passenger3"></span>

                </div>

            </div>

        </div>
    </div>
</div>


<script>


</script>