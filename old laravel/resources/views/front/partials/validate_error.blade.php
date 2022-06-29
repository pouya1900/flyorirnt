<div class="modal fade" id="validate_error_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="validate_modal_container">
                <div class="modal-body">

                    <div class="title">
                        <span>@lang('trs.refresh_search_message')</span>
                    </div>

                    <div class="description">
                        @lang('trs.validate_error')                    </div>
                </div>
                <div class="modal_footer">
                    <a href="{{$research_data["link"]!="" ? $research_data["link"] : route('home'). ($lang!="de"? "?lang=".$lang : "")}}"
                       id="refresh_search" class="refresh_btn" data-origin="{{$research_data["origin"]}}"
                       data-origin_name="{{$research_data["origin_name"]}}"
                       data-destination="{{$research_data["destination"]}}"
                       data-destination_name="{{$research_data["destination_name"]}}"
                       data-adl="{{$research_data["adl"]}}" data-chl="{{$research_data["chl"]}}"
                       data-inf="{{$research_data["inf"]}}" data-depart_date="{{$research_data["depart_date"]}}"
                       data-depart_date_day="{{date('w',strtotime($research_data["depart_date"]))}}"
                       data-return_date="{{$research_data["return_date"]}}"
                       data-return_date_day="{{date('w',strtotime($research_data["return_date"]))}}">@lang('trs.refresh_search')</a>
                </div>
            </div>
        </div>
    </div>
</div>