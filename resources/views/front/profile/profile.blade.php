@extends('layouts.front')

@section('content')

    <div class="profile_page_container">


        <div class="row">


            <div class="col-lg-3 col-12">

                <div class="profile_sidebar_container">


                    <div class="profile_sidebar_content">


                        <ul>


                            <li class="tablinks {{session('action')!="info" ? "active" : ""}}" data-target="order"><i
                                        class="fas fa-clipboard-list"></i>
                                @lang('trs.book_history')
                            </li>
                            <li class="tablinks" data-target="unsuccess_order"><i
                                        class="fas fa-clipboard-list"></i>
                                @lang('trs.unseccess_book_history')
                            </li>
                            <li class="tablinks" data-target="cip"><i class="fas fa-clipboard-list"></i>
                                @lang('trs.cip_book_history')
                            </li>
                            <li class="tablinks {{session('action')=="info" ? "active" : ""}}"
                                data-target="profile_setting"><i class="fas fa-user"></i>
                                @lang('trs.personal_information')
                            </li>
                            <li class="tablinks" data-target="change_pass">
                                <i class="fas fa-key"></i>
                                @lang('trs.change_pass')
                            </li>


                        </ul>


                    </div>


                </div>


            </div>

            <div class="col-lg-9 col-12 tab_container">


                <div class="profile tabcontent {{session('action')!="info" && session('action')!="pass" ? "active_tabcontent" : ""}}  "
                     id="order">

                    <div class="profile_head">

                        <span>@lang('trs.book_history')</span>

                    </div>

                    <div class="profile_body">


                        <div class="order ">

                            <div class="order_inner">


                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">@lang('trs.flight')</th>
                                        <th scope="col">@lang('trs.booking_number')</th>
                                        <th scope="col">@lang('trs.depart_time') (@lang('trs.return_time'))</th>
                                        <th scope="col">@lang('trs.number_of_passengers')</th>
                                        <th scope="col">@lang('trs.price')(€)</th>
                                        <th scope="col">@lang('trs.booked_date')</th>
                                        <th scope="col">@lang('trs.status')</th>
                                        <th scope="col">@lang('trs.download_ticket')</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($books as $book)

                                        <tr>

                                            <td>{{$book["flights"]["depart_airport"]}}
                                                -{{$book["flights"]["arrival_airport"]}}</td>
                                            <td>{{$book["UniqueId"]}}</td>
                                            <td>
                                                <p> {{date('d.m.Y H:i',strtotime($book["flights"]["depart_time"]))}}</p>
                                                <p>{{$book["flights"]["return_depart_time"] ? "(".date('d.m.Y H:i',strtotime( $book["flights"]["return_depart_time"] )).")" : ""}}</p>
                                            </td>
                                            <td>{{$book["flights"]["costs"]["adult"]+$book["flights"]["costs"]["child"]+$book["flights"]["costs"]["infant"]}}</td>
                                            <td>{{$book["flights"]["costs"]["TotalFare"]}}</td>
                                            <td>
                                                <p>{{date('d.m.Y',strtotime($book["updated_at"]))}}</p>
                                                <p>{{date('H:i',strtotime($book["updated_at"]))}}</p>
                                            </td>
                                            <td>{{$book["status"]=="booked" ? trans('trs.booked') : trans('trs.pending')}}</td>
                                            <td><a href="tickets/{{$book["token"]}}.pdf">@lang('trs.download')</a></td>

                                        </tr>

                                    @endforeach


                                    </tbody>
                                </table>


                            </div>


                        </div>


                    </div>


                </div>

                <div class="profile tabcontent "
                     id="unsuccess_order">

                    <div class="profile_head">

                        <span>@lang('trs.book_history')</span>

                    </div>

                    <div class="profile_body">


                        <div class="order ">

                            <div class="order_inner">


                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">@lang('trs.flight')</th>
                                        <th scope="col">@lang('trs.tracking_number')</th>
                                        <th scope="col">@lang('trs.depart_time') (@lang('trs.return_time'))</th>
                                        <th scope="col">@lang('trs.number_of_passengers')</th>
                                        <th scope="col">@lang('trs.price')(€)</th>
                                        <th scope="col">@lang('trs.status')</th>
                                        <th scope="col">@lang('trs.booked_date')</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($unseccess_books as $book)

                                        <tr>

                                            <td>{{$book["flights"]["depart_airport"]}}
                                                -{{$book["flights"]["arrival_airport"]}}</td>
                                            <td>{{$book["token"]}}</td>
                                            <td>
                                                <p> {{date('d.m.Y H:i',strtotime($book["flights"]["depart_time"]))}}</p>
                                                <p> {{$book["flights"]["arrival_time"] ? "(".date('d.m.Y H:i',strtotime($book["flights"]["arrival_time"])).")" : ""}}</p>
                                            </td>
                                            <td>{{$book["flights"]["costs"]["adult"]+$book["flights"]["costs"]["child"]+$book["flights"]["costs"]["infant"]}}</td>
                                            <td>{{$book["flights"]["costs"]["TotalFare"]}}</td>
                                            <td>{{$book["status"]=="payment_failed" ? trans('trs.payment_failed') : ($book["status"]=="vendor_failed" ? trans('trs.vendor_failed') : ($book["status"]=="vendor_cancelled" ? trans('trs.vendor_cancelled') : trans('trs.unknown'))) }}</td>
                                            <td>
                                                <p>{{date('d.m.Y',strtotime($book["updated_at"]))}}</p>
                                                <p>{{date('H:i',strtotime($book["updated_at"]))}}</p>
                                            </td>
                                        </tr>

                                    @endforeach


                                    </tbody>
                                </table>


                            </div>


                        </div>


                    </div>


                </div>


                <div class="profile tabcontent " id="cip">

                    <div class="profile_head">

                        <span>@lang('trs.cip_book_history')</span>

                    </div>

                    <div class="profile_body">


                        <div class="order ">

                            <div class="order_inner">


                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">@lang('trs.service')</th>
                                        <th scope="col">@lang('trs.airport')</th>
                                        <th scope="col">@lang('trs.E-ticket_number')</th>
                                        <th scope="col">@lang('trs.time')</th>
                                        <th scope="col">@lang('trs.price')(€)</th>
                                        <th scope="col">@lang('trs.download_ticket')</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($cip_books as $cip_book)

                                        <tr>

                                            <td>{{$cip_book["service"]}}</td>
                                            <td>{{$cip_book["cip_airport"]}}</td>
                                            <td>{{$cip_book["ticket_number"]}}</td>
                                            <td>{{$cip_book["date_time"]}}</td>
                                            <td>{{$cip_book["price_e"]}}</td>
                                            <td>
                                                <a href="tickets/cip_tickets/{{$cip_book["ticket_number"]}}.pdf">@lang('trs.download')</a>
                                            </td>

                                        </tr>

                                    @endforeach


                                    </tbody>
                                </table>


                            </div>


                        </div>


                    </div>


                </div>
                <div class="profile tabcontent {{session('action')=="info" ? "active_tabcontent" : ""}}"
                     id="profile_setting">

                    <div class="profile_head">

                        <span>@lang('trs.personal_information')</span>

                    </div>

                    <div class="profile_body">

                        @if(session('info_success_message'))
                            <div class="alert alert-success" role="alert">
                                {{session('info_success_message')}}
                            </div>

                        @elseif(session('info_error_message'))
                            <div class="alert alert-danger" role="alert">
                                {{session('info_error_message')}}
                            </div>

                        @endif
                        <form action="{{route("profile.update_info"). ($lang!="de"? "?lang=".$lang : "")}}"
                              method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="us_i" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                            <div class="user_info">

                                <div class="row">


                                    <div class="col-md-6 col-12">

                                        <div class="item">
                                            <label for="first_name">@lang('trs.first_name') <i class="fas fa-lock"></i></label>
                                            <input type="text" name="fname" id="first_name"
                                                   placeholder="@lang('trs.first_name')" readonly
                                                   value="{{\Illuminate\Support\Facades\Auth::user()->f_name}}">

                                        </div>

                                    </div>
                                    <div class="col-md-6 col-12">

                                        <div class="item">
                                            <label for="last_name">@lang('trs.last_name') <i
                                                        class="fas fa-lock"></i></label>

                                            <input type="text" name="lname" id="last_name"
                                                   placeholder="@lang('trs.last_name')" readonly
                                                   value="{{\Illuminate\Support\Facades\Auth::user()->l_name}}">

                                        </div>

                                    </div>
                                    <div class="col-md-6 col-12">

                                        <div class="item">
                                            <label for="email">@lang('trs.email') <i class="fas fa-lock"></i></label>
                                            <input type="email" name="email" id="email" placeholder="@lang('trs.email')"
                                                   readonly
                                                   value="{{\Illuminate\Support\Facades\Auth::user()->email}}">

                                        </div>

                                    </div>
                                    <div class="col-md-6 col-12">

                                        <div class="item">
                                            <label for="mobile">@lang('trs.phone') <i class="fas fa-edit"></i></label>
                                            <input class="ltr_persian_text_right" type="text" name="mobile" id="mobile"
                                                   placeholder="@lang('trs.phone')"
                                                   value="{{\Illuminate\Support\Facades\Auth::user()->mobile}}">

                                        </div>

                                    </div>
                                    <div class="col-md-6 col-12">

                                        <div class="item">
                                            <label for="gender">@lang('trs.gender') <i class="fas fa-lock"></i></label>
                                            <input type="text" name="gender" id="gender"
                                                   placeholder="@lang('trs.gender')" readonly
                                                   value="{{\App\Services\MyHelperFunction::turn_gender(\Illuminate\Support\Facades\Auth::user()->gender)}}"
                                                   disabled="disabled">

                                        </div>

                                    </div>
                                    <div class="col-md-6 col-12">

                                        <div class="item">
                                            <label for="birthday">@lang('trs.birthday') <i
                                                        class="fas fa-edit"></i></label>
                                            <input class="DOB_date date_latin_font" type="text" name="birthday"
                                                   id="birthday"
                                                   value="{{\Illuminate\Support\Facades\Auth::user()->birthday}}">

                                        </div>

                                    </div>
                                    <div class="col-md-6 col-12 offset-md-3 text-center">
                                        <button type="submit">@lang('trs.submit_change')</button>

                                    </div>


                                </div>


                            </div>


                            {{--                            <div class="profile_setting_submit">--}}

                            {{--                                <button type="submit" name="submit_user_info">@lang('trs.submit_change')</button>--}}

                            {{--                            </div>--}}

                        </form>
                    </div>


                </div>

                <div class="profile tabcontent {{session('action')=="pass" ? "active_tabcontent" : ""}}"
                     id="change_pass">

                    <div class="profile_head">

                        <span>@lang('trs.change_password')</span>

                    </div>

                    <div class="profile_body">

                        @if(session('pass_success_message'))
                            <div class="alert alert-success" role="alert">
                                {{session('pass_success_message')}}
                            </div>

                        @elseif(session('pass_error_message'))
                            <div class="alert alert-danger" role="alert">
                                {{session('pass_error_message')}}
                            </div>

                        @endif

                        <div class="change_password_container">

                            <form method="post" action="{{route('do_reset'). ($lang!="de"? "?lang=".$lang : "")}}"
                                  id="reset_pass_form">
                                {{csrf_field()}}

                                <input type="hidden" name="us_i"
                                       value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                                <input type="hidden" name="hide_email"
                                       value="{{\Illuminate\Support\Facades\Auth::user()->email}}">
                                <div class="row">


                                    <div class="col-md-3 d-none d-md-block"></div>
                                    <div class="col-md-6 col-12 pass_item">
                                        <input type="password" name="password" placeholder="@lang('trs.new_password')">

                                    </div>
                                    <div class="col-md-3 d-none d-md-block"></div>


                                    <div class="col-md-3 d-none d-md-block"></div>
                                    <div class="col-md-6 col-12 pass_item">
                                        <input type="password" name="password_confirmation"
                                               placeholder="@lang('trs.confirm_password')">

                                    </div>
                                    <div class="col-md-3 d-none d-md-block"></div>

                                    <div class="col-md-3 d-none d-md-block"></div>
                                    <div class="col-md-6 col-12 pass_item" id="profile_change_pass_message">

                                    </div>
                                    <div class="col-md-3 d-none d-md-block"></div>

                                    <div class="col-md-3 d-none d-md-block"></div>
                                    <div class="col-md-6 col-12">
                                        <button type="submit">@lang('trs.submit_change')</button>

                                    </div>
                                    <div class="col-md-3 d-none d-md-block"></div>


                                </div>

                            </form>


                        </div>


                    </div>


                </div>


            </div>


        </div>


    </div>

@endsection

@section('script')
    <script>
        $(".DOB_date").caleran({

            locale: "{{$lang=="de" ? "de" : "en"}}",
            startDate: "{{date('d.m.Y',strtotime(\Illuminate\Support\Facades\Auth::user()->birthday))}}",
            startOnMonday: true,
            maxDate: moment(),
            showFooter: false,
            autoCloseOnSelect: true,
            format: "DD.MM.YYYY",

            DOBCalendar: true,


        });
    </script>
@endsection