<div id="side_filter_main_container"
     class="col-lg-2 d-lg-block d-none flight_side_bar_modal flight_sidebar_container sticky-sidebar padding-right-5px padding-left-5px">
    <div id="modal-div">
        <div id="modal-dialog-div">
            <div id="modal-content-div">
                <div id="modal-body-div">
                    <div class="side_filter_content">
                        <div class="widget">

                            <div class="widget_content">

                                <div class="widget-sub-title">
                                    <span>{{ this.trs.stops }}</span>

                                </div>

                                <div class="widget_item">

                                    <div class="custom-control custom-checkbox font-weight-600 ">

                                        <input type="checkbox" class="custom-control-input choose_all"
                                               v-model="this.stops"
                                               value="ALL" id="stops_all" checked>

                                        <label class="custom-control-label"
                                               for="stops_all">{{trs.choose_all}} </label>
                                    </div>

                                </div>

                                <div class="widget_item">

                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input filter_input"
                                               id="stop0" v-model="this.stops"
                                               value="0" :disabled="this.search_data.none_stop ? 'disabled' : ''">
                                        <label class="custom-control-label" for="stop0">
                                            {{trs.none_stop}}

                                            <span class="only_filter">{{this.trs.only}}</span>

                                        </label>

                                    </div>

                                </div>

                                <div v-if="!search_data.none_stop" class="widget_item">

                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input filter_input"
                                               id="stop1" v-model="this.stops" value="1">
                                        <label class="custom-control-label" for="stop1"> 1
                                            {{this.trs.stop}}
                                            <span class="only_filter">{{this.trs.only}}</span>
                                        </label>

                                    </div>

                                </div>
                                <div v-if="!search_data.none_stop" class="widget_item">

                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox" class="custom-control-input filter_input"
                                               id="stop2" v-model="this.stops" value="2">

                                        <label class="custom-control-label" for="depart_stop2">
                                            2+ {{trs.stops_in_Counting}}
                                            <span class="only_filter">{{this.trs.only}}</span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!--// stop Search -->


                        <!-- bar search -->
                        <div class="widget">

                            <div class="widget_content">


                                <div class="widget_item">

                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox"
                                               class="custom-control-input filter_input"
                                               id="bar0"
                                               v-model="this.bar_exist" value="0"
                                               :checked="!filter || !filter.bar0 ? 'checked' : ''">
                                        <label class="custom-control-label" for="depart_bar0">
                                            {{this.trs.without_bar}}
                                            <i class="bar_filter_icon"><img
                                                    src="images/icon/suitcase-solid.png"></i>
                                            <span class="only_filter">{{this.trs.only}}</span>

                                        </label>

                                    </div>

                                </div>
                                <div class="widget_item">

                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox"
                                               class="custom-control-input filter_input"
                                               id="bar1" v-model="this.bar_exist" value="1"
                                               :checked="!filter || !filter.bar1 ? 'checked' : ''">
                                        <label class="custom-control-label" for="depart_bar1">
                                            {{this.trs.with_bar}}
                                            <i class="bar_filter_icon fas fa-suitcase"></i>
                                            <span
                                                class="only_filter">{{this.trs.only}}</span>
                                        </label>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <!--// bar Search -->

                        <!-- time search -->
                        <div class="widget">

                            <div class="widget_content">
                                <div class="widget-sub-title">
                                    <span>{{this.trs.depart}}</span>
                                </div>
                                <div class="widget_item">

                                    <div class="custom-control custom-checkbox font-weight-600 ">
                                        <input type="checkbox"
                                               class="custom-control-input choose_all "
                                               id="depart_time_all"
                                               v-model="this.depart_time_range"
                                               value="ALL" checked>
                                        <label class="custom-control-label"
                                               for="depart_time_all">{{trs.choose_all}} </label>
                                    </div>

                                </div>
                                <div class="widget_item">

                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox"
                                               class="custom-control-input filter_input"
                                               id="depart_time0"
                                               v-model="this.depart_time_range" value="0" checked>
                                        <label class="custom-control-label" for="depart_time0">{{this.trs.midnight}}
                                            <span
                                                class="only_filter">{{trs.only}}</span>
                                        </label>
                                    </div>

                                </div>
                                <div class="widget_item">

                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox"
                                               class="custom-control-input filter_input"
                                               id="depart_time1"
                                               v-model="this.depart_time_range" value="1" checked>
                                        <label class="custom-control-label" for="depart_time1">{{this.trs.morning}}
                                            <span
                                                class="only_filter">{{this.trs.only}}</span>
                                        </label>
                                    </div>

                                </div>
                                <div class="widget_item">

                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox"
                                               class="custom-control-input filter_input"
                                               id="depart_time2"
                                               v-model="this.depart_time_range" value="2" checked>
                                        <label class="custom-control-label" for="depart_time2">{{this.trs.afternoon}}
                                            <span
                                                class="only_filter">{{this.trs.only}}</span>
                                        </label>
                                    </div>

                                </div>
                                <div class="widget_item">

                                    <div class="custom-control custom-checkbox ">
                                        <input type="checkbox"
                                               class="custom-control-input filter_input"
                                               id="depart_time3"
                                               v-model="this.depart_time_range" value="3" checked>
                                        <label class="custom-control-label" for="depart_time3">{{this.trs.night}}
                                            <span
                                                class="only_filter">{{this.trs.only}}</span>
                                        </label>
                                    </div>

                                </div>

                                <!--                                return-->
                                <div v-if="this.flights && this.flights[0].DirectionInd==2" class="margin-top-15px">
                                    <div class="widget-sub-title">
                                        <span>{{trs.return}}</span>
                                    </div>
                                    <div class="widget_item">

                                        <div
                                            class="custom-control custom-checkbox font-weight-600 ">
                                            <input type="checkbox"
                                                   class="custom-control-input choose_all"
                                                   id="return_time_all"
                                                   v-model="return_depart_time_range"
                                                   value="ALL" checked>
                                            <label class="custom-control-label"
                                                   for="return_time_all">{{trs.choose_all}}</label>
                                        </div>

                                    </div>
                                    <div class="widget_item">

                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox"
                                                   class="custom-control-input filter_input"
                                                   id="return_time0"
                                                   v-model="return_depart_time_range" value="0"
                                                   checked>
                                            <label class="custom-control-label" for="return_time0">{{trs.midnight}}
                                                <span
                                                    class="only_filter">{{trs.only}}</span>
                                            </label>
                                        </div>

                                    </div>
                                    <div class="widget_item">

                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox"
                                                   class="custom-control-input filter_input"
                                                   id="return_time1"
                                                   v-model="return_depart_time_range" value="1"
                                                   checked>
                                            <label class="custom-control-label" for="return_time1">{{trs.morning}}
                                                <span
                                                    class="only_filter">{{trs.only}}</span>
                                            </label>
                                        </div>

                                    </div>
                                    <div class="widget_item">

                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox"
                                                   class="custom-control-input filter_input"
                                                   id="return_time2"
                                                   v-model="return_depart_time_range" value="2"
                                                   checked>
                                            <label class="custom-control-label" for="return_time2">{{trs.afternoon}}
                                                <span
                                                    class="only_filter">{{trs.only}}</span>
                                            </label>
                                        </div>

                                    </div>
                                    <div class="widget_item">

                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox"
                                                   class="custom-control-input filter_input"
                                                   id="return_time3"
                                                   v-model="return_depart_time_range" value="3"
                                                   checked>
                                            <label class="custom-control-label" for="return_time3">{{trs.night}}
                                                <span
                                                    class="only_filter">{trs.only}}</span>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--// time Search -->


                        <!-- waiting time search -->
                        <!--                        <div v-if="search_data.none_stop" class="widget">-->
                        <!--                            <div class="widget_content">-->
                        <!--                                <div class="widget-sub-title">-->
                        <!--                                    <span>{{trs.waiting_time}}</span>-->
                        <!--                                </div>-->
                        <!--                                <div class="widget_item">-->
                        <!---->
                        <!--                                    <div class="">-->
                        <!--                                        <input type="text" class="slide_input" id="total_waiting"-->
                        <!--                                               name="depart_wait"-->
                        <!--                                               value=""-->
                        <!--                                               readonly>-->
                        <!--                                    </div>-->
                        <!--                                    <div id="slide_filter1" class="slide_filter slider-styled"-->
                        <!--                                         data-start="{{isset($filter) && $filter['wait0'] ? $filter['wait0'] : 0}}"-->
                        <!--                                         data-end="{{isset($filter) && $filter['wait1'] ? $filter['wait1'] : $max}}"-->
                        <!--                                         {{!empty($flight) && $flight[0][-->
                        <!--                                    "DirectionInd"]==2 ? "data-return='1'" : ""}}-->
                        <!--                                    data-target="total_waiting">-->
                        <!--                                </div>-->
                        <!---->
                        <!--                            </div>-->
                        <!--                        </div>-->

                        <!--// waiting time Search -->


                        <!-- airline search -->
                        <div class="widget">

                            <div class="widget_content">
                                <div class="airlines_widget">

                                    <div class="widget_item">

                                        <div class="custom-control custom-checkbox font-weight-600 ">
                                            <input type="checkbox"
                                                   class="custom-control-input choose_all"
                                                   id="airline0"
                                                   v-model="ValidatingAirlineCode"
                                                   value="ALL" checked>
                                            <label class="custom-control-label"
                                                   for="airline0">{{trs.choose_all}}</label>
                                        </div>

                                    </div>

                                    <div v-for="airline in this.airlines" class="widget_item">

                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox"
                                                   class="custom-control-input filter_input"
                                                   :id="'airline'+airline.id"
                                                   v-model="ValidatingAirlineCode" :value="airline.code"
                                                   checked>
                                            <label class="custom-control-label" :for="'airline'+airline.id">

                                                {{ airline.name }}
                                                <img class="airline_filter_logo"
                                                     :src="'images/AirlineLogo_k/'+airline.image">

                                                <span
                                                    class="filter_min_fare">{{trs.from}} {{
                                                                    airline.TotalFare
                                                                }}€
                                                </span>
                                                <span class="only_filter">{{this.trs.only}}</span>
                                            </label>
                                        </div>

                                    </div>


                                </div>
                            </div>

                        </div>
                        <!--// airline Search -->
                    </div>
                    <div class="d-lg-none">
                        <div class="filter_modal_close_container">
                            <span class="filter_modal_close"><i class="fas fa-sort-amount-down"></i> {{trs.show_filter_result}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="search_loader" tabindex="-1" role="dialog" data-backdrop="static"
     data-keyboard="false"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg search_loader_modal">
        <div class="modal-content"
             style="background: url('images/{{$setting->search_loader_img}}') no-repeat center;">

            <div class="search_modal_container">

                <div
                    class="logo text-{{$setting->logo_position_search_loader ? $setting->logo_position_search_loader : "
                    center
                "}}">

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

