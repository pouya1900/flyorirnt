<div id="app">
    <single-flight
        :lang="{{json_encode($lang)}}"
        :trs="{{json_encode(trans('trs'))}}"
        :csrf="{{json_encode(csrf_token())}}"
        :air_rules_url="{{json_encode(route('air_rules'))}}"
        :air_bag_url="{{json_encode(route('bagRules'))}}"
        :flight="{{json_encode($flight)}}"
        :search_data="{{json_encode($research_data)}}"
    >

    </single-flight>
</div>
