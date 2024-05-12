<template>
    <div class="flight_page_container ">
        <div class="row margin-right-0px margin-left-0px">

            <div class="col-12">
                <div class="flights_container">

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
                            <div>
                                <div class="flight_container filter_class padding-0px margin-bottom-0px">
                                    <div class="flight-post with-hover box-shadow-hover"
                                         :class="this.collapse_array.includes(0) || this.collapse_price_array.includes(0) ? 'f_p_active_bxs' : ''">

                                        <div class="flight_post_container">
                                            <div class="row">

                                                <div class="col-12 col-md-10">

                                                    <div class="details_link" data-toggle="collapse"
                                                         role="button"
                                                         @click="this.collapse(0)"
                                                         aria-expanded="false">
                                                        <div class="row d-md-none">
                                                            <div class="flight_item logo_container col-4 ">

                                                                <div
                                                                    v-for="logo in getDistinctAirline(flight.airlines).filter(i => i.is_return === 0)"
                                                                    class="logo_leg">
                                                                    <img :src="'images/'+logo.image"
                                                                         :alt="logo.name">
                                                                </div>


                                                                <div v-if="!flight.airlines" class="logo_leg">
                                                                    <img src="images/AirlineLogo/default.png">
                                                                </div>

                                                            </div>
                                                            <div class="col-4 flight_item ">
                                                                <div class="top_item f_t_time">
                                                            <span>
                                                                {{ flight.flight_number }}
                                                            </span>
                                                                </div>
                                                                <div class="bot_item">
                                                            <span>
                                                                {{ turn_class(flight.class) }}/{{ flight.class_code }}
                                                            </span>
                                                                </div>

                                                                <div v-if="!flight.stops" class="text-black">
                                                            <span class="aircraft_name">
                                                                {{ flight.legs[0].aircraft_type }}
                                                                <i class="fas fa-info-circle"></i>
                                                                <span class="aircraft_description">
                                                                    {{ flight.legs[0].aircraft_type_description }}
                                                                </span>
                                                            </span>
                                                                </div>

                                                            </div>
                                                            <div class="flight_item col-4 deal_button_md_d">
                                                                <span>{{
                                                                        this.my_number_format(flight.TotalFare)
                                                                    }} €</span>

                                                                <i class="fas fa-long-arrow-alt-right"></i>
                                                            </div>
                                                        </div>

                                                        <div class="depart_section"
                                                             :class="flight.DirectionInd==1 ? 'border-bottom-0 padding-bottom-0px-imp' : ''">
                                                            <div class="row">

                                                                <div
                                                                    class="flight_item logo_container col d-md-block d-none">


                                                                    <div
                                                                        v-for="logo in getDistinctAirline(flight.airlines).filter(i => i.is_return == 0)"

                                                                        class="logo_leg">
                                                                        <img :src="'images/'+logo.image"
                                                                             :alt="logo.name">
                                                                    </div>

                                                                    <div v-if="!flight.airlines" class="logo_leg">
                                                                        <img src="images/AirlineLogo/default.png">
                                                                    </div>
                                                                </div>

                                                                <div class="flight_item col d-md-block d-none">

                                                                    <div class="top_item f_t_time">
                                                                <span>
                                                                    {{ flight.flight_number }}
                                                                </span>
                                                                    </div>
                                                                    <div class="bot_item">
                                                                <span>
                                                                    {{ this.turn_class(flight.class) }}/{{
                                                                        flight.class_code
                                                                    }}
                                                                </span>
                                                                    </div>

                                                                    <div v-if="!flight.stops" class="text-black">
                                                                    <span class="aircraft_name">
                                                                        {{ flight.legs[0].aircraft_type }}
                                                                        <i class="fas fa-info-circle"></i>
                                                                        <span class="aircraft_description">
                                                                            {{
                                                                                flight.legs[0].aircraft_type_description
                                                                            }}
                                                                        </span>
                                                                    </span>
                                                                    </div>
                                                                </div>

                                                                <div class="flight_item col">

                                                                    <div class="top_item f_t_time">
                                                                    <span>
                                                                        {{
                                                                            new Date(flight.depart_time).toLocaleString('de-DE', this.time_option)
                                                                        }}
                                                                    </span>
                                                                    </div>
                                                                    <div class="bot_item">
                                                                    <span v-if="flight.airports1">
                                                                        {{
                                                                            flight.airports1[this.city] != "" ? flight.airports1[this.city] : flight.airports1.city_en
                                                                        }}
                                                                        -{{
                                                                            flight.airports1.code != "" ? flight.airports1.code : flight.depart_airport
                                                                        }}
                                                                    </span>
                                                                        <span v-else>
                                                                        {{ flight.depart_airport }}
                                                                    </span>

                                                                    </div>
                                                                    <div class="date_item">
                                                                    <span>
                                                                        {{
                                                                            this.turn_day_of_week(flight.depart_time)
                                                                        }} {{
                                                                            new Date(flight.depart_time).toLocaleString('de-DE', this.date_option)
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
                                                                            parseInt(flight.total_time / 60) + "h"
                                                                        }}
                                                                        {{
                                                                            flight.total_time % 60 != 0 ? ":" + flight.total_time % 60 + "'" : ""
                                                                        }}
                                                                    </span>

                                                                    </div>
                                                                    <div class="flight_duration_md">
                                                                    <span>
                                                                        {{
                                                                            flight.stops == 0 ? this.trs.none_stop : (flight.stops == 1 ? flight.stops + " " + this.trs.stop : flight.stops + " " + this.trs.stops_in_Counting)
                                                                        }}

                                                                        <span class="flight_duration_md_waiting">
                                                                            {{
                                                                                flight.total_waiting == 0 ? "" : (parseInt(flight.total_waiting / 60) + "h")
                                                                            }} {{
                                                                                flight.total_waiting != 0 ? (flight.total_waiting % 60 != 0 ? ":" + flight.total_waiting % 60 + "'" : "") : ""
                                                                            }}{{
                                                                                flight.total_waiting == 0 ? "" : " waiting"
                                                                            }}
                                                                        </span>
                                                                    </span>
                                                                    </div>

                                                                    <div class="flight_duration_md">

                                                                        <div v-if="min_seat_calculate(flight.legs)[0]"
                                                                             class="flight_seats_price_deal">
                                                                        <span
                                                                            :class="min_seat_calculate(flight.legs)[0]==search_data.adl+search_data.chl ? 'text-red' :'' ">
                                                                        <img src="images/icon/flight-seat.png"
                                                                             class="flight_seat_image"> {{
                                                                                min_seat_calculate(flight.legs)[0]
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
                                                                            new Date(flight.arrival_time).toLocaleString('de-DE', this.time_option)
                                                                        }}
                                                                    </span>
                                                                    </div>
                                                                    <div class="bot_item">
                                                                    <span v-if="flight.airports2">
                                                                        {{
                                                                            flight.airports2[this.city] != "" ? flight.airports2[this.city] : flight.airports2.city_en
                                                                        }}
                                                                        -{{
                                                                            flight.airports2.code != "" ? flight.airports2.code : flight.arrival_airport
                                                                        }}
                                                                    </span>
                                                                        <span v-else>
                                                                        {{ flight.arrival_airport }}
                                                                    </span>

                                                                    </div>
                                                                    <div class="date_item">
                                                                    <span>
                                                                        {{
                                                                            this.turn_day_of_week(flight.arrival_time)
                                                                        }} {{
                                                                            new Date(flight.arrival_time).toLocaleString('de-DE', this.date_option)
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
                                                                                    parseInt(flight.total_time / 60) + "h"
                                                                                }}
                                                                                {{
                                                                                    flight.total_time % 60 != 0 ? ":" + flight.total_time % 60 + "'" : ""
                                                                                }}
                                                                            </span>
                                                                            </div>
                                                                            <div class="bot_item">
                                                                            <span>
                                                                                {{
                                                                                    flight.stops == 0 ? this.trs.none_stop : (flight.stops == 1 ? flight.stops + " " + this.trs.stop : flight.stops + " " + this.trs.stops_in_Counting)
                                                                                }}
                                                                            </span>
                                                                            </div>

                                                                            <div
                                                                                v-if="min_seat_calculate(flight.legs)[0]"
                                                                                class="flight_seats_price_deal">
                                                                            <span
                                                                                :class="min_seat_calculate(flight.legs)[0]==search_data.adl+search_data.chl ? 'text-red' :'' ">
                                                                                <img src="images/icon/flight-seat.png"
                                                                                     class="flight_seat_image">
                                                                                {{
                                                                                    min_seat_calculate(flight.legs)[0]
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
                                                                                    flight.total_waiting == 0 ? "" : (parseInt(flight.total_waiting / 60) + "h")
                                                                                }} {{
                                                                                    flight.total_waiting != 0 ? (flight.total_waiting % 60 != 0 ? ":" + flight.total_waiting % 60 + "'" : "") : ""
                                                                                }}
                                                                            </span>
                                                                            </div>


                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--                                                    return section-->

                                                        <div v-if="flight.DirectionInd==2">
                                                            <div class="row d-md-none">
                                                                <div class="flight_item logo_container col-4 ">


                                                                    <div
                                                                        v-for="logo in getDistinctAirline(flight.airlines).filter(i => i.is_return === 1)"
                                                                        class="logo_leg">
                                                                        <img :src="'images/'+logo.image"
                                                                             :alt="logo.name">
                                                                    </div>


                                                                    <div v-if="!flight.airlines" class="logo_leg">
                                                                        <img src="images/AirlineLogo/default.png">
                                                                    </div>

                                                                </div>
                                                                <div class="col-4 flight_item ">
                                                                    <div class="top_item f_t_time">
                                                                <span>
                                                                    {{ flight.return_flight_number }}
                                                                </span>
                                                                    </div>
                                                                    <div class="bot_item">
                                                                <span>
                                                                    {{ this.turn_class(flight.return_class) }}/{{
                                                                        flight.return_class_code
                                                                    }}
                                                                </span>
                                                                    </div>

                                                                    <div v-if="!flight.return_stops"
                                                                         class="text-black">
                                                                    <span class="aircraft_name">
                                                                        {{
                                                                            flight.legs[flight.legs.length - 1].aircraft_type
                                                                        }}
                                                                        <i class="fas fa-info-circle"></i>
                                                                        <span class="aircraft_description">
                                                                            {{
                                                                                flight.legs[flight.legs.length - 1].aircraft_type_description
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
                                                                            v-for="logo in getDistinctAirline(flight.airlines).filter(i => i.is_return === 1)"
                                                                            class="logo_leg">
                                                                            <img :src="'images/'+logo.image"
                                                                                 :alt="logo.name">
                                                                        </div>


                                                                        <div v-if="!flight.airlines" class="logo_leg">
                                                                            <img
                                                                                src="images/AirlineLogo/default.png">
                                                                        </div>

                                                                    </div>
                                                                    <div class="flight_item col d-md-block d-none ">
                                                                        <div class="top_item f_t_time">
                                                                    <span>
                                                                        {{ flight.return_flight_number }}
                                                                    </span>
                                                                        </div>
                                                                        <div class="bot_item">
                                                                    <span>
                                                                        {{
                                                                            this.turn_class(flight.return_class)
                                                                        }}/{{ flight.return_class_code }}
                                                                    </span>
                                                                        </div>

                                                                        <div v-if="!flight.return_stops"
                                                                             class="text-black">
                                                                    <span class="aircraft_name">
                                                                        {{
                                                                            flight.legs[flight.legs.length - 1].aircraft_type
                                                                        }}
                                                                        <i class="fas fa-info-circle"></i>
                                                                        <span class="aircraft_description">
                                                                            {{
                                                                                flight.legs[flight.legs.length - 1].aircraft_type_description
                                                                            }}
                                                                        </span>
                                                                    </span>
                                                                        </div>

                                                                    </div>

                                                                    <div class="flight_item col">

                                                                        <div class="top_item f_t_time">
                                                                    <span>
                                                                        {{
                                                                            new Date(flight.return_depart_time).toLocaleString('de-DE', this.time_option)
                                                                        }}
                                                                    </span>

                                                                        </div>
                                                                        <div class="bot_item">
                                                                    <span v-if="flight.airports3">
                                                                        {{
                                                                            flight.airports3[this.city] != "" ? flight.airports3[this.city] : flight.airports3.city_en
                                                                        }}
                                                                        -{{
                                                                            flight.airports3.code != "" ? flight.airports3.code : flight.return_depart_airport
                                                                        }}
                                                                    </span>
                                                                            <span v-else>
                                                                        {{ flight.return_depart_airport }}
                                                                    </span>


                                                                        </div>
                                                                        <div class="date_item">
                                                                    <span>
                                                                        {{
                                                                            this.turn_day_of_week(flight.return_depart_time)
                                                                        }} {{
                                                                            new Date(flight.return_depart_time).toLocaleString('de-DE', this.date_option)
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
                                                                            parseInt(flight.return_total_time / 60) + "h"
                                                                        }}
                                                                        {{
                                                                            flight.return_total_time % 60 != 0 ? ":" + flight.return_total_time % 60 + "'" : ""
                                                                        }}
                                                                    </span>

                                                                        </div>
                                                                        <div class="flight_duration_md">
                                                                            <span>
                                                                                {{
                                                                                    flight.return_stops == 0 ? this.trs.none_stop : (flight.return_stops == 1 ? flight.return_stops + " " + this.trs.stop : flight.return_stops + " " + this.trs.stops_in_Counting)
                                                                                }}
                                                                                <span
                                                                                    class="flight_duration_md_waiting">
                                                                                    {{
                                                                                        flight.return_total_waiting == 0 ? "" : (parseInt(flight.return_total_waiting / 60) + "h")
                                                                                    }}{{
                                                                                        flight.return_total_waiting != 0 ? (flight.return_total_waiting % 60 != 0 ? ":" + flight.return_total_waiting % 60 + "'" : "") : ""
                                                                                    }}
                                                                                    {{
                                                                                        flight.return_total_waiting == 0 ? "" : " waiting"
                                                                                    }}
                                                                        </span>
                                                                    </span>
                                                                        </div>
                                                                        <div class="flight_duration_md">

                                                                            <div
                                                                                v-if="min_seat_calculate(flight.legs)[1]"
                                                                                class="flight_seats_price_deal">
                                                                            <span
                                                                                :class="min_seat_calculate(flight.legs)[1]==search_data.adl+search_data.chl ? 'text-red' :'' ">
                                                                                <img src="images/icon/flight-seat.png"
                                                                                     class="flight_seat_image">
                                                                                {{
                                                                                    min_seat_calculate(flight.legs)[1]
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
                                                                            new Date(flight.return_arrival_time).toLocaleString('de-DE', this.time_option)
                                                                        }}
                                                                    </span>
                                                                        </div>
                                                                        <div class="bot_item">
                                                                    <span v-if="flight.airports4">
                                                                        {{
                                                                            flight.airports4[this.city] != "" ? flight.airports4[this.city] : flight.airports4.city_en
                                                                        }}
                                                                        -{{
                                                                            flight.airports4.code != "" ? flight.airports4.code : flight.return_arrival_airport
                                                                        }}
                                                                    </span>
                                                                            <span v-else>
                                                                        {{ flight.return_arrival_airport }}
                                                                    </span>

                                                                        </div>
                                                                        <div class="date_item">
                                                                    <span>
                                                                        {{
                                                                            this.turn_day_of_week(flight.return_arrival_time)
                                                                        }} {{
                                                                            new Date(flight.return_arrival_time).toLocaleString('de-DE', this.date_option)
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
                                                                                    parseInt(flight.return_total_time / 60) + "h"
                                                                                }}
                                                                                {{
                                                                                    flight.return_total_time % 60 != 0 ? ":" + flight.return_total_time % 60 + "'" : ""
                                                                                }}
                                                                            </span>
                                                                                </div>
                                                                                <div class="bot_item">
                                                                            <span>
                                                                                {{
                                                                                    flight.return_stops == 0 ? this.trs.none_stop : (flight.return_stops == 1 ? flight.return_stops + " " + this.trs.stop : flight.return_stops + " " + this.trs.stops_in_Counting)
                                                                                }}
                                                                            </span>
                                                                                </div>
                                                                                <div
                                                                                    v-if="min_seat_calculate(flight.legs)[1]"
                                                                                    class="flight_seats_price_deal">
                                                                            <span
                                                                                :class="min_seat_calculate(flight.legs)[1]==search_data.adl+search_data.chl ? 'text-red' :'' ">
                                                                                <img src="images/icon/flight-seat.png"
                                                                                     class="flight_seat_image">
                                                                                {{
                                                                                    min_seat_calculate(flight.legs)[1]
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
                                                                                    flight.return_total_waiting == 0 ? "" : (parseInt(flight.return_total_waiting / 60) + "h")
                                                                                }} {{
                                                                                    flight.return_total_waiting != 0 ? (flight.return_total_waiting % 60 != 0 ? ":" + flight.return_total_waiting % 60 + "'" : "") : ""
                                                                                }}
                                                                            </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>


                                                        <div v-if="flight.DirectionInd==4">
                                                            <div v-for="multi in flight.multi_flights">
                                                                <div class="row d-md-none">

                                                                    <div class="flight_item logo_container col-4 ">


                                                                        <div
                                                                            v-for="logo in getDistinctAirline(multi.airlines)"
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
                                                                                v-for="logo in getDistinctAirline(multi.airlines)"
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
                                                                        {{
                                                                            new Date(multi.depart_time).toLocaleString('de-DE', this.time_option)
                                                                        }}
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
                                                                            parseInt(multi.total_time / 60) + "h"
                                                                        }}
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
                                                                                multi.total_waiting == 0 ? "" : (parseInt(multi.total_waiting / 60) + "h")
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
                                                                                    parseInt(multi.total_time / 60) + "h"
                                                                                }}
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
                                                                                    multi.total_waiting == 0 ? "" : (parseInt(multi.total_waiting / 60) + "h")
                                                                                }} {{
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
                                                                      @click="this.collapse(0)"
                                                                      aria-controls="collapseExample">
                                                                <span class="all_details_link">
                                                                    <i class="fas fa-info-circle"></i>
                                                                    <div
                                                                        class="flight_details_detail_link display-inline"
                                                                        :class="this.collapse_array.includes(0) ?'details_link_active' : ''">
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
                                                                      @click="this.collapse_price(0)"
                                                                      aria-expanded="false"
                                                                      aria-controls="collapseExample">
                                                                <span class="all_details_link">
                                                                    <i class="fas fa-money-bill"></i>
                                                                    <div
                                                                        class="price_details_detail_link display-inline"
                                                                        :class="this.collapse_price_array.includes(0) ?'details_link_active' : ''">
                                                                        <span
                                                                            class="d-none d-md-inline">{{
                                                                                this.trs.price
                                                                            }}</span>
                                                                    </div>
                                                                </span></span>
                                                            </div>
                                                            <div>
                                                                <span class="all_details_link"
                                                                      @click="this.bar_rule(flight)">
                                                                    <span v-if="!flight.bar_exist">
                                                                        <i><img
                                                                            src="images/icon/suitcase-solid.png"></i>
                                                                        <span
                                                                            v-if="flight.return_bar_exist && flight.DirectionInd==2">
                                                                            / <i class="fas fa-suitcase "></i>
                                                                            <span class="d-none d-md-inline">{{
                                                                                    flight.return_bar
                                                                                }}</span>
                                                                        </span>
                                                                    </span>
                                                                    <div v-else>
                                                                        <i class="fas fa-suitcase "></i>
                                                                        <span class="d-md-inline">{{ flight.bar }}
                                                                            <i v-if="!flight.return_bar_exist && flight.DirectionInd==2">/
                                                                                <img
                                                                                    src="images/icon/suitcase-solid.png"></i>
                                                                            <i v-else>{{
                                                                                    flight.bar != flight.return_bar && flight.return_bar != "" ? "/" + flight.return_bar : ""
                                                                                }}</i>
                                                                        </span>
                                                                    </div>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span class="all_details_link"
                                                                      @click="this.ticket_rule(flight)">
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
                                                         :class="flight.DirectionInd!=1 ? 'return_deal_bottom' : 'single_deal_bottom'">
                                                        <div class="deal_price_total">
                                                            <span>{{ this.my_number_format(flight.TotalFare) }} €</span>
                                                        </div>

                                                        <div v-if="flight.TotalFare!=flight.FarePerAdult"
                                                             class="deal_price_detail">
                                                        <span>{{
                                                                Math.round(flight.FarePerAdult)
                                                            }} € {{ this.trs["p.a"] }}</span>
                                                        </div>

                                                        <div class="deal_section_baggage_container">
                                                        <span class="deal_section_baggage" id="baggage_rules">
                                                            <span v-if="!flight.bar_exist">
                                                                <i><img src="images/icon/suitcase-solid.png"></i>
                                                                <span
                                                                    v-if="flight.return_bar_exist && flight.DirectionInd==2">
                                                                    / <i class="fas fa-suitcase "></i>
                                                                    <span class="d-none d-md-inline">{{
                                                                            flight.return_bar
                                                                        }}</span>
                                                                </span>
                                                            </span>
                                                            <span v-else>
                                                                <i class="fas fa-suitcase "></i>
                                                                <span class="d-none d-md-inline">{{ flight.bar }}
                                                                    <span
                                                                        v-if="!flight.return_bar_exist && flight.DirectionInd==2">
                                                                        / <i> <img src="images/icon/suitcase-solid.png"></i>
                                                                    </span>
                                                                    <i v-else>
                                                                        {{
                                                                            flight.bar != flight.return_bar && flight.return_bar != "" ? "/" + flight.return_bar : ""
                                                                        }}
                                                                    </i>
                                                                </span>
                                                            </span>
                                                        </span>
                                                        </div>

                                                        <div
                                                            v-if="!flight.bar_exist || (flight.DirectionInd==2 && !flight.return_bar_exist)"
                                                            class="deal_section_baggage_alert">
                                                        <span>
                                                            {{
                                                                (!flight.bar_exist && !flight.return_bar_exist) ? this.trs.no_baggage : (!flight.bar_exist ? this.trs.no_baggage_depart : this.trs.no_baggage_return)
                                                            }}
                                                        </span>
                                                        </div>


                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                        <!--                                    details section-->
                                        <div class="collapse flight_details_container" id="flight_details">
                                            <!--                                    depart details-->

                                            <div class="details_content">

                                                <div class="details_header">
                                                    <div class="row">

                                                        <div class="col-10 col-md-6 details_title">
                                                        <span class="details_title_way">
                                                            {{
                                                                flight.DirectionInd == 4 ? this.trs.trip + ' 1' : this.trs.depart
                                                            }}
                                                        </span>
                                                            <span class="details_title_f_t">
                                                            {{
                                                                    (flight.airports1 ? flight.airports1.name : flight.depart_airport) + "-" + (flight.airports2 ? flight.airports2.name : flight.arrival_airport)
                                                                }}
                                                        </span>
                                                        </div>
                                                        <div class="col-2 col-md-6 details_time">
                                                        <span>{{ parseInt(flight.total_time / 60) + "h" }}{{
                                                                flight.total_time % 60 != 0 ? ":" + flight.total_time % 60 + "'" : ""
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


                                                    <div v-for="leg in flight.legs.filter(i => i.is_return === 0)"
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
                                                                        leg.leg_waiting == 0 ? "" : (parseInt(leg.leg_waiting / 60) + "h")
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
                                                                                leg.leg_waiting == 0 ? "" : (parseInt(leg.leg_waiting / 60) + "h")
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
                                            <div v-if="flight.DirectionInd==2" class="details_content">

                                                <div class="details_header">
                                                    <div class="row">

                                                        <div class="col-10 col-md-6 details_title">
                                                                <span class="details_title_way">{{
                                                                        this.trs.return
                                                                    }}</span>
                                                            <span class="details_title_f_t">
                                                            {{
                                                                    (flight.airports3 ? flight.airports3.name : flight.return_depart_airport) + "-" + (flight.airports4 ? flight.airports4.name : flight.return_arrival_airport)
                                                                }}
                                                        </span>

                                                        </div>
                                                        <div class="col-2 col-md-6 details_time text-right">
                                                        <span>
                                                           {{
                                                                parseInt(flight.return_total_time / 60) + "h"
                                                            }}
                                                            {{
                                                                flight.return_total_time % 60 != 0 ? ":" + flight.return_total_time % 60 + "'" : ""
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
                                                    <div v-for="leg in flight.legs.filter(i => i.is_return === 1)"
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
                                                                        leg.leg_waiting == 0 ? "" : (parseInt(leg.leg_waiting / 60) + "h")
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
                                                                                leg.leg_waiting == 0 ? "" : (parseInt(leg.leg_waiting / 60) + "h")
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


                                            <div v-if="flight.DirectionInd==4"
                                                 v-for="(multi,key) in flight.multi_flights"
                                                 class="details_content">

                                                <div class="details_header">
                                                    <div class="row">

                                                        <div class="col-10 col-md-6 details_title">
                                                        <span class="details_title_way">{{ this.trs.trip }} {{
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
                                                                parseInt(flight.total_time / 60) + "h"
                                                            }}
                                                            {{
                                                                flight.total_time % 60 != 0 ? ":" + flight.total_time % 60 + "'" : ""
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
                                                                        leg.leg_waiting == 0 ? "" : (parseInt(leg.leg_waiting / 60) + "h")
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
                                                                                leg.leg_waiting == 0 ? "" : (parseInt(leg.leg_waiting / 60) + "h")
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
                                        <div class="collapse" id="price_details">
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

                                                            <tr v-if="flight.adult">
                                                                <td>{{ this.trs.adult }}</td>

                                                                <td>{{
                                                                        this.my_number_format(flight.FarePerAdult)
                                                                    }}
                                                                </td>
                                                                <td>{{
                                                                        this.my_number_format(flight.FarePerAdult - flight.taxAdult - flight.serviceAdult)
                                                                    }}
                                                                </td>
                                                                <td>{{
                                                                        this.my_number_format(flight.taxAdult + flight.serviceAdult)
                                                                    }}
                                                                </td>

                                                                <td>{{ flight.adult }}</td>
                                                                <td>{{
                                                                        this.my_number_format(flight.FarePerAdult * flight.adult)
                                                                    }}
                                                                </td>
                                                            </tr>


                                                            <tr v-if="flight.child">
                                                                <td>{{ this.trs.child }}</td>
                                                                <td>{{
                                                                        this.my_number_format(flight.FarePerChild)
                                                                    }}
                                                                </td>
                                                                <td>{{
                                                                        this.my_number_format(flight.FarePerChild - flight.taxChild - flight.serviceChild)
                                                                    }}
                                                                </td>
                                                                <td>{{
                                                                        this.my_number_format(flight.taxChild + flight.serviceChild)
                                                                    }}
                                                                </td>

                                                                <td>{{ flight.child }}</td>
                                                                <td>{{
                                                                        this.my_number_format(flight.FarePerChild * flight.child)
                                                                    }}
                                                                </td>
                                                            </tr>


                                                            <tr v-if="flight.infant">
                                                                <td>{{ this.trs.infant }}</td>
                                                                <td>{{ this.my_number_format(flight.FarePerInf) }}</td>
                                                                <td>{{
                                                                        this.my_number_format(flight.FarePerInf - flight.taxInfant - flight.serviceInfant)
                                                                    }}
                                                                </td>
                                                                <td>{{
                                                                        this.my_number_format(flight.taxInfant + flight.serviceInfant)
                                                                    }}
                                                                </td>
                                                                <td>{{ flight.infant }}</td>
                                                                <td>{{
                                                                        this.my_number_format(flight.FarePerInf * flight.infant)
                                                                    }}
                                                                </td>
                                                            </tr>

                                                            <tr class="total_price_tax">
                                                                <td>{{ this.trs.total_price }}</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>{{
                                                                        this.my_number_format(flight.FarePerAdult * flight.adult + (flight.child ? flight.FarePerChild * flight.child : 0) + (flight.infant ? flight.FarePerInf * flight.infant : 0))
                                                                    }} €
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

export default {

    mounted() {
    },
    created() {
    },
    directives: {},
    props: ['lang', 'trs', 'csrf', 'air_rules_url', 'air_bag_url', 'flight', 'search_data'],
    name: 'singleFlight',
    methods: {
        getDistinctAirline(array) {

            return [...new Map(array.map(item => [item['id'] + 'r' + item['is_return'], item])).values()];

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
        collapse(index) {
            let flight = '#flight_details';
            let price = '#price_details';
            if (this.collapse_array.includes(index)) {
                this.collapse_array = this.collapse_array.filter(item => item !== index);
                $(flight).collapse('hide');
            } else {
                this.collapse_array.push(index);
                this.collapse_price_array = this.collapse_price_array.filter(item => item !== index);
                $(flight).collapse('show');
                $(price).collapse('hide');
            }
        },
        collapse_price(index) {
            let flight = '#flight_details';
            let price = '#price_details';
            if (this.collapse_price_array.includes(index)) {
                this.collapse_price_array = this.collapse_price_array.filter(item => item !== index);
                $(price).collapse('hide');
            } else {
                this.collapse_price_array.push(index);
                this.collapse_array = this.collapse_array.filter(item => item !== index);
                $(price).collapse('show');
                $(flight).collapse('hide');
            }
        },
        ticket_rule(flight) {
            const headers = {
                'X-CSRF-TOKEN': this.csrf
            };
            const data = {
                'flight': flight,
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
        bar_rule(flight) {
            const headers = {
                'X-CSRF-TOKEN': this.csrf
            };
            const data = {
                'flight': flight,
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
        my_number_format(number) {
            return Intl.NumberFormat("en-US", {maximumFractionDigits: 1}).format(Number(number).toFixed(1));
        },
    },
    data() {
        return {
            'date_option': {year: 'numeric', month: 'numeric', day: 'numeric'},
            'time_option': {hour: 'numeric', minute: 'numeric'},
            'city': "city_" + this.lang,
            'collapse_array': [],
            'collapse_price_array': [],
            'rules': null,
            'bagRules': null,
        }
    },
    computed: {},
}

</script>

