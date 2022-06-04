@extends('layouts.admin',["ticket_view"=>1])

@section('content-header')
    User Info

@endsection

@php
    $i=0;
@endphp
@section('breadcrumb')
    <li class="active">user info</li>
@endsection

@section('content')

    @if (isset($user) && !empty($user))


        <section class="content">

            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">User Info</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">

                            <div class="container">

                                <div class="row">

                                    <div class="col-lg-3 col-12 user_info_item">
                                        id : {{$user->id}}
                                    </div>

                                    <div class="col-lg-3 col-12 user_info_item">
                                        Title : {{\App\Services\MyHelperFunction::turn_title($user->gender,1)}}
                                    </div>

                                    <div class="col-lg-3 col-12 user_info_item">
                                        name : {{$user->f_name." ".$user->l_name}}
                                    </div>
                                    <div class="col-lg-3 col-12 user_info_item">
                                        Email : {{$user->email}}
                                    </div>


                                    <div class="col-lg-3 col-12 user_info_item">
                                        birthday : {{$user->birthday}}
                                    </div>

                                    <div class="col-lg-3 col-12 user_info_item">
                                        country : {{$user->countries ? $user->countries->country_en : ""}}
                                    </div>

                                    <div class="col-lg-3 col-12 user_info_item">
                                        mobile : {{$user->mobile}}
                                    </div>


                                    <div class="col-lg-3 col-12 user_info_item">
                                        role : {{\App\Services\MyHelperFunction::turn_role($user->role)}}
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                @if (isset($user->cip_books) && !empty($user->cip_books))

                    @foreach($user->cip_books as $book)

                        <div class="col-lg-12 col-xs-12">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">book history</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                    class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <form action="{{route("admin.cip_update",["id"=>$book->id])}}" method="post">
                                        {{ csrf_field()  }}
                                        <div class="booking_detail">

                                            <div class="row">

                                                <div class="col-3">
                                                    status : {{$book->status}}
                                                </div>
                                                <div class="col-3">
                                                    arranger name
                                                    : {{$book->arranger_first_name." ".$book->arranger_last_name}}
                                                </div>
                                                <div class="col-2">
                                                    phone : {{$book->dial_code.$book->phone}}
                                                </div>
                                                <div class="col-4">
                                                    last update : {{$book->updated_at}}
                                                </div>
                                                <div class="col-6">
                                                    token : {{$book->token}}
                                                </div>

                                                <div class="col-6">
                                                    <label for="ticket_number">ticket number : </label>
                                                    <input type="text" name="ticket_number" class="form-group"
                                                           id="ticket_number"
                                                           value="{{$book->ticket_number}}">
                                                </div>

                                            </div>

                                            <button>submit</button>
                                        </div>

                                    </form>

                                    <div class="border-1">
                                        @include('front.cip_payment.cip_passengers_list')
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                @endif


            </div>

        </section>
    @endif

@endsection