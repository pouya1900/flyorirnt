{{--pagination--}}
<div id="my_pagination{{isset($search_data["main_vendor"]) ? 0 : $search_data["render"]}}"
     class="{{sizeof($flight)==$count ? "display_none" : ""}}">
    <div class="my_pagination" data-count="1"
         data-target="{{isset($search_data["main_vendor"]) ? 0 : $search_data["render"]}}">

        <span>@lang('trs.load_more')</span>

    </div>

    <div class="pagination_count">
        <span class="pagination_count_span">{{sizeof($flight)}}</span><span> @lang('trs.of') </span><span
                class="pagination_total_span">{{$count}}</span>

    </div>
</div>
{{--// pagination--}}