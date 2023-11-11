<template>
    <div class=" flight_page_container ">
        <div class="row margin-right-0px margin-left-0px">
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
                                                           v-model="this.stops" @change="handleAll('stops')"
                                                           value="ALL" id="stops_all" checked>

                                                    <label class="custom-control-label"
                                                           for="stops_all">{{ trs.choose_all }} </label>
                                                </div>

                                            </div>

                                            <div class="widget_item">

                                                <div class="custom-control custom-checkbox ">
                                                    <input type="checkbox" class="custom-control-input filter_input"
                                                           @change="removeAll('stops')"
                                                           id="stop0" v-model="this.stops"
                                                           value="0"
                                                           :disabled="this.search_data.none_stop">
                                                    <label class="custom-control-label" for="stop0">
                                                        {{ trs.none_stop }}
                                                    </label>
                                                    <span class="only_filter"
                                                          @click="only('stops','0')">{{ this.trs.only }}</span>
                                                </div>

                                            </div>

                                            <div v-if="!search_data.none_stop" class="widget_item">

                                                <div class="custom-control custom-checkbox ">
                                                    <input type="checkbox" class="custom-control-input filter_input"
                                                           @change="removeAll('stops')"
                                                           id="stop1" v-model="this.stops" value="1">
                                                    <label class="custom-control-label" for="stop1"> 1
                                                        {{ this.trs.stop }}
                                                    </label>
                                                    <span class="only_filter"
                                                          @click="only('stops','1')">{{ this.trs.only }}</span>
                                                </div>

                                            </div>
                                            <div v-if="!search_data.none_stop" class="widget_item">

                                                <div class="custom-control custom-checkbox ">
                                                    <input type="checkbox" class="custom-control-input filter_input"
                                                           @change="removeAll('stops')"
                                                           id="stop2" v-model="this.stops" value="2">

                                                    <label class="custom-control-label" for="stop2">
                                                        2+ {{ trs.stops_in_Counting }}
                                                    </label>
                                                    <span class="only_filter"
                                                          @click="only('stops','2')">{{ this.trs.only }}</span>
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
                                                    <label class="custom-control-label" for="bar0">
                                                        {{ this.trs.without_bar }}
                                                        <i class="bar_filter_icon"><img
                                                            src="images/icon/suitcase-solid.png"></i>
                                                    </label>
                                                    <span class="only_filter"
                                                          @click="only('bar_exist','0')">{{ this.trs.only }}</span>
                                                </div>

                                            </div>
                                            <div class="widget_item">

                                                <div class="custom-control custom-checkbox ">
                                                    <input type="checkbox"
                                                           class="custom-control-input filter_input"
                                                           id="bar1" v-model="this.bar_exist" value="1"
                                                           :checked="!filter || !filter.bar1 ? 'checked' : ''">
                                                    <label class="custom-control-label" for="bar1">
                                                        {{ this.trs.with_bar }}
                                                        <i class="bar_filter_icon fas fa-suitcase"></i>
                                                    </label>
                                                    <span class="only_filter"
                                                          @click="only('bar_exist','1')">{{ this.trs.only }}</span>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <!--// bar Search -->

                                    <!-- time search -->
                                    <div class="widget">

                                        <div class="widget_content">
                                            <div class="widget-sub-title">
                                                <span>{{ this.trs.depart }}</span>
                                            </div>
                                            <div class="widget_item">

                                                <div class="custom-control custom-checkbox font-weight-600 ">
                                                    <input type="checkbox" @change="handleAll('depart_time_range')"
                                                           class="custom-control-input choose_all "
                                                           id="depart_time_all"
                                                           v-model="this.depart_time_range"
                                                           value="ALL" checked>
                                                    <label class="custom-control-label"
                                                           for="depart_time_all">{{ trs.choose_all }} </label>
                                                </div>

                                            </div>
                                            <div class="widget_item">

                                                <div class="custom-control custom-checkbox ">
                                                    <input type="checkbox" @change="removeAll('depart_time_range')"
                                                           class="custom-control-input filter_input"
                                                           id="depart_time0"
                                                           v-model="this.depart_time_range" value="0" checked>
                                                    <label class="custom-control-label"
                                                           for="depart_time0">{{ this.trs.midnight }}
                                                    </label>
                                                    <span class="only_filter"
                                                          @click="only('depart_time_range','0')">{{
                                                            this.trs.only
                                                        }}</span>
                                                </div>

                                            </div>
                                            <div class="widget_item">

                                                <div class="custom-control custom-checkbox ">
                                                    <input type="checkbox" @change="removeAll('depart_time_range')"
                                                           class="custom-control-input filter_input"
                                                           id="depart_time1"
                                                           v-model="this.depart_time_range" value="1" checked>
                                                    <label class="custom-control-label"
                                                           for="depart_time1">{{ this.trs.morning }}
                                                    </label>
                                                    <span class="only_filter"
                                                          @click="only('depart_time_range','1')">{{
                                                            this.trs.only
                                                        }}</span>
                                                </div>

                                            </div>
                                            <div class="widget_item">

                                                <div class="custom-control custom-checkbox ">
                                                    <input type="checkbox" @change="removeAll('depart_time_range')"
                                                           class="custom-control-input filter_input"
                                                           id="depart_time2"
                                                           v-model="this.depart_time_range" value="2" checked>
                                                    <label class="custom-control-label"
                                                           for="depart_time2">{{ this.trs.afternoon }}
                                                    </label>
                                                    <span class="only_filter"
                                                          @click="only('depart_time_range','2')">{{
                                                            this.trs.only
                                                        }}</span>
                                                </div>

                                            </div>
                                            <div class="widget_item">

                                                <div class="custom-control custom-checkbox ">
                                                    <input type="checkbox" @change="removeAll('depart_time_range')"
                                                           class="custom-control-input filter_input"
                                                           id="depart_time3"
                                                           v-model="this.depart_time_range" value="3" checked>
                                                    <label class="custom-control-label"
                                                           for="depart_time3">{{ this.trs.night }}
                                                    </label>
                                                    <span class="only_filter"
                                                          @click="only('depart_time_range','3')">{{
                                                            this.trs.only
                                                        }}</span>
                                                </div>

                                            </div>

                                            <!--                                return-->
                                            <div v-if="this.flights.length && this.flights[0].DirectionInd==2"
                                                 class="margin-top-15px">
                                                <div class="widget-sub-title">
                                                    <span>{{ trs.return }}</span>
                                                </div>
                                                <div class="widget_item">

                                                    <div
                                                        class="custom-control custom-checkbox font-weight-600 ">
                                                        <input type="checkbox"
                                                               @change="handleAll('return_depart_time_range')"
                                                               class="custom-control-input choose_all"
                                                               id="return_time_all"
                                                               v-model="return_depart_time_range"
                                                               value="ALL" checked>
                                                        <label class="custom-control-label"
                                                               for="return_time_all">{{ trs.choose_all }}</label>
                                                    </div>

                                                </div>
                                                <div class="widget_item">

                                                    <div class="custom-control custom-checkbox ">
                                                        <input type="checkbox"
                                                               @change="removeAll('return_depart_time_range')"
                                                               class="custom-control-input filter_input"
                                                               id="return_time0"
                                                               v-model="return_depart_time_range" value="0"
                                                               checked>
                                                        <label class="custom-control-label"
                                                               for="return_time0">{{ trs.midnight }}
                                                        </label>
                                                        <span class="only_filter"
                                                              @click="only('return_depart_time_range','0')">{{
                                                                this.trs.only
                                                            }}</span>
                                                    </div>

                                                </div>
                                                <div class="widget_item">

                                                    <div class="custom-control custom-checkbox ">
                                                        <input type="checkbox"
                                                               @change="removeAll('return_depart_time_range')"
                                                               class="custom-control-input filter_input"
                                                               id="return_time1"
                                                               v-model="return_depart_time_range" value="1"
                                                               checked>
                                                        <label class="custom-control-label"
                                                               for="return_time1">{{ trs.morning }}
                                                        </label>
                                                        <span class="only_filter"
                                                              @click="only('return_depart_time_range','1')">{{
                                                                this.trs.only
                                                            }}</span>
                                                    </div>

                                                </div>
                                                <div class="widget_item">

                                                    <div class="custom-control custom-checkbox ">
                                                        <input type="checkbox"
                                                               @change="removeAll('return_depart_time_range')"
                                                               class="custom-control-input filter_input"
                                                               id="return_time2"
                                                               v-model="return_depart_time_range" value="2"
                                                               checked>
                                                        <label class="custom-control-label"
                                                               for="return_time2">{{ trs.afternoon }}
                                                        </label>
                                                        <span class="only_filter"
                                                              @click="only('return_depart_time_range','2')">{{
                                                                this.trs.only
                                                            }}</span>
                                                    </div>

                                                </div>
                                                <div class="widget_item">

                                                    <div class="custom-control custom-checkbox ">
                                                        <input type="checkbox"
                                                               @change="removeAll('return_depart_time_range')"
                                                               class="custom-control-input filter_input"
                                                               id="return_time3"
                                                               v-model="return_depart_time_range" value="3"
                                                               checked>
                                                        <label class="custom-control-label"
                                                               for="return_time3">{{ trs.night }}
                                                        </label>
                                                        <span class="only_filter"
                                                              @click="only('return_depart_time_range','3')">{{
                                                                this.trs.only
                                                            }}</span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--// time Search -->


                                    <!-- waiting time search -->
                                    <div v-if="!search_data.none_stop" class="widget">
                                        <div class="widget_content">
                                            <div class="widget-sub-title">
                                                <span>{{ trs.waiting_time }}</span>
                                            </div>
                                            <div class="widget_item">

                                                <div class="">
                                                    <input type="text" class="slide_input" id="total_waiting"
                                                           name="depart_wait"
                                                           v-model="this.slider.text"
                                                           readonly>
                                                </div>
                                                <div id="slide_filter1" class="slide_filter slider-styled">
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!--// waiting time Search -->


                                    <!-- airline search -->
                                    <div class="widget">

                                        <div class="widget_content">
                                            <div class="airlines_widget">

                                                <div class="widget_item">

                                                    <div class="custom-control custom-checkbox font-weight-600 ">
                                                        <input type="checkbox"
                                                               @change="handleAll('ValidatingAirlineCode')"
                                                               class="custom-control-input choose_all"
                                                               id="airline0"
                                                               v-model="ValidatingAirlineCode"
                                                               value="ALL" checked>
                                                        <label class="custom-control-label"
                                                               for="airline0">{{ trs.choose_all }}</label>
                                                    </div>

                                                </div>

                                                <div v-for="airline in this.airlines" class="widget_item">

                                                    <div class="custom-control custom-checkbox ">
                                                        <input type="checkbox"
                                                               @change="removeAll('ValidatingAirlineCode')"
                                                               class="custom-control-input filter_input"
                                                               :id="'airline'+airline.id"
                                                               v-model="ValidatingAirlineCode" :value="airline.code"
                                                               checked>
                                                        <label class="custom-control-label"
                                                               :for="'airline'+airline.id">

                                                            {{ airline.name }}
                                                            <img class="airline_filter_logo"
                                                                 :src="'images/AirlineLogo_k/'+airline.image">

                                                            <span
                                                                class="filter_min_fare">{{ trs.from }} {{
                                                                    airline.TotalFare
                                                                }}€
                                                            </span>
                                                        </label>
                                                        <span class="only_filter"
                                                              @click="only('ValidatingAirlineCode',airline.code)">{{
                                                                this.trs.only
                                                            }}</span>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                    <!--// airline Search -->
                                </div>
                                <div class="d-lg-none">
                                    <div class="filter_modal_close_container">
                                        <span class="filter_modal_close"><i
                                            class="fas fa-sort-amount-down"></i> {{ trs.show_filter_result }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-10 col-12 flight_post_body">
                <div class="flights_container">

                    <div id="airline_list_main_container">
                        <div class="airline_list_container d-none d-lg-block">

                            <div class="row">

                                <div class="col-12">

                                    <table class="table table-bordered">
                                        <thead>
                                        <tr class="thead_airline_logo">
                                            <th class="first_row" rowspan="2" scope="col">{{
                                                    this.trs.airlines
                                                }}
                                            </th>


                                            <th v-for="item in airlines_list" scope="col">
                                                <div><img :src="'images/'+item[0].image"></div>
                                            </th>

                                        </tr>
                                        <tr class="thead_airline_name">

                                            <th v-for="item in airlines_list" scope="col">
                                                <div>{{
                                                        item[0].name
                                                    }}
                                                </div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-if="this.flight_grouped[0] && this.flight_grouped[0].stops==0">
                                            <th class="first_row" scope="row">{{ this.trs.none_stop }}</th>

                                            <td v-for="airline in this.airlines_list"
                                                :class="airline[0].stops==0 ? 'airline_list_filter' :''">

                                                {{
                                                    airline[0].stops == 0 ? (airline[0].FarePerAdult * airline[0].adult + airline[0].FarePerChild * airline[0].child + airline[0].FarePerInf * airline[0].infant) : "-"
                                                }}
                                            </td>
                                            {{ this.airline_counter1Add() }}
                                        </tr>

                                        <tr v-if="this.flight_grouped[this.airline_counter1] && this.flight_grouped[this.airline_counter1].stops==1">

                                            <th class="first_row" scope="row">1 {{ this.trs.stop }}</th>

                                            <td v-for="airline in this.airlines_list" class="airline_list_filter">
                                                {{
                                                    airline[0].stops == 1 ? (airline[0].FarePerAdult * airline[0].adult + airline[0].FarePerChild * airline[0].child + airline[0].FarePerInf * airline[0].infant) : (airline[1] && airline[1].stops == 1 ? (airline[1].FarePerAdult * airline[1].adult + airline[1].FarePerChild * airline[1].child + airline[1].FarePerInf * airline[1].infant) : "-")
                                                }}
                                            </td>

                                            {{ this.airline_counter2Add() }}
                                        </tr>

                                        <tr v-if="this.flight_grouped[this.airline_counter2] && this.flight_grouped[this.airline_counter2].stops==2">
                                            <th class="first_row" scope="row">+2 {{
                                                    this.trs.stops_in_Counting
                                                }}
                                            </th>

                                            <td v-for="airline in this.airlines_list" class="airline_list_filter">{{
                                                    airline[0].stops == 2 ? (airline[0].FarePerAdult * airline[0].adult + airline[0].FarePerChild * airline[0].child + airline[0].FarePerInf * airline[0].infant) : (airline[1] && airline[1].stops == 2 ? (airline[1].FarePerAdult * airline[1].adult + airline[1].FarePerChild * airline[1].child + airline[1].FarePerInf * airline[1].infant) : (airline[2] ? (airline[2].FarePerAdult * airline[2].adult + airline[2].FarePerChild * airline[2].child + airline[2].FarePerInf * airline[2].infant) : "-"))
                                                }}
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="orderby_container">

                        <div class="row margin-left-0px margin-right-0px">

                            <div class="col first_div reorder_div ">
                                <div class="orderby_item" :class="this.order_active==0 ? 'active_order' : ''"
                                     @click="changeOrder(0)">
                                <span><i class="fas fa-money-bill"></i>
                                    {{ this.trs.cheapest }}
                                </span>
                                </div>
                            </div>

                            <div v-if="this.flights.length && this.flights[0].DirectionInd==2"
                                 class="col reorder_div">
                                <div class="orderby_item" :class="this.order_active==1 ? 'active_order' : ''"
                                     @click="changeOrder(1)">
                                <span><i class="fas fa-clock"></i>
                                    {{ this.trs.depart_and_return + ": " + this.trs.Shortest }}
                                </span>
                                </div>
                            </div>


                            <div class="col reorder_div">
                                <div class="orderby_item" :class="this.order_active==2 ? 'active_order' : ''"
                                     @click="changeOrder(2)">
                                <span><i class="fas fa-clock"></i>
                                    {{ this.trs.depart + ": " + this.trs.Shortest }}
                                </span>
                                </div>
                            </div>

                            <div v-if="this.flights.length && this.flights[0].DirectionInd==2"
                                 class="col last_div reorder_div">
                                <div class="orderby_item" :class="this.order_active==3 ? 'active_order' : ''"
                                     @click="changeOrder(3)">
                                <span><i class="fas fa-clock"></i>
                                    {{ this.trs.return + ": " + this.trs.Shortest }}
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flight_header">

                        <div class="flight_header_container">
                            <div class="row">

                                <div class="col-10">
                                    <div class="row">
                                        <div class="flight_item col">
                                            <span>{{ this.trs.airline }}</span>
                                        </div>
                                        <div class="flight_item col">
                                            <span>{{ this.trs.flight_number }}</span>
                                        </div>
                                        <div class="flight_item col">
                                            <span>{{ this.trs.flight_date }}</span>
                                        </div>
                                        <div class="flight_item col">
                                            <span>{{ this.trs.enter_date }}</span>
                                        </div>
                                        <div class="flight_item col">
                                            <div class="row margin-left-0px margin-right-0px">
                                                <div class="flight_item col">
                                                    <span>{{ this.trs.duration }}</span>
                                                </div>

                                                <div v-if="!search_data || !search_data.none_stop"
                                                     class="flight_item col text-red">
                                                    <span>{{ this.trs.waiting }}</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flight_item col-2">
                                    <span>{{ this.trs.price }}</span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="flight_main_container">
                        <div id="flight_posts_content">
                            <div v-for="(item,index) in this.resultQuery"
                                 :class="item.ValidatingAirlineCode=='IR' && !no_recommended ? 'our_recommend_container' : ''">

                                <div v-if="item.ValidatingAirlineCode=='IR'" class="our_recommend">
                                    {{ this.trs.our_recommend }}
                                </div>


                                <div class="flight_container filter_class padding-0px margin-bottom-0px">
                                    <div class="flight-post with-hover box-shadow-hover"
                                         :class="this.collapse_array.includes(index) || this.collapse_price_array.includes(index) ? 'f_p_active_bxs' : ''">

                                        <div class="flight_post_container">
                                            <div class="row">

                                                <div class="col-12 col-md-10">

                                                    <div class="details_link" data-toggle="collapse"
                                                         role="button"
                                                         @click="this.collapse(index)"
                                                         aria-expanded="false">
                                                        <div class="row d-md-none">
                                                            <div class="flight_item logo_container col-4 ">

                                                                <div
                                                                    v-for="logo in getDistinctAirline(item.airlines).filter(i => i.pivot.is_return === 0)"
                                                                    class="logo_leg">
                                                                    <img :src="'images/'+logo.image"
                                                                         :alt="logo.name">
                                                                </div>


                                                                <div v-if="!item.airlines" class="logo_leg">
                                                                    <img src="images/AirlineLogo/default.png">
                                                                </div>

                                                            </div>
                                                            <div class="col-4 flight_item ">
                                                                <div class="top_item f_t_time">
                                                            <span>
                                                                {{ item.flight_number }}
                                                            </span>
                                                                </div>
                                                                <div class="bot_item">
                                                            <span>
                                                                {{ turn_class(item.class) }}/{{ item.class_code }}
                                                            </span>
                                                                </div>

                                                                <div v-if="!item.stops" class="text-black">
                                                            <span class="aircraft_name">
                                                                {{ item.legs[0].aircraft_type }}
                                                                <i class="fas fa-info-circle"></i>
                                                                <span class="aircraft_description">
                                                                    {{ item.legs[0].aircraft_type_description }}
                                                                </span>
                                                            </span>
                                                                </div>

                                                            </div>
                                                            <div class="flight_item col-4 deal_button_md_d">
                                                                <a href="#">
                                                                    <span>{{ item.TotalFare }} €</span>

                                                                    <i class="fas fa-long-arrow-alt-right"></i>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="depart_section"
                                                             :class="item.DirectionInd==1 ? 'border-bottom-0 padding-bottom-0px-imp' : ''">
                                                            <div class="row">

                                                                <div
                                                                    class="flight_item logo_container col d-md-block d-none">


                                                                    <div
                                                                        v-for="logo in getDistinctAirline(item.airlines).filter(i => i.pivot.is_return == 0)"

                                                                        class="logo_leg">
                                                                        <img :src="'images/'+logo.image"
                                                                             :alt="logo.name">
                                                                    </div>

                                                                    <div v-if="!item.airlines" class="logo_leg">
                                                                        <img src="images/AirlineLogo/default.png">
                                                                    </div>
                                                                </div>

                                                                <div class="flight_item col d-md-block d-none">

                                                                    <div class="top_item f_t_time">
                                                                <span>
                                                                    {{ item.flight_number }}
                                                                </span>
                                                                    </div>
                                                                    <div class="bot_item">
                                                                <span>
                                                                    {{ this.turn_class(item.class) }}/{{
                                                                        item.class_code
                                                                    }}
                                                                </span>
                                                                    </div>

                                                                    <div v-if="!item.stops" class="text-black">
                                                                    <span class="aircraft_name">
                                                                        {{ item.legs[0].aircraft_type }}
                                                                        <i class="fas fa-info-circle"></i>
                                                                        <span class="aircraft_description">
                                                                            {{ item.legs[0].aircraft_type_description }}
                                                                        </span>
                                                                    </span>
                                                                    </div>
                                                                </div>

                                                                <div class="flight_item col">

                                                                    <div class="top_item f_t_time">
                                                                    <span>
                                                                        {{
                                                                            new Date(item.depart_time).toLocaleString('de-DE', this.time_option)
                                                                        }}
                                                                    </span>
                                                                    </div>
                                                                    <div class="bot_item">
                                                                    <span v-if="item.airports1">
                                                                        {{
                                                                            item.airports1[this.city] != "" ? item.airports1[this.city] : item.airports1.city_en
                                                                        }}
                                                                        -{{
                                                                            item.airports1.code != "" ? item.airports1.code : item.depart_airport
                                                                        }}
                                                                    </span>
                                                                        <span v-else>
                                                                        {{ item.depart_airport }}
                                                                    </span>

                                                                    </div>
                                                                    <div class="date_item">
                                                                    <span>
                                                                        {{
                                                                            this.turn_day_of_week(item.depart_time)
                                                                        }} {{
                                                                            new Date(item.depart_time).toLocaleString('de-DE', this.date_option)
                                                                        }}
                                                                    </span>
                                                                    </div>
                                                                </div>

                                                                <!--                                                            sm display div-->

                                                                <div
                                                                    class="flight_item col d-md-none sm_display_div_result">

                                                                    <div class="flight_duration_md">
                                                                    <span>
                                                                        {{
                                                                            parseInt(item.total_time / 60)
                                                                        }} h
                                                                        {{
                                                                            item.total_time % 60 != 0 ? ":" + item.total_time % 60 + "'" : ""
                                                                        }}
                                                                    </span>

                                                                    </div>
                                                                    <div class="flight_duration_md">
                                                                    <span>
                                                                        {{
                                                                            item.stops == 0 ? this.trs.none_stop : (item.stops == 1 ? item.stops + " " + this.trs.stop : item.stops + " " + this.trs.stops_in_Counting)
                                                                        }}

                                                                        <span class="flight_duration_md_waiting">
                                                                            {{
                                                                                item.total_waiting == 0 ? "" : parseInt(item.total_waiting / 60)
                                                                            }} h {{
                                                                                item.total_waiting != 0 ? (item.total_waiting % 60 != 0 ? ":" + item.total_waiting % 60 + "'" : "") : ""
                                                                            }}{{
                                                                                item.total_waiting == 0 ? "" : " waiting"
                                                                            }}
                                                                        </span>
                                                                    </span>
                                                                    </div>

                                                                    <div class="flight_duration_md">

                                                                        <div v-if="min_seat_calculate(item.legs)[0]"
                                                                             class="flight_seats_price_deal">
                                                                        <span
                                                                            :class="min_seat_calculate(item.legs)[0]==search_data.adl+search_data.chl ? 'text-red' :'' ">
                                                                        <img src="images/icon/flight-seat.png"
                                                                             class="flight_seat_image"> {{
                                                                                min_seat_calculate(item.legs)[0]
                                                                            }}
                                                                       {{ this.trs.seats_remains }}
                                                                        </span>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <!--                                                          end sm display div-->

                                                                <div class="flight_item col">

                                                                    <div class="top_item f_t_time">
                                                                    <span>
                                                                        {{
                                                                            new Date(item.arrival_time).toLocaleString('de-DE', this.time_option)
                                                                        }}
                                                                    </span>
                                                                    </div>
                                                                    <div class="bot_item">
                                                                    <span v-if="item.airports2">
                                                                        {{
                                                                            item.airports2[this.city] != "" ? item.airports2[this.city] : item.airports2.city_en
                                                                        }}
                                                                        -{{
                                                                            item.airports2.code != "" ? item.airports2.code : item.arrival_airport
                                                                        }}
                                                                    </span>
                                                                        <span v-else>
                                                                        {{ item.arrival_airport }}
                                                                    </span>

                                                                    </div>
                                                                    <div class="date_item">
                                                                    <span>
                                                                        {{
                                                                            this.turn_day_of_week(item.arrival_time)
                                                                        }} {{
                                                                            new Date(item.arrival_time).toLocaleString('de-DE', this.date_option)
                                                                        }}
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                                <div class="flight_item col d-md-block d-none">
                                                                    <div
                                                                        class="row margin-left-0px margin-right-0px">
                                                                        <div class="flight_item col">

                                                                            <div class="top_item time_detail">
                                                                            <span>
                                                                                 {{
                                                                                    parseInt(item.total_time / 60)
                                                                                }} h
                                                                                {{
                                                                                    item.total_time % 60 != 0 ? ":" + item.total_time % 60 + "'" : ""
                                                                                }}
                                                                            </span>
                                                                            </div>
                                                                            <div class="bot_item">
                                                                            <span>
                                                                                {{
                                                                                    item.stops == 0 ? this.trs.none_stop : (item.stops == 1 ? item.stops + " " + this.trs.stop : item.stops + " " + this.trs.stops_in_Counting)
                                                                                }}
                                                                            </span>
                                                                            </div>

                                                                            <div
                                                                                v-if="min_seat_calculate(item.legs)[0]"
                                                                                class="flight_seats_price_deal">
                                                                            <span
                                                                                :class="min_seat_calculate(item.legs)[0]==search_data.adl+search_data.chl ? 'text-red' :'' ">
                                                                                <img src="images/icon/flight-seat.png"
                                                                                     class="flight_seat_image">
                                                                                {{
                                                                                    min_seat_calculate(item.legs)[0]
                                                                                }}
                                                                                {{ this.trs.seats_remains }}
                                                                            </span>
                                                                            </div>


                                                                        </div>

                                                                        <div class="flight_item col">

                                                                            <div
                                                                                class="top_item time_detail waiting_time">
                                                                            <span>

                                                                                {{
                                                                                    item.total_waiting == 0 ? "" : parseInt(item.total_waiting / 60)
                                                                                }} h {{
                                                                                    item.total_waiting != 0 ? (item.total_waiting % 60 != 0 ? ":" + item.total_waiting % 60 + "'" : "") : ""
                                                                                }}
                                                                            </span>
                                                                            </div>


                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--                                                    return section-->

                                                        <div v-if="item.DirectionInd==2">
                                                            <div class="row d-md-none">
                                                                <div class="flight_item logo_container col-4 ">


                                                                    <div
                                                                        v-for="logo in getDistinctAirline(item.airlines).filter(i => i.pivot.is_return === 1)"
                                                                        class="logo_leg">
                                                                        <img :src="'images/'+logo.image"
                                                                             :alt="logo.name">
                                                                    </div>


                                                                    <div v-if="!item.airlines" class="logo_leg">
                                                                        <img src="images/AirlineLogo/default.png">
                                                                    </div>

                                                                </div>
                                                                <div class="col-4 flight_item ">
                                                                    <div class="top_item f_t_time">
                                                                <span>
                                                                    {{ item.return_flight_number }}
                                                                </span>
                                                                    </div>
                                                                    <div class="bot_item">
                                                                <span>
                                                                    {{ this.turn_class(item.return_class) }}/{{
                                                                        item.return_class_code
                                                                    }}
                                                                </span>
                                                                    </div>

                                                                    <div v-if="!item.return_stops"
                                                                         class="text-black">
                                                                    <span class="aircraft_name">
                                                                        {{
                                                                            item.legs[item.legs.length - 1].aircraft_type
                                                                        }}
                                                                        <i class="fas fa-info-circle"></i>
                                                                        <span class="aircraft_description">
                                                                            {{
                                                                                item.legs[item.legs.length - 1].aircraft_type_description
                                                                            }}
                                                                        </span>
                                                                    </span>
                                                                    </div>


                                                                </div>
                                                                <div class="col-4"></div>
                                                            </div>

                                                            <div class="return_section">
                                                                <div class="row">

                                                                    <div
                                                                        class="flight_item logo_container col d-md-block d-none">

                                                                        <div
                                                                            v-for="logo in getDistinctAirline(item.airlines).filter(i => i.pivot.is_return === 1)"
                                                                            class="logo_leg">
                                                                            <img :src="'images/'+logo.image"
                                                                                 :alt="logo.name">
                                                                        </div>


                                                                        <div v-if="!item.airlines" class="logo_leg">
                                                                            <img
                                                                                src="images/AirlineLogo/default.png">
                                                                        </div>

                                                                    </div>
                                                                    <div class="flight_item col d-md-block d-none ">
                                                                        <div class="top_item f_t_time">
                                                                    <span>
                                                                        {{ item.return_flight_number }}
                                                                    </span>
                                                                        </div>
                                                                        <div class="bot_item">
                                                                    <span>
                                                                        {{
                                                                            this.turn_class(item.return_class)
                                                                        }}/{{ item.return_class_code }}
                                                                    </span>
                                                                        </div>

                                                                        <div v-if="!item.return_stops"
                                                                             class="text-black">
                                                                    <span class="aircraft_name">
                                                                        {{
                                                                            item.legs[item.legs.length - 1].aircraft_type
                                                                        }}
                                                                        <i class="fas fa-info-circle"></i>
                                                                        <span class="aircraft_description">
                                                                            {{
                                                                                item.legs[item.legs.length - 1].aircraft_type_description
                                                                            }}
                                                                        </span>
                                                                    </span>
                                                                        </div>

                                                                    </div>

                                                                    <div class="flight_item col">

                                                                        <div class="top_item f_t_time">
                                                                    <span>
                                                                        {{
                                                                            new Date(item.return_depart_time).toLocaleString('de-DE', this.time_option)
                                                                        }}
                                                                    </span>

                                                                        </div>
                                                                        <div class="bot_item">
                                                                    <span v-if="item.airports3">
                                                                        {{
                                                                            item.airports3[this.city] != "" ? item.airports3[this.city] : item.airports3.city_en
                                                                        }}
                                                                        -{{
                                                                            item.airports3.code != "" ? item.airports3.code : item.return_depart_airport
                                                                        }}
                                                                    </span>
                                                                            <span v-else>
                                                                        {{ item.return_depart_airport }}
                                                                    </span>


                                                                        </div>
                                                                        <div class="date_item">
                                                                    <span>
                                                                        {{
                                                                            this.turn_day_of_week(item.return_depart_time)
                                                                        }} {{
                                                                            new Date(item.return_depart_time).toLocaleString('de-DE', this.date_option)
                                                                        }}
                                                                    </span>
                                                                        </div>
                                                                    </div>

                                                                    <!--                                                            sm display div-->

                                                                    <div
                                                                        class="flight_item col d-md-none sm_display_div_result">

                                                                        <div class="flight_duration_md">
                                                                    <span>
                                                                        {{
                                                                            parseInt(item.return_total_time / 60)
                                                                        }} h
                                                                        {{
                                                                            item.return_total_time % 60 != 0 ? ":" + item.return_total_time % 60 + "'" : ""
                                                                        }}
                                                                    </span>

                                                                        </div>
                                                                        <div class="flight_duration_md">
                                                                            <span>
                                                                                {{
                                                                                    item.return_stops == 0 ? this.trs.none_stop : (item.return_stops == 1 ? item.return_stops + " " + this.trs.stop : item.return_stops + " " + this.trs.stops_in_Counting)
                                                                                }}
                                                                                <span
                                                                                    class="flight_duration_md_waiting">
                                                                                    {{
                                                                                        item.return_total_waiting == 0 ? "" : parseInt(item.return_total_waiting / 60) + "h"
                                                                                    }}{{
                                                                                        item.return_total_waiting != 0 ? (item.return_total_waiting % 60 != 0 ? ":" + item.return_total_waiting % 60 + "'" : "") : ""
                                                                                    }}
                                                                                    {{
                                                                                        item.return_total_waiting == 0 ? "" : " waiting"
                                                                                    }}
                                                                        </span>
                                                                    </span>
                                                                        </div>
                                                                        <div class="flight_duration_md">

                                                                            <div
                                                                                v-if="min_seat_calculate(item.legs)[1]"
                                                                                class="flight_seats_price_deal">
                                                                            <span
                                                                                :class="min_seat_calculate(item.legs)[1]==search_data.adl+search_data.chl ? 'text-red' :'' ">
                                                                                <img src="images/icon/flight-seat.png"
                                                                                     class="flight_seat_image">
                                                                                {{
                                                                                    min_seat_calculate(item.legs)[1]
                                                                                }}
                                                                                {{ this.trs.seats_remains }}
                                                                            </span>
                                                                            </div>


                                                                        </div>
                                                                    </div>

                                                                    <!--                                                            end sm display div-->


                                                                    <div class="flight_item col">

                                                                        <div class="top_item f_t_time">
                                                                    <span>
                                                                        {{
                                                                            new Date(item.return_arrival_time).toLocaleString('de-DE', this.time_option)
                                                                        }}
                                                                    </span>
                                                                        </div>
                                                                        <div class="bot_item">
                                                                    <span v-if="item.airports4">
                                                                        {{
                                                                            item.airports4[this.city] != "" ? item.airports4[this.city] : item.airports4.city_en
                                                                        }}
                                                                        -{{
                                                                            item.airports4.code != "" ? item.airports4.code : item.return_arrival_airport
                                                                        }}
                                                                    </span>
                                                                            <span v-else>
                                                                        {{ item.return_arrival_airport }}
                                                                    </span>

                                                                        </div>
                                                                        <div class="date_item">
                                                                    <span>
                                                                        {{
                                                                            this.turn_day_of_week(item.return_arrival_time)
                                                                        }} {{
                                                                            new Date(item.return_arrival_time).toLocaleString('de-DE', this.date_option)
                                                                        }}
                                                                    </span>
                                                                        </div>


                                                                    </div>

                                                                    <div class="flight_item d-md-block d-none col">
                                                                        <div
                                                                            class="row margin-left-0px margin-right-0px">
                                                                            <div class="flight_item col">
                                                                                <div class="top_item time_detail">
                                                                            <span>
                                                                                 {{
                                                                                    parseInt(item.return_total_time / 60)
                                                                                }} h
                                                                                {{
                                                                                    item.return_total_time % 60 != 0 ? ":" + item.return_total_time % 60 + "'" : ""
                                                                                }}
                                                                            </span>
                                                                                </div>
                                                                                <div class="bot_item">
                                                                            <span>
                                                                                {{
                                                                                    item.return_stops == 0 ? this.trs.none_stop : (item.return_stops == 1 ? item.return_stops + " " + this.trs.stop : item.return_stops + " " + this.trs.stops_in_Counting)
                                                                                }}
                                                                            </span>
                                                                                </div>
                                                                                <div
                                                                                    v-if="min_seat_calculate(item.legs)[1]"
                                                                                    class="flight_seats_price_deal">
                                                                            <span
                                                                                :class="min_seat_calculate(item.legs)[1]==search_data.adl+search_data.chl ? 'text-red' :'' ">
                                                                                <img src="images/icon/flight-seat.png"
                                                                                     class="flight_seat_image">
                                                                                {{
                                                                                    min_seat_calculate(item.legs)[1]
                                                                                }}
                                                                                {{ this.trs.seats_remains }}
                                                                            </span>
                                                                                </div>
                                                                            </div>

                                                                            <div class="flight_item col">
                                                                                <div
                                                                                    class="top_item time_detail waiting_time">
                                                                            <span>

                                                                                {{
                                                                                    item.return_total_waiting == 0 ? "" : parseInt(item.return_total_waiting / 60)
                                                                                }} h {{
                                                                                    item.return_total_waiting != 0 ? (item.return_total_waiting % 60 != 0 ? ":" + item.return_total_waiting % 60 + "'" : "") : ""
                                                                                }}
                                                                            </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>


                                                        <div v-if="item.DirectionInd==4">
                                                            <div v-for="multi in item.multi_flights">
                                                                <div class="row d-md-none">

                                                                    <div class="flight_item logo_container col-4 ">


                                                                        <div
                                                                            v-for="logo in getDistinctAirline(multi.airlines).filter(i => i.pivot.is_return === 1)"
                                                                            class="logo_leg">
                                                                            <img :src="'images/'+logo.image"
                                                                                 :alt="logo.name">
                                                                        </div>


                                                                        <div v-if="!multi.airlines"
                                                                             class="logo_leg">
                                                                            <img
                                                                                src="images/AirlineLogo/default.png">
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-4 flight_item ">
                                                                        <div class="top_item f_t_time">
                                                                <span>
                                                                    {{ multi.flight_number }}
                                                                </span>
                                                                        </div>
                                                                        <div class="bot_item">
                                                                <span>
                                                                    {{ this.turn_class(multi.class) }}/{{
                                                                        multi.class_code
                                                                    }}
                                                                </span>
                                                                        </div>
                                                                        <div v-if="!multi.stops" class="text-black">
                                                                    <span class="aircraft_name">
                                                                        {{
                                                                            multi.legs[multi.legs.length - 1].aircraft_type
                                                                        }}
                                                                        <i class="fas fa-info-circle"></i>
                                                                        <span class="aircraft_description">
                                                                            {{
                                                                                multi.legs[multi.legs.length - 1].aircraft_type_description
                                                                            }}
                                                                        </span>
                                                                    </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4"></div>

                                                                </div>

                                                                <div class="return_section multi_section">
                                                                    <div class="row">

                                                                        <div
                                                                            class="flight_item logo_container col d-md-block d-none">

                                                                            <div
                                                                                v-for="logo in getDistinctAirline(multi.airlines).filter(i => i.pivot.is_return === 1)"
                                                                                class="logo_leg">
                                                                                <img :src="'images/'+logo.image"
                                                                                     :alt="logo.name">
                                                                            </div>


                                                                            <div v-if="!multi.airlines"
                                                                                 class="logo_leg">
                                                                                <img
                                                                                    src="images/AirlineLogo/default.png">
                                                                            </div>

                                                                        </div>
                                                                        <div
                                                                            class="flight_item col d-md-block d-none ">
                                                                            <div class="top_item f_t_time">
                                                                    <span>
                                                                        {{ multi.flight_number }}
                                                                    </span>
                                                                            </div>
                                                                            <div class="bot_item">
                                                                    <span>
                                                                        {{
                                                                            this.turn_class(multi.class)
                                                                        }}/{{ multi.class_code }}
                                                                    </span>
                                                                            </div>

                                                                            <div v-if="!multi.stops"
                                                                                 class="text-black">
                                                                    <span class="aircraft_name">
                                                                        {{
                                                                            multi.legs[0].aircraft_type
                                                                        }}
                                                                        <i class="fas fa-info-circle"></i>
                                                                        <span class="aircraft_description">
                                                                            {{
                                                                                multi.legs[0].aircraft_type_description
                                                                            }}
                                                                        </span>
                                                                    </span>
                                                                            </div>

                                                                        </div>

                                                                        <div class="flight_item col">

                                                                            <div class="top_item f_t_time">
                                                                    <span>
                                                                        new Date(multi.depart_time).toLocaleString('de-DE', this.time_option)
                                                                    </span>

                                                                            </div>
                                                                            <div class="bot_item">
                                                                    <span v-if="multi.airports1">
                                                                        {{
                                                                            multi.airports1[this.city] != "" ? multi.airports1[this.city] : multi.airports1.city_en
                                                                        }}
                                                                        -{{
                                                                            multi.airports1.code != "" ? multiairports1.code : multi.depart_airport
                                                                        }}
                                                                    </span>
                                                                                <span v-else>
                                                                        {{ multi.depart_airport }}
                                                                    </span>


                                                                            </div>
                                                                            <div class="date_item">
                                                                    <span>
                                                                        {{
                                                                            this.turn_day_of_week(multi.depart_time)
                                                                        }} {{
                                                                            new Date(multi.depart_time).toLocaleString('de-DE', this.date_option)
                                                                        }}
                                                                    </span>
                                                                            </div>
                                                                        </div>

                                                                        <!--                                                                   sm display div-->

                                                                        <div
                                                                            class="flight_item col d-md-none sm_display_div_result">

                                                                            <div class="flight_duration_md">
                                                                    <span>
                                                                        {{
                                                                            parseInt(multi.total_time / 60)
                                                                        }} h
                                                                        {{
                                                                            multi.total_time % 60 != 0 ? ":" + multi.total_time % 60 + "'" : ""
                                                                        }}
                                                                    </span>

                                                                            </div>
                                                                            <div class="flight_duration_md">
                                                                    <span>
                                                                        {{
                                                                            multi.stops == 0 ? this.trs.none_stop : (multi.stops == 1 ? multi.stops + " " + this.trs.stop : multi.stops + " " + this.trs.stops_in_Counting)
                                                                        }}
                                                                        <span class="flight_duration_md_waiting">
                                                                            {{
                                                                                multi.total_waiting == 0 ? "" : parseInt(multi.total_waiting / 60) + "h"
                                                                            }}{{
                                                                                multi.total_waiting != 0 ? (multi.total_waiting % 60 != 0 ? ":" + multi.total_waiting % 60 + "'" : "") : ""
                                                                            }}
                                                                            {{
                                                                                multi.total_waiting == 0 ? "" : " waiting"
                                                                            }}
                                                                        </span>
                                                                    </span>
                                                                            </div>
                                                                            <div class="flight_duration_md">

                                                                                <div
                                                                                    v-if="min_seat_calculate(multi.legs)[0]"
                                                                                    class="flight_seats_price_deal">
                                                                            <span
                                                                                :class="min_seat_calculate(multi.legs)[0]==search_data.adl+search_data.chl ? 'text-red' :'' ">
                                                                                <img src="images/icon/flight-seat.png"
                                                                                     class="flight_seat_image">
                                                                                {{
                                                                                    min_seat_calculate(multi.legs)[0]
                                                                                }}
                                                                                {{ this.trs.seats_remains }}
                                                                            </span>
                                                                                </div>


                                                                            </div>
                                                                        </div>

                                                                        <!--                                                                    end sm display div-->

                                                                        <div class="flight_item col">

                                                                            <div class="top_item f_t_time">
                                                                    <span>
                                                                        {{
                                                                            new Date(multi.arrival_time).toLocaleString('de-DE', this.time_option)
                                                                        }}
                                                                    </span>
                                                                            </div>
                                                                            <div class="bot_item">
                                                                    <span v-if="multi.airports2">
                                                                        {{
                                                                            multi.airports2[this.city] != "" ? multi.airports2[this.city] : multi.airports2.city_en
                                                                        }}
                                                                        -{{
                                                                            multi.airports2.code != "" ? multi.airports2.code : multi.arrival_airport
                                                                        }}
                                                                    </span>
                                                                                <span v-else>
                                                                        {{ multi.arrival_airport }}
                                                                    </span>

                                                                            </div>
                                                                            <div class="date_item">
                                                                    <span>
                                                                        {{
                                                                            this.turn_day_of_week(multi.arrival_time)
                                                                        }} {{
                                                                            new Date(multi.arrival_time).toLocaleString('de-DE', this.date_option)
                                                                        }}
                                                                    </span>
                                                                            </div>

                                                                        </div>

                                                                        <div
                                                                            class="flight_item d-md-block d-none col">
                                                                            <div
                                                                                class="row margin-left-0px margin-right-0px">
                                                                                <div class="flight_item col">
                                                                                    <div
                                                                                        class="top_item time_detail">
                                                                            <span>
                                                                                 {{
                                                                                    parseInt(multi.total_time / 60)
                                                                                }} h
                                                                                {{
                                                                                    multi.total_time % 60 != 0 ? ":" + multi.total_time % 60 + "'" : ""
                                                                                }}
                                                                            </span>
                                                                                    </div>
                                                                                    <div class="bot_item">
                                                                            <span>
                                                                                {{
                                                                                    multi.stops == 0 ? this.trs.none_stop : (multi.stops == 1 ? multi.stops + " " + this.trs.stop : multi.stops + " " + this.trs.stops_in_Counting)
                                                                                }}
                                                                            </span>
                                                                                    </div>
                                                                                    <div
                                                                                        v-if="min_seat_calculate(multi.legs)[0]"
                                                                                        class="flight_seats_price_deal">
                                                                            <span
                                                                                :class="min_seat_calculate(multi.legs)[0]==search_data.adl+search_data.chl ? 'text-red' :'' ">
                                                                                <img src="images/icon/flight-seat.png"
                                                                                     class="flight_seat_image">
                                                                                {{
                                                                                    min_seat_calculate(multi.legs)[0]
                                                                                }}
                                                                                {{ this.trs.seats_remains }}
                                                                            </span>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="flight_item col">
                                                                                    <div
                                                                                        class="top_item time_detail waiting_time">
                                                                            <span>

                                                                                {{
                                                                                    multi.total_waiting == 0 ? "" : parseInt(multi.total_waiting / 60)
                                                                                }} h {{
                                                                                    multi.total_waiting != 0 ? (multi.total_waiting % 60 != 0 ? ":" + multi.total_waiting % 60 + "'" : "") : ""
                                                                                }}
                                                                            </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="flight_details">
                                                        <div class="rules">
                                                            <div>
                                                                <span class="details_link" data-toggle="collapse"
                                                                      role="button" aria-expanded="false"
                                                                      @click="this.collapse(index)"
                                                                      aria-controls="collapseExample">
                                                                <span class="all_details_link">
                                                                    <i class="fas fa-info-circle"></i>
                                                                    <div
                                                                        class="flight_details_detail_link display-inline"
                                                                        :class="this.collapse_array.includes(index) ?'details_link_active' : ''">
                                                                        <span class="d-none d-md-inline">{{
                                                                                this.trs.details
                                                                            }}
                                                                        </span>
                                                                    </div>
                                                                </span>
                                                            </span>
                                                            </div>
                                                            <div>
                                                                <span class="price_link" data-toggle="collapse"
                                                                      role="button"
                                                                      @click="this.collapse_price(index)"
                                                                      aria-expanded="false"
                                                                      aria-controls="collapseExample">
                                                                <span class="all_details_link">
                                                                    <i class="fas fa-money-bill"></i>
                                                                    <div
                                                                        class="price_details_detail_link display-inline"
                                                                        :class="this.collapse_price_array.includes(index) ?'details_link_active' : ''">
                                                                        <span
                                                                            class="d-none d-md-inline">{{
                                                                                this.trs.price
                                                                            }}</span>
                                                                    </div>
                                                                </span></span>
                                                            </div>
                                                            <div>
                                                                <span class="all_details_link"
                                                                      @click="this.bar_rule(item.id)">
                                                                    <span v-if="!item.bar_exist">
                                                                        <i><img
                                                                            src="images/icon/suitcase-solid.png"></i>
                                                                        <span
                                                                            v-if="item.return_bar_exist && item.DirectionInd==2">
                                                                            / <i class="fas fa-suitcase "></i>
                                                                            <span class="d-none d-md-inline">{{
                                                                                    item.return_bar
                                                                                }}</span>
                                                                        </span>
                                                                    </span>
                                                                    <div v-else>
                                                                        <i class="fas fa-suitcase "></i>
                                                                        <span class="d-md-inline">{{ item.bar }}
                                                                            <i v-if="!item.return_bar_exist && item.DirectionInd==2">/
                                                                                <img
                                                                                    src="images/icon/suitcase-solid.png"></i>
                                                                            <i v-else>{{
                                                                                    item.bar != item.return_bar && item.return_bar != "" ? "/" + item.return_bar : ""
                                                                                }}</i>
                                                                        </span>
                                                                    </div>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span class="all_details_link"
                                                                      @click="this.ticket_rule(item.id)">
                                                                    <i class="fas fa-ticket-alt"></i>
                                                                    <span class="d-none d-md-inline">
                                                                        {{ this.trs.ticket_rules }}
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2 d-none d-md-block deal_container">

                                                    <div class="deal_content"
                                                         :class="item.DirectionInd!=1 ? 'return_deal_bottom' : 'single_deal_bottom'">
                                                        <div class="deal_price_total">
                                                            <span>{{ item.TotalFare }} €</span>
                                                        </div>

                                                        <div v-if="item.TotalFare!=item.FarePerAdult"
                                                             class="deal_price_detail">
                                                        <span>{{
                                                                Math.round(item.FarePerAdult)
                                                            }} € {{ this.trs["p.a"] }}</span>
                                                        </div>


                                                        <a href="#">
                                                            <div class="deal_button">{{ this.trs.deal }}</div>
                                                        </a>

                                                        <div class="deal_section_baggage_container">
                                                        <span class="deal_section_baggage" id="baggage_rules">
                                                            <span v-if="!item.bar_exist">
                                                                <i><img src="images/icon/suitcase-solid.png"></i>
                                                                <span
                                                                    v-if="item.return_bar_exist && item.DirectionInd==2">
                                                                    / <i class="fas fa-suitcase "></i>
                                                                    <span class="d-none d-md-inline">{{
                                                                            item.return_bar
                                                                        }}</span>
                                                                </span>
                                                            </span>
                                                            <span v-else>
                                                                <i class="fas fa-suitcase "></i>
                                                                <span class="d-none d-md-inline">{{ item.bar }}
                                                                    <span
                                                                        v-if="!item.return_bar_exist && item.DirectionInd==2">
                                                                        / <i> <img src="images/icon/suitcase-solid.png"></i>
                                                                    </span>
                                                                    <i v-else>
                                                                        {{
                                                                            item.bar != item.return_bar && item.return_bar != "" ? "/" + item.return_bar : ""
                                                                        }}
                                                                    </i>
                                                                </span>
                                                            </span>
                                                        </span>
                                                        </div>

                                                        <div
                                                            v-if="!item.bar_exist || (item.DirectionInd==2 && !item.return_bar_exist)"
                                                            class="deal_section_baggage_alert">
                                                        <span>
                                                            {{
                                                                (!item.bar_exist && !item.return_bar_exist) ? this.trs.no_baggage : (!item.bar_exist ? this.trs.no_baggage_depart : this.trs.no_baggage_return)
                                                            }}
                                                        </span>
                                                        </div>


                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                        <!--                                    details section-->
                                        <div class="collapse flight_details_container" :id="'flight_details'+index">
                                            <!--                                    depart details-->

                                            <div class="details_content">

                                                <div class="details_header">
                                                    <div class="row">

                                                        <div class="col-10 col-md-6 details_title">
                                                        <span class="details_title_way">
                                                            {{
                                                                item.DirectionInd == 4 ? this.trs.trip : this.trs.depart
                                                            }}
                                                        </span>
                                                            <span class="details_title_f_t">
                                                            {{
                                                                    (item.airports1 ? item.airports1.name : item.depart_airport) + "-" + (item.airports2 ? item.airports2.name : item.arrival_airport)
                                                                }}
                                                        </span>
                                                        </div>
                                                        <div class="col-2 col-md-6 details_time">
                                                        <span>{{ parseInt(item.total_time / 60) + "h" }}{{
                                                                item.total_time % 60 != 0 ? ":" + item.total_time % 60 + "'" : ""
                                                            }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="details_body">

                                                    <div class="details_body_head d-md-block d-none">
                                                        <div class="row">
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.airline }}</span>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.flight_number }}</span>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.flight_date }}</span>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.enter_date }}</span>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <div class="row">
                                                                    <div class="flight_item col">
                                                                        <span>{{ this.trs.duration }}</span>
                                                                    </div>
                                                                    <div
                                                                        v-if="!search_data || !search_data.none_stop"
                                                                        class="flight_item col text-red">
                                                                        <span>{{ this.trs.waiting }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.bar }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!--                                                flight leg-->


                                                    <div v-for="leg in item.legs.filter(i => i.is_return === 0)"
                                                         class="depart_section">
                                                        <div class="row">

                                                            <div class="flight_item logo_container col-4 col-md-2">

                                                                <div class="logo_leg">
                                                                    <img
                                                                        :src="'images/' + (leg.airlines ? leg.airlines.image : 'AirlineLogo/default.png')"
                                                                        :alt="leg.airlines ? leg.airlines.name : '' ">
                                                                </div>
                                                            </div>
                                                            <div class="col-4 flight_item d-md-none">
                                                                <div class="top_item f_t_time">
                                                                <span>
                                                                    {{ leg.leg_flight_number }}
                                                                </span>
                                                                </div>
                                                                <div class="bot_item">
                                                                <span>
                                                                    {{
                                                                        this.turn_class(leg.cabin_class)
                                                                    }}/{{ leg.cabin_class_code }}
                                                                </span>
                                                                </div>

                                                                <div v-if="leg.aircraft_type" class="date_item">
                                                                <span class="aircraft_name">
                                                                    {{ leg.aircraft_type }} <i
                                                                    class="fas fa-info-circle"></i>
                                                                    <span class="aircraft_description">
                                                                        {{ leg.aircraft_type_description }}
                                                                    </span>
                                                                </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 d-md-none"></div>

                                                            <div class="flight_item col-md-2 d-md-block d-none">

                                                                <div class="top_item f_t_time">
                                                                <span>
                                                                    {{ leg.leg_flight_number }}
                                                                </span>
                                                                </div>
                                                                <div class="bot_item">
                                                                <span>
                                                                    {{
                                                                        this.turn_class(leg.cabin_class)
                                                                    }}/{{ leg.cabin_class_code }}
                                                                </span>
                                                                </div>

                                                                <div v-if="leg.aircraft_type" class="date_item">
                                                                <span class="aircraft_name">
                                                                    {{ leg.aircraft_type }} <i
                                                                    class="fas fa-info-circle"></i>
                                                                    <span class="aircraft_description">
                                                                        {{ leg.aircraft_type_description }}
                                                                    </span>
                                                                </span>
                                                                </div>
                                                            </div>

                                                            <div class="flight_item col col-md-2">

                                                                <div class="top_item f_t_time">
                                                                <span>
                                                                    {{
                                                                        new Date(leg.leg_depart_time).toLocaleString('de-DE', this.time_option)
                                                                    }}
                                                                </span>
                                                                </div>
                                                                <div class="bot_item">
                                                                <span>
                                                                    {{
                                                                        leg.airports1 ? (leg.airports1[this.city] != "" ? leg.airports1[this.city] : leg.airports1.city_en) : ""
                                                                    }} -
                                                                </span>
                                                                    <span>
                                                                    {{
                                                                            leg.airports1 ? (leg.airports1.name != "" ? leg.airports1.name : leg.leg_depart_airport) : leg.leg_depart_airport
                                                                        }}
                                                                </span>
                                                                </div>
                                                                <div class="date_item">
                                                                <span>
                                                                    {{
                                                                        this.turn_day_of_week(leg.leg_depart_time)
                                                                    }}  {{
                                                                        new Date(leg.leg_depart_time).toLocaleString('de-DE', this.date_option)
                                                                    }}
                                                                </span>
                                                                </div>
                                                            </div>


                                                            <!--                                                        sm display div-->

                                                            <div
                                                                class="flight_item col d-md-none sm_display_div_result_details">

                                                                <div class="flight_duration_md">
                                                                <span>
                                                                    {{
                                                                        parseInt(leg.leg_time / 60) + "h"
                                                                    }}{{
                                                                        leg.leg_time % 60 != 0 ? ":" + leg.leg_time % 60 + "'" : ""
                                                                    }}
                                                                </span>

                                                                </div>


                                                                <div class="flight_duration_md">
                                                                <span v-if="!leg.leg_bar_exist">
                                                                    <i> <img class="width-20px"
                                                                             src="images/icon/suitcase-solid.png"></i>
                                                                </span>
                                                                    <span v-else-if="leg.leg_bar">
                                                                    <i class="fas fa-suitcase bar_leg"></i>
                                                                    {{ leg.leg_bar }}

                                                                </span>
                                                                </div>
                                                                <div class="flight_duration_md">
                                                                    <div v-if="leg.seats_remaining"
                                                                         class="date_item">
                                                                    <span
                                                                        :class="leg.seats_remaining < 5 ? 'text-red' : ''">
                                                                    <img src="images/icon/flight-seat.png"
                                                                         class="flight_seat_image"> {{
                                                                            leg.seats_remaining
                                                                        }}
                                                                    {{ this.trs.seats_remains }}
                                                                    </span>
                                                                    </div>
                                                                </div>

                                                                <div class="flight_duration_md">
                                                                <span class="flight_duration_md_waiting">
                                                                    {{
                                                                        leg.leg_waiting == 0 ? "" : parseInt(leg.leg_waiting / 60) + "h"
                                                                    }}{{
                                                                        leg.leg_waiting != 0 ? (leg.leg_waiting % 60 != 0 ? ":" + leg.leg_waiting % 60 + "'" : "") : ""
                                                                    }}
                                                                    <!--                                                                    {{ leg.leg_waiting == 0 ? "" : " waiting" }}-->
                                                                </span>
                                                                </div>

                                                            </div>

                                                            <!--                                                        end sm display div-->

                                                            <div class="flight_item col col-md-2">

                                                                <div class="top_item f_t_time">
                                                                <span>
                                                                    {{
                                                                        new Date(leg.leg_arrival_time).toLocaleString('de-DE', this.time_option)
                                                                    }}
                                                                </span>
                                                                </div>
                                                                <div class="bot_item">
                                                                <span>
                                                                    {{
                                                                        leg.airports2 ? (leg.airports2[this.city] != "" ? leg.airports2[this.city] : leg.airports2.city_en) : ""
                                                                    }} -
                                                                </span>
                                                                    <span>
                                                                    {{
                                                                            leg.airports2 ? (leg.airports2.name != "" ? leg.airports2.name : leg.leg_arrival_airport) : leg.leg_arrival_airport
                                                                        }}
                                                                </span>
                                                                </div>
                                                                <div class="date_item">
                                                                <span>
                                                                     {{
                                                                        this.turn_day_of_week(leg.leg_arrival_time)
                                                                    }}  {{
                                                                        new Date(leg.leg_arrival_time).toLocaleString('de-DE', this.date_option)
                                                                    }}
                                                                </span>
                                                                </div>
                                                            </div>

                                                            <div class="flight_item col-2 d-md-block d-none">
                                                                <div class="row">
                                                                    <div class="flight_item col">

                                                                        <div class="top_item time_detail">
                                                                        <span>
                                                                             {{
                                                                                parseInt(leg.leg_time / 60) + "h"
                                                                            }}{{
                                                                                leg.leg_time % 60 != 0 ? ":" + leg.leg_time % 60 + "'" : ""
                                                                            }}

                                                                        </span>
                                                                        </div>


                                                                    </div>


                                                                    <div v-if="!search_data.none_stop"
                                                                         class="flight_item col">

                                                                        <div
                                                                            class="top_item time_detail waiting_time">
                                                                        <span>
                                                                                {{
                                                                                leg.leg_waiting == 0 ? "" : parseInt(leg.leg_waiting / 60) + "h"
                                                                            }}{{
                                                                                leg.leg_waiting != 0 ? (leg.leg_waiting % 60 != 0 ? ":" + leg.leg_waiting % 60 + "'" : "") : ""
                                                                            }}
                                                                        </span>
                                                                        </div>


                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="flight_item col-2 d-md-block d-none">

                                                                <div class="top_item">
                                                                <span v-if="!leg.leg_bar_exist">
                                                                    <i> <img class="width-20px"
                                                                             src="images/icon/suitcase-solid.png"></i>
                                                                </span>
                                                                    <span v-else-if="leg.leg_bar">
                                                                    <i class="fas fa-suitcase bar_leg"></i>
                                                                    {{ leg.leg_bar }}
                                                                </span>
                                                                </div>

                                                                <div v-if="leg.seats_remaining" class="date_item">
                                                                <span
                                                                    :class="leg.seats_remaining < 5 ? 'text-red' : ''">
                                                                    <img src="images/icon/flight-seat.png"
                                                                         class="flight_seat_image"> {{
                                                                        leg.seats_remaining
                                                                    }}
                                                                    {{ this.trs.seats_remains }}
                                                                </span>
                                                                </div>

                                                            </div>


                                                        </div>
                                                    </div>

                                                </div>

                                            </div>


                                            <!--                                        return details-->
                                            <div v-if="item.DirectionInd==2" class="details_content">

                                                <div class="details_header">
                                                    <div class="row">

                                                        <div class="col-10 col-md-6 details_title">
                                                                <span class="details_title_way">{{
                                                                        this.trs.return
                                                                    }}</span>
                                                            <span class="details_title_f_t">
                                                            {{
                                                                    (item.airports3 ? item.airports3.name : item.return_depart_airport) + "-" + (item.airports4 ? item.airports4.name : item.return_arrival_airport)
                                                                }}
                                                        </span>

                                                        </div>
                                                        <div class="col-2 col-md-6 details_time text-right">
                                                        <span>
                                                           {{
                                                                parseInt(item.return_total_time / 60)
                                                            }} h
                                                                                {{
                                                                item.return_total_time % 60 != 0 ? ":" + item.return_total_time % 60 + "'" : ""
                                                            }}
                                                        </span>

                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="details_body">
                                                    <div class="details_body_head d-md-block d-none">

                                                        <div class="row">
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.airline }}</span>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.flight_number }}</span>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.flight_date }}</span>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.enter_date }}</span>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <div class="row">
                                                                    <div class="flight_item col">
                                                                        <span>{{ this.trs.duration }}</span>
                                                                    </div>
                                                                    <div
                                                                        v-if="!search_data || !search_data.none_stop"
                                                                        class="flight_item col text-red">
                                                                        <span>{{ this.trs.waiting }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.bar }}</span>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!--                                                flight leg-->
                                                    <div v-for="leg in item.legs.filter(i => i.is_return === 1)"
                                                         class="depart_section">
                                                        <div class="row">

                                                            <div class="flight_item logo_container col-4 col-md-2">

                                                                <div class="logo_leg">
                                                                    <img
                                                                        :src="'images/' + (leg.airlines ? leg.airlines.image : 'AirlineLogo/default.png')"
                                                                        :alt="leg.airlines ? leg.airlines.name : '' ">
                                                                </div>
                                                            </div>
                                                            <div class="col-4 flight_item d-md-none">
                                                                <div class="top_item f_t_time">
                                                                <span>
                                                                    {{ leg.leg_flight_number }}
                                                                </span>
                                                                </div>
                                                                <div class="bot_item">
                                                                <span>
                                                                    {{
                                                                        this.turn_class(leg.cabin_class)
                                                                    }}/{{ leg.cabin_class_code }}
                                                                </span>
                                                                </div>

                                                                <div v-if="leg.aircraft_type" class="date_item">
                                                                <span class="aircraft_name">
                                                                    {{ leg.aircraft_type }} <i
                                                                    class="fas fa-info-circle"></i>
                                                                    <span class="aircraft_description">
                                                                        {{ leg.aircraft_type_description }}
                                                                    </span>
                                                                </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 d-md-none"></div>

                                                            <div class="flight_item col-md-2 d-md-block d-none">

                                                                <div class="top_item f_t_time">
                                                                <span>
                                                                    {{ leg.leg_flight_number }}
                                                                </span>
                                                                </div>
                                                                <div class="bot_item">
                                                                <span>
                                                                    {{
                                                                        this.turn_class(leg.cabin_class)
                                                                    }}/{{ leg.cabin_class_code }}
                                                                </span>
                                                                </div>

                                                                <div v-if="leg.aircraft_type" class="date_item">
                                                                <span class="aircraft_name">
                                                                    {{ leg.aircraft_type }} <i
                                                                    class="fas fa-info-circle"></i>
                                                                    <span class="aircraft_description">
                                                                        {{ leg.aircraft_type_description }}
                                                                    </span>
                                                                </span>
                                                                </div>
                                                            </div>

                                                            <div class="flight_item col col-md-2">

                                                                <div class="top_item f_t_time">
                                                                <span>
                                                                    {{
                                                                        new Date(leg.leg_depart_time).toLocaleString('de-DE', this.time_option)
                                                                    }}
                                                                </span>
                                                                </div>
                                                                <div class="bot_item">
                                                                <span>
                                                                    {{
                                                                        leg.airports1 ? (leg.airports1[this.city] != "" ? leg.airports1[this.city] : leg.airports1.city_en) : ""
                                                                    }} -
                                                                </span>
                                                                    <span>
                                                                    {{
                                                                            leg.airports1 ? (leg.airports1.name != "" ? leg.airports1.name : leg.leg_depart_airport) : leg.leg_depart_airport
                                                                        }}
                                                                </span>
                                                                </div>
                                                                <div class="date_item">
                                                                <span>
                                                                    {{
                                                                        this.turn_day_of_week(leg.leg_depart_time)
                                                                    }}  {{
                                                                        new Date(leg.leg_depart_time).toLocaleString('de-DE', this.date_option)
                                                                    }}
                                                                </span>
                                                                </div>
                                                            </div>

                                                            <!--                                                        sm display div-->

                                                            <div
                                                                class="flight_item col d-md-none sm_display_div_result_details">

                                                                <div class="flight_duration_md">
                                                                <span>
                                                                    {{
                                                                        parseInt(leg.leg_time / 60) + "h"
                                                                    }}{{
                                                                        leg.leg_time % 60 != 0 ? ":" + leg.leg_time % 60 + "'" : ""
                                                                    }}
                                                                </span>

                                                                </div>


                                                                <div class="flight_duration_md">
                                                                <span v-if="!leg.leg_bar_exist">
                                                                    <i> <img class="width-20px"
                                                                             src="images/icon/suitcase-solid.png"></i>
                                                                </span>
                                                                    <span v-else-if="leg.leg_bar">
                                                                    <i class="fas fa-suitcase bar_leg"></i>
                                                                    {{ leg.leg_bar }}

                                                                </span>
                                                                </div>
                                                                <div class="flight_duration_md">
                                                                    <div v-if="leg.seats_remaining"
                                                                         class="date_item">
                                                                    <span
                                                                        :class="leg.seats_remaining < 5 ? 'text-red' : ''">
                                                                    <img src="images/icon/flight-seat.png"
                                                                         class="flight_seat_image"> {{
                                                                            leg.seats_remaining
                                                                        }}
                                                                    {{ this.trs.seats_remains }}
                                                                    </span>
                                                                    </div>
                                                                </div>

                                                                <div class="flight_duration_md">
                                                                <span class="flight_duration_md_waiting">
                                                                    {{
                                                                        leg.leg_waiting == 0 ? "" : parseInt(leg.leg_waiting / 60) + "h"
                                                                    }}{{
                                                                        leg.leg_waiting != 0 ? (leg.leg_waiting % 60 != 0 ? ":" + leg.leg_waiting % 60 + "'" : "") : ""
                                                                    }}
                                                                    <!--                                                                    {{ leg.leg_waiting == 0 ? "" : " waiting" }}-->
                                                                </span>
                                                                </div>

                                                            </div>

                                                            <!--                                                        end sm display div-->

                                                            <div class="flight_item col col-md-2">

                                                                <div class="top_item f_t_time">
                                                                <span>
                                                                    {{
                                                                        new Date(leg.leg_arrival_time).toLocaleString('de-DE', this.time_option)
                                                                    }}
                                                                </span>
                                                                </div>
                                                                <div class="bot_item">
                                                                <span>
                                                                    {{
                                                                        leg.airports2 ? (leg.airports2[this.city] != "" ? leg.airports2[this.city] : leg.airports2.city_en) : ""
                                                                    }} -
                                                                </span>
                                                                    <span>
                                                                    {{
                                                                            leg.airports2 ? (leg.airports2.name != "" ? leg.airports2.name : leg.leg_arrival_airport) : leg.leg_arrival_airport
                                                                        }}
                                                                </span>
                                                                </div>
                                                                <div class="date_item">
                                                                <span>
                                                                     {{
                                                                        this.turn_day_of_week(leg.leg_arrival_time)
                                                                    }}  {{
                                                                        new Date(leg.leg_arrival_time).toLocaleString('de-DE', this.date_option)
                                                                    }}
                                                                </span>
                                                                </div>
                                                            </div>

                                                            <div class="flight_item col-2 d-md-block d-none">
                                                                <div class="row">
                                                                    <div class="flight_item col">

                                                                        <div class="top_item time_detail">
                                                                        <span>
                                                                             {{
                                                                                parseInt(leg.leg_time / 60) + "h"
                                                                            }}{{
                                                                                leg.leg_time % 60 != 0 ? ":" + leg.leg_time % 60 + "'" : ""
                                                                            }}

                                                                        </span>
                                                                        </div>


                                                                    </div>


                                                                    <div v-if="!search_data.none_stop"
                                                                         class="flight_item col">

                                                                        <div
                                                                            class="top_item time_detail waiting_time">
                                                                        <span>
                                                                                {{
                                                                                leg.leg_waiting == 0 ? "" : parseInt(leg.leg_waiting / 60) + "h"
                                                                            }}{{
                                                                                leg.leg_waiting != 0 ? (leg.leg_waiting % 60 != 0 ? ":" + leg.leg_waiting % 60 + "'" : "") : ""
                                                                            }}
                                                                        </span>
                                                                        </div>


                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="flight_item col-2 d-md-block d-none">

                                                                <div class="top_item">
                                                                <span v-if="!leg.leg_bar_exist">
                                                                    <i> <img class="width-20px"
                                                                             src="images/icon/suitcase-solid.png"></i>
                                                                </span>
                                                                    <span v-else-if="leg.leg_bar">
                                                                    <i class="fas fa-suitcase bar_leg"></i>
                                                                    {{ leg.leg_bar }}
                                                                </span>
                                                                </div>

                                                                <div v-if="leg.seats_remaining" class="date_item">
                                                                <span
                                                                    :class="leg.seats_remaining < 5 ? 'text-red' : ''">
                                                                    <img src="images/icon/flight-seat.png"
                                                                         class="flight_seat_image"> {{
                                                                        leg.seats_remaining
                                                                    }}
                                                                    {{ this.trs.seats_remains }}
                                                                </span>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>

                                                    <!--                                                flight leg-->

                                                </div>

                                            </div>

                                            <!--                                           return details-->


                                            <div v-if="item.DirectionInd==4"
                                                 v-for="(key,multi) in item.multi_flights"
                                                 class="details_content">

                                                <div class="details_header">
                                                    <div class="row">

                                                        <div class="col-10 col-md-6 details_title">
                                                        <span class="details_title_way">{{ this.trs.trip }}{{
                                                                key + 2
                                                            }}</span>
                                                            <span class="details_title_f_t">
                                                            {{
                                                                    (multi.airports1 ? multi.airports1.name : multi.depart_airport) + "-" + (multi.airports2 ? multi.airports2.name : multi.arrival_airport)
                                                                }}
                                                        </span>

                                                        </div>
                                                        <div class="col-2 col-md-6 details_time text-right">
                                                        <span>
                                                            {{
                                                                parseInt(item.total_time / 60)
                                                            }} h
                                                            {{
                                                                item.total_time % 60 != 0 ? ":" + item.total_time % 60 + "'" : ""
                                                            }}
                                                        </span>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="details_body">
                                                    <div class="details_body_head d-md-block d-none">
                                                        <div class="row">
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.airline }}</span>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.flight_number }}</span>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.flight_date }}</span>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.enter_date }}</span>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <div class="row">
                                                                    <div class="flight_item col">
                                                                        <span>{{ this.trs.duration }}</span>
                                                                    </div>
                                                                    <div
                                                                        v-if="!search_data || !search_data.none_stop"
                                                                        class="flight_item col text-red">
                                                                        <span>{{ this.trs.waiting }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="flight_item col-2">
                                                                <span>{{ this.trs.bar }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!--                                                flight leg-->

                                                    <div v-for="leg in multi.legs.filter(i => i.is_return === 0)"
                                                         class="depart_section">
                                                        <div class="row">

                                                            <div class="flight_item logo_container col-4 col-md-2">

                                                                <div class="logo_leg">
                                                                    <img
                                                                        :src="'images/' + (leg.airlines ? leg.airlines.image : 'AirlineLogo/default.png')"
                                                                        :alt="leg.airlines ? leg.airlines.name : '' ">
                                                                </div>
                                                            </div>
                                                            <div class="col-4 flight_item d-md-none">
                                                                <div class="top_item f_t_time">
                                                                <span>
                                                                    {{ leg.leg_flight_number }}
                                                                </span>
                                                                </div>
                                                                <div class="bot_item">
                                                                <span>
                                                                    {{
                                                                        this.turn_class(leg.cabin_class)
                                                                    }}/{{ leg.cabin_class_code }}
                                                                </span>
                                                                </div>

                                                                <div v-if="leg.aircraft_type" class="date_item">
                                                                <span class="aircraft_name">
                                                                    {{ leg.aircraft_type }} <i
                                                                    class="fas fa-info-circle"></i>
                                                                    <span class="aircraft_description">
                                                                        {{ leg.aircraft_type_description }}
                                                                    </span>
                                                                </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 d-md-none"></div>

                                                            <div class="flight_item col-md-2 d-md-block d-none">

                                                                <div class="top_item f_t_time">
                                                                <span>
                                                                    {{ leg.leg_flight_number }}
                                                                </span>
                                                                </div>
                                                                <div class="bot_item">
                                                                <span>
                                                                    {{
                                                                        this.turn_class(leg.cabin_class)
                                                                    }}/{{ leg.cabin_class_code }}
                                                                </span>
                                                                </div>

                                                                <div v-if="leg.aircraft_type" class="date_item">
                                                                <span class="aircraft_name">
                                                                    {{ leg.aircraft_type }} <i
                                                                    class="fas fa-info-circle"></i>
                                                                    <span class="aircraft_description">
                                                                        {{ leg.aircraft_type_description }}
                                                                    </span>
                                                                </span>
                                                                </div>
                                                            </div>

                                                            <div class="flight_item col col-md-2">

                                                                <div class="top_item f_t_time">
                                                                <span>
                                                                    {{
                                                                        new Date(leg.leg_depart_time).toLocaleString('de-DE', this.time_option)
                                                                    }}
                                                                </span>
                                                                </div>
                                                                <div class="bot_item">
                                                                <span>
                                                                    {{
                                                                        leg.airports1 ? (leg.airports1[this.city] != "" ? leg.airports1[this.city] : leg.airports1.city_en) : ""
                                                                    }} -
                                                                </span>
                                                                    <span>
                                                                    {{
                                                                            leg.airports1 ? (leg.airports1.name != "" ? leg.airports1.name : leg.leg_depart_airport) : leg.leg_depart_airport
                                                                        }}
                                                                </span>
                                                                </div>
                                                                <div class="date_item">
                                                                <span>
                                                                    {{
                                                                        this.turn_day_of_week(leg.leg_depart_time)
                                                                    }}  {{
                                                                        new Date(leg.leg_depart_time).toLocaleString('de-DE', this.date_option)
                                                                    }}
                                                                </span>
                                                                </div>
                                                            </div>

                                                            <!--                                                        sm display div-->

                                                            <div
                                                                class="flight_item col d-md-none sm_display_div_result_details">

                                                                <div class="flight_duration_md">
                                                                <span>
                                                                    {{
                                                                        parseInt(leg.leg_time / 60) + "h"
                                                                    }}{{
                                                                        leg.leg_time % 60 != 0 ? ":" + leg.leg_time % 60 + "'" : ""
                                                                    }}
                                                                </span>

                                                                </div>


                                                                <div class="flight_duration_md">
                                                                <span v-if="!leg.leg_bar_exist">
                                                                    <i> <img class="width-20px"
                                                                             src="images/icon/suitcase-solid.png"></i>
                                                                </span>
                                                                    <span v-else-if="leg.leg_bar">
                                                                    <i class="fas fa-suitcase bar_leg"></i>
                                                                    {{ leg.leg_bar }}

                                                                </span>
                                                                </div>
                                                                <div class="flight_duration_md">
                                                                    <div v-if="leg.seats_remaining"
                                                                         class="date_item">
                                                                    <span
                                                                        :class="leg.seats_remaining < 5 ? 'text-red' : ''">
                                                                    <img src="images/icon/flight-seat.png"
                                                                         class="flight_seat_image"> {{
                                                                            leg.seats_remaining
                                                                        }}
                                                                    {{ this.trs.seats_remains }}
                                                                    </span>
                                                                    </div>
                                                                </div>

                                                                <div class="flight_duration_md">
                                                                <span class="flight_duration_md_waiting">
                                                                    {{
                                                                        leg.leg_waiting == 0 ? "" : parseInt(leg.leg_waiting / 60) + "h"
                                                                    }}{{
                                                                        leg.leg_waiting != 0 ? (leg.leg_waiting % 60 != 0 ? ":" + leg.leg_waiting % 60 + "'" : "") : ""
                                                                    }}
                                                                    <!--                                                                    {{ leg.leg_waiting == 0 ? "" : " waiting" }}-->
                                                                </span>
                                                                </div>

                                                            </div>

                                                            <!--                                                        end sm display div-->

                                                            <div class="flight_item col col-md-2">

                                                                <div class="top_item f_t_time">
                                                                <span>
                                                                    {{
                                                                        new Date(leg.leg_arrival_time).toLocaleString('de-DE', this.time_option)
                                                                    }}
                                                                </span>
                                                                </div>
                                                                <div class="bot_item">
                                                                <span>
                                                                    {{
                                                                        leg.airports2 ? (leg.airports2[this.city] != "" ? leg.airports2[this.city] : leg.airports2.city_en) : ""
                                                                    }} -
                                                                </span>
                                                                    <span>
                                                                    {{
                                                                            leg.airports2 ? (leg.airports2.name != "" ? leg.airports2.name : leg.leg_arrival_airport) : leg.leg_arrival_airport
                                                                        }}
                                                                </span>
                                                                </div>
                                                                <div class="date_item">
                                                                <span>
                                                                     {{
                                                                        this.turn_day_of_week(leg.leg_arrival_time)
                                                                    }}  {{
                                                                        new Date(leg.leg_arrival_time).toLocaleString('de-DE', this.date_option)
                                                                    }}
                                                                </span>
                                                                </div>
                                                            </div>

                                                            <div class="flight_item col-2 d-md-block d-none">
                                                                <div class="row">
                                                                    <div class="flight_item col">

                                                                        <div class="top_item time_detail">
                                                                        <span>
                                                                             {{
                                                                                parseInt(leg.leg_time / 60) + "h"
                                                                            }}{{
                                                                                leg.leg_time % 60 != 0 ? ":" + leg.leg_time % 60 + "'" : ""
                                                                            }}

                                                                        </span>
                                                                        </div>


                                                                    </div>


                                                                    <div v-if="!search_data.none_stop"
                                                                         class="flight_item col">

                                                                        <div
                                                                            class="top_item time_detail waiting_time">
                                                                        <span>
                                                                                {{
                                                                                leg.leg_waiting == 0 ? "" : parseInt(leg.leg_waiting / 60) + "h"
                                                                            }}{{
                                                                                leg.leg_waiting != 0 ? (leg.leg_waiting % 60 != 0 ? ":" + leg.leg_waiting % 60 + "'" : "") : ""
                                                                            }}
                                                                        </span>
                                                                        </div>


                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="flight_item col-2 d-md-block d-none">

                                                                <div class="top_item">
                                                                <span v-if="!leg.leg_bar_exist">
                                                                    <i> <img class="width-20px"
                                                                             src="images/icon/suitcase-solid.png"></i>
                                                                </span>
                                                                    <span v-else-if="leg.leg_bar">
                                                                    <i class="fas fa-suitcase bar_leg"></i>
                                                                    {{ leg.leg_bar }}
                                                                </span>
                                                                </div>

                                                                <div v-if="leg.seats_remaining" class="date_item">
                                                                <span
                                                                    :class="leg.seats_remaining < 5 ? 'text-red' : ''">
                                                                    <img src="images/icon/flight-seat.png"
                                                                         class="flight_seat_image"> {{
                                                                        leg.seats_remaining
                                                                    }}
                                                                    {{ this.trs.seats_remains }}
                                                                </span>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>

                                                    <!--                                                   // flight leg-->

                                                </div>

                                            </div>

                                        </div>

                                        <!--                                       //details section-->


                                        <!--    price detail-->
                                        <div class="collapse" :id="'price_details'+index">
                                            <div class="price_container">
                                                <div class="row">
                                                    <div class="col-12 price_table_container">
                                                        <table class="table table-striped">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">{{ this.trs.passengers }}</th>
                                                                <th scope="col">{{ this.trs.per_person }}</th>
                                                                <th scope="col">{{ this.trs.base_price }}</th>
                                                                <th scope="col">{{ this.trs.taxes_and_fees }}</th>

                                                                <!--                                                        <th scope="col">{{this.trs.service_fee}}</th>-->

                                                                <th scope="col">{{ this.trs.count }}</th>
                                                                <th scope="col">{{ this.trs.price }}</th>

                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            <tr v-if="item.adult">
                                                                <td>{{ this.trs.adult }}</td>

                                                                <td>{{ item.FarePerAdult }}</td>
                                                                <td>{{
                                                                        item.FarePerAdult - item.taxAdult - item.serviceAdult
                                                                    }}
                                                                </td>
                                                                <td>{{ item.taxAdult + item.serviceAdult }}</td>

                                                                <td>{{ item.adult }}</td>
                                                                <td>{{ item.FarePerAdult * item.adult }}</td>
                                                            </tr>


                                                            <tr v-if="item.child">
                                                                <td>{{ this.trs.child }}</td>
                                                                <td>{{ item.FarePerChild }}</td>
                                                                <td>{{
                                                                        item.FarePerChild - item.taxChild - item.serviceChild
                                                                    }}
                                                                </td>
                                                                <td>{{ item.taxChild + item.serviceChild }}</td>

                                                                <td>{{ item.child }}</td>
                                                                <td>{{ item.FarePerChild * item.child }}</td>
                                                            </tr>


                                                            <tr v-if="item.infant">
                                                                <td>{{ this.trs.infant }}</td>
                                                                <td>{{ item.FarePerInf }}</td>
                                                                <td>{{
                                                                        item.FarePerInf - item.taxInfant - item.serviceInfant
                                                                    }}
                                                                </td>
                                                                <td>{{ item.taxInfant + item.serviceInfant }}</td>
                                                                <td>{{ item.infant }}</td>
                                                                <td>{{ item.FarePerInf * item.infant }}</td>
                                                            </tr>

                                                            <tr class="total_price_tax">
                                                                <td>{{ this.trs.total_price }}</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>{{
                                                                        item.FarePerAdult * item.adult + item.FarePerChild * item.child + item.FarePerInf * item.infant
                                                                    }}
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--// row -->

            <div id="rules_modal_container"></div>

        </div>
    </div>


    <div class="modal fade" id="rules_modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalScrollableTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">{{ trs.ticket_rules }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <div v-if="rules && rules.Success">
                        <div v-if="rules.Success && rules.FareRules" v-for="(rule,index) in this.rules.FareRules "
                             class="card">
                            <div class="rules_direction" data-toggle="collapse" :data-target="'#rule'+index"
                                 aria-expanded="true">
                                    <span>
                                        {{ rule.CityPair ? rule.CityPair : this.trs.ticket }}
                                    </span>
                            </div>
                            <div :id="'rule'+index" class="collapse ca_body">
                                <div class="accordion" id="accordionExample2">
                                    <div v-for="(rule_detail,index2) in rule.RuleDetails " class="card">
                                        <div class="rules_title" data-toggle="collapse"
                                             :data-target="'#rule'+index+'_'+index2"
                                             aria-expanded="true">
                                        <span>
                                            {{ rule_detail.Category }}
                                        </span>
                                        </div>

                                        <div :id="'rule'+index+'_'+index2" class="collapse ca_body">
                                            <div class="rules_body">
                                                <p>
                                                    {{ rule_detail.Rules }}
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div v-else-if="rules.FareRuleText">
                            <div class="rules_direction">
                            <span>
                                {{ rules.FareRuleText.depart[0] }} - {{ rules.FareRuleText.depart[1] }}
                            </span>
                            </div>
                            {{ rules.FareRuleText.Description[0] }}

                            <div v-if="rules.FareRuleText.Description[1]">
                                <div class="rules_direction">
                            <span>
                                {{ rules.FareRuleText.return[0] }} - {{ rules.FareRuleText.return[1] }}
                            </span>
                                </div>
                                {{ rules.FareRuleText.Description[1] }}
                            </div>
                        </div>
                    </div>

                    <div class="custom_rule_div">
                        <span>{{ trs.service_fee_not_refunded_in_rule }}</span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trs.close }}</button>

                </div>
            </div>
        </div>


    </div>

    <div class="modal fade" id="baggage_modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalScrollableTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="baggageModalScrollableTitle">{{ trs.baggage_rules }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <div v-if="bagRules && (bagRules.Success || bagRules.FareRuleText ) ">
                        <table v-if="bagRules.BaggageInfoes" class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">{{ trs.depart }}</th>
                                <th scope="col">{{ trs.arrival }}</th>
                                <th scope="col">{{ trs.flight_number }}</th>
                                <th scope="col">{{ trs.bar }}</th>

                            </tr>
                            </thead>
                            <tbody>


                            <tr v-for="rule in bagRules.BaggageInfoes">
                                <td>{{ rule.Departure }}</td>
                                <td>{{ rule.Arrival }}</td>
                                <td>{{ rule.FlightNo }}</td>
                                <td>{{ rule.Baggage }}</td>
                            </tr>


                            </tbody>
                        </table>

                        <table v-if="bagRules.Services" class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">{{ trs.service }}</th>
                                <th scope="col">{{ trs.price }}</th>

                            </tr>
                            </thead>
                            <tbody>


                            <tr v-for="rule in bagRules.Services">
                                <td>{{ rule.Description }}</td>
                                <td>{{ rule.ServiceCost.Amount }} {{ rule.ServiceCost.Currency }}</td>
                            </tr>


                            </tbody>
                        </table>

                        <div v-if="bagRules.iran_air">
                            <div class="rules_direction">
                            <span>
                                {{ bagRules.FareRuleText.depart[0] }} - {{ rules.FareRuleText.depart[1] }}
                            </span>
                            </div>
                            <table class="table table-striped">

                                <tbody>
                                <tr>
                                    <td>
                                        {{ rules.iran_air[0] }}
                                    </td>
                                </tr>
                                </tbody>

                            </table>
                            <div v-if="bagRules.iran_air[1]">
                                <div class="rules_direction">
                            <span>
                                {{ bagRules.FareRuleText.return[0] }} - {{ bagRules.FareRuleText.return[1] }}
                            </span>
                                </div>
                                <table class="table table-striped">

                                    <tbody>
                                    <tr>
                                        <td>
                                            {{ rules.iran_air[0] }}
                                        </td>
                                    </tr>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <p>{{ trs.no_rules }}</p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trs.close }}</button>
                </div>
            </div>
        </div>
    </div>

</template>


<script>
import noUiSlider from 'nouislider';
import 'nouislider/dist/nouislider.css';

export default {

    mounted() {
        this.searchFlight();
        if (!this.filter.stops0) {
            this.stops.push('0')
        }
        if (!this.filter.stops1) {
            this.stops.push('1')
        }
        if (!this.filter.stops2) {
            this.stops.push('2')
        }
        this.removeAll('stops');
        if (!this.filter.bar0) {
            this.bar_exist.push('0')
        }
        if (!this.filter.bar1) {
            this.bar_exist.push('1')
        }
    },
    directives: {},
    props: ['lang', 'trs', 'search_data', 'ajax_render', 'csrf', 'flight_search_url', 'filter', 'air_rules_url', 'air_bag_url'],
    name: 'flights',
    methods: {
        getDistinctAirline(array) {

            return [...new Map(array.map(item => [item['id'] + 'r' + item.pivot['is_return'], item])).values()];
        },
        turn_class(code) {
            let cabin_class;
            switch (code) {
                case 1 :
                    cabin_class = this.trs.economy;
                    break;
                case 2 :
                    cabin_class = this.trs.premium_economy;
                    break;
                case 3 :
                    cabin_class = this.trs.business;
                    break;
                case 4 :
                    cabin_class = this.trs.premium_business;
                    break;
                case 5 :
                    cabin_class = this.trs.first;
                    break;
                case 6 :
                    cabin_class = this.trs.premium_first;
                    break;
                default :
                    cabin_class = this.trs.default;
                    break;
            }

            return cabin_class;
        },
        turn_day_of_week(code) {
            let day;
            switch (code) {
                case 0:
                    day = this.trs.sunday_short;
                    break;
                case 1:
                    day = this.trs.monday_short;
                    break;
                case 2:
                    day = this.trs.Tuesday_short;
                    break;
                case 3:
                    day = this.trs.Wednesday_short;
                    break;
                case 4:
                    day = this.trs.Thursday_short;
                    break;
                case 5:
                    day = this.trs.Friday_short;
                    break;
                case 6:
                    day = this.trs.saturday_short;
                    break;
                default :
                    day = "";
            }

            return day;
        },
        min_seat_calculate(legs) {
            let min_seats_depart = 1000;
            let min_seats_return = 1000;

            legs.forEach(function (leg) {

                if (!leg["is_return"]) {
                    if (leg["seats_remaining"] < min_seats_depart) {
                        min_seats_depart = leg["seats_remaining"];
                    }
                } else {
                    if (leg["seats_remaining"] < min_seats_return) {
                        min_seats_return = leg["seats_remaining"];
                    }
                }
            });

            return [min_seats_depart, min_seats_return];
        },
        searchFlight() {
            this.ajax_render.forEach((render) => {

                const headers = {
                    'X-CSRF-TOKEN': this.csrf
                };
                const data = {
                    'render': render,
                    'search_id': this.search_data.search_id,
                    'lang': this.lang,
                    'filter': this.filter,
                };
                axios.post(this.flight_search_url, data, {headers})
                    .then(response => {
                        if (response.data.status === 0) {
                            this.flights = response.data.flights;
                            this.airlines_list = response.data.airlines_list;
                            this.flight_grouped = response.data.flight_grouped;
                            this.airlines = response.data.airlines;
                            this.ValidatingAirlineCode.push(...this.airlines.map(item => item.code));
                            this.all_ValidatingAirlineCode = this.ValidatingAirlineCode;
                            this.slider.range.max = response.data.max;
                            this.nouislidefilter_init();
                        } else {
                        }
                    });

            });
        },
        airline_counter1Add() {
            this.airline_counter1 = 1;
        },
        airline_counter2Add() {
            this.airline_counter2 = this.airline_counter1 + 1;
        },
        collapse(index) {
            let flight = '#flight_details' + index;
            let pricec = '#price_details' + index;
            if (this.collapse_array.includes(index)) {
                this.collapse_array = this.collapse_array.filter(item => item !== index);
                $(flight).collapse('hide');
            } else {
                this.collapse_array.push(index);
                this.collapse_price_array = this.collapse_price_array.filter(item => item !== index);
                $(flight).collapse('show');
                $(pricec).collapse('hide');
            }
        },
        collapse_price(index) {
            let flight = '#flight_details' + index;
            let pricec = '#price_details' + index;
            if (this.collapse_price_array.includes(index)) {
                this.collapse_price_array = this.collapse_price_array.filter(item => item !== index);
                $(pricec).collapse('hide');
            } else {
                this.collapse_price_array.push(index);
                this.collapse_array = this.collapse_array.filter(item => item !== index);
                $(pricec).collapse('show');
                $(flight).collapse('hide');
            }
        },
        ticket_rule(id) {
            const headers = {
                'X-CSRF-TOKEN': this.csrf
            };
            const data = {
                'id': id,
            };
            axios.post(this.air_rules_url, data, {headers})
                .then(response => {
                    if (response.data.status === 0) {
                        this.rules = response.data.rules;
                        $('#rules_modal').modal('show');
                    } else {
                    }
                });
        },
        bar_rule(id) {
            const headers = {
                'X-CSRF-TOKEN': this.csrf
            };
            const data = {
                'id': id,
            };
            axios.post(this.air_bag_url, data, {headers})
                .then(response => {
                    if (response.data.status === 0) {
                        this.bagRules = response.data.rules;
                        $('#baggage_modal').modal('show');
                    } else {
                    }
                });
        },
        handleAll(widget) {
            if (this[widget].includes('ALL')) {
                this[widget] = this['all_' + widget];
            } else {
                this[widget] = []
            }
        },
        removeAll(widget) {
            let x = this['all_' + widget].filter(item => item !== 'ALL')
            if (x.every(r => this[widget].includes(r))) {
                this[widget].push('ALL');
            } else {
                this[widget] = this[widget].filter(item => item !== 'ALL');
            }
        },
        nouislidefilter_init() {
            this.rangeSlider = document.getElementById("slide_filter1");

            noUiSlider.create(this.rangeSlider, {
                start: this.slider.start,
                direction: this.slider.direction,
                connect: this.slider.connect,
                step: this.slider.step,
                range: this.slider.range
            });

            var vm = this
            this.rangeSlider.noUiSlider.on('update', function (values, handle) {
                var start_hour = parseInt(values[0] / 60);
                var start_min = parseInt(values[0] % 60);
                var end_hour = parseInt(values[1] / 60);
                var end_min = parseInt(values[1] % 60);
                if (start_hour < 10) start_hour = "0" + start_hour;
                if (start_min < 10) start_min = "0" + start_min;
                if (end_hour < 10) end_hour = "0" + end_hour;
                if (end_min < 10) end_min = "0" + end_min;
                vm.slider.text = start_hour + ":" + start_min + " - " + end_hour + ":" + end_min;

            });
            this.rangeSlider.noUiSlider.on('set', function (values, handle) {
                var start_min = values[0];
                var end_min = values[1];
                vm.slider.start = [start_min, end_min];
            });

        },
        changeOrder(order) {
            this.order_active = order;
            if (order == 0) {
                this.order = ['TotalFare', 'depart_time', 'depart_return_time', 'total', 'return_total'];
            } else if (order == 1) {
                this.order = ['depart_return_time', 'TotalFare', 'depart_time', 'total', 'return_total'];
            } else if (order == 2) {
                this.order = ['total', 'TotalFare', 'depart_time', 'depart_return_time', 'return_total'];
            } else if (order == 3) {
                this.order = ['return_total', 'TotalFare', 'depart_time', 'depart_return_time', 'total'];
            }
        },
        only(widget, target) {
            this[widget] = [target];
        }
    },
    data() {
        return {
            'airline_counter0': 0,
            'airline_counter1': 0,
            'airline_counter2': 0,
            'date_option': {year: 'numeric', month: 'numeric', day: 'numeric'},
            'time_option': {hour: 'numeric', minute: 'numeric'},
            'city': "city_" + this.lang,
            'flights': [],
            'airlines_list': null,
            'flight_grouped': [],
            'collapse_array': [],
            'collapse_price_array': [],
            'airlines': [],
            'rules': null,
            'bagRules': null,
            'all_stops': ['0', '1', '2', 'ALL'],
            'stops': [],
            'all_bar_exist': ['0', '1'],
            'bar_exist': [],
            'depart_time_range': ['0', '1', '2', '3', 'ALL'],
            'all_depart_time_range': ['0', '1', '2', '3', 'ALL'],
            'all_return_depart_time_range': ['0', '1', '2', '3', 'ALL'],
            'return_depart_time_range': ['0', '1', '2', '3', 'ALL'],
            'all_ValidatingAirlineCode': ['ALL'],
            'ValidatingAirlineCode': ['ALL'],
            'slider': {
                start: [this.filter['wait0'] ? this.filter['wait0'] : 0, this.filter['wait1'] ? this.filter['wait1'] : 1200],
                direction: this.lang == "fa" ? 'rtl' : 'ltr',
                connect: true,
                step: 30,
                range: {
                    'min': 0, 'max': 1200
                },
                text: ""
            },
            'rangeSlider': null,
            'order': ['TotalFare', 'depart_time', 'depart_return_time', 'total', 'return_total'],
            'order_active': 0
        }
    },
    computed: {
        resultQuery() {
            return this.flights.filter(item => {
                return this.stops.includes(String(item.stops))
                    && this.bar_exist.includes(String(item.bar_exist))
                    && this.depart_time_range.includes(String(item.depart_time_range))
                    && this.return_depart_time_range.includes(String(item.return_depart_time_range))
                    && this.ValidatingAirlineCode.includes(item.ValidatingAirlineCode)
                    && this.slider.start[0] <= item.total_waiting
                    && this.slider.start[1] >= item.total_waiting;
            }).sort((a, b) => {
                if (a.ValidatingAirlineCode == 'IR') {
                    return -1;
                } else if (b.ValidatingAirlineCode == 'IR') {
                    return 1;
                }
                for (let i = 0; i < this.order.length; i++) {
                    let item = this.order[i];
                    let x, y;
                    if (item == "total") {
                        x = a['total_time'] + a['total_waiting'];
                        y = b['total_time'] + b['total_waiting'];
                    } else if (item == "return_total") {
                        x = a['return_total_time'] + a['return_total_waiting'];
                        y = b['return_total_time'] + b['return_total_waiting'];
                    } else {
                        x = a[item];
                        y = b[item];
                    }
                    console.log(item);


                    if (x > y) {
                        return 1;
                    } else if (x < y) {
                        return -1;
                    }
                }
            })
        },
    },
}

</script>

