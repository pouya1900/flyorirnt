{{--order by--}}
<div class="orderby_container">

    <div class="row margin-left-0px margin-right-0px">

        <div class="col first_div reorder_div ">
            <div class="active_order orderby_item" data-target="0">
            <span><i class="fas fa-money-bill"></i>
            @lang("trs.cheapest")
                </span>
            </div>
        </div>
        @if(!empty($flight) && $flight[0]["DirectionInd"]==2)

            <div class="col reorder_div">
                <div class="orderby_item" data-target="1">
            <span><i class="fas fa-clock"></i>
                @lang('trs.depart_and_return'):@lang('trs.Shortest')
                </span>
                </div>
            </div>
        @endif
        <div class="col reorder_div">
            <div class="orderby_item" data-target="2">
            <span><i class="fas fa-clock"></i>
                @lang('trs.depart'): @lang('trs.Shortest')
                </span>
            </div>
        </div>
        @if(!empty($flight) && $flight[0]["DirectionInd"]==2)

            <div class="col last_div reorder_div">
                <div class="orderby_item" data-target="3">
            <span><i class="fas fa-clock"></i>
                @lang('trs.return'): @lang('trs.Shortest')
                </span>
                </div>
            </div>
        @endif
    </div>
</div>
{{--// order by--}}