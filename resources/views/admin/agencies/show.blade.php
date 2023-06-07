@extends('layouts.admin')


@section('content')
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border">
                    <div class="box-header text-center">
                        <form action="{{route('admin.agency.update',$user->id)}}" method="post"
                              enctype="multipart/form-data">
                            {{csrf_field()}}

                            <div class="row">


                                <div class="col-md-12">
                                    <label for="payment">active : </label>
                                    <label class="switch">
                                        <input type="checkbox" id="active"
                                               name="active" {{$user->active ? "checked" : ""}}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <label for="discount_adult">Discount adult</label>
                                    <input name="discount_adult" id="discount_adult" class="form-control"
                                           placeholder="Discount adult" value="{{$user->balance->discount_adult}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="discount_child">Discount child</label>
                                    <input name="discount_child" id="discount_child" class="form-control"
                                           placeholder="Discount child" value="{{$user->balance->discount_child}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="discount_infant">Discount infant</label>
                                    <input name="discount_infant" id="discount_infant" class="form-control"
                                           placeholder="Discount infant" value="{{$user->balance->discount_infant}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="commission_adult">Commission adult</label>
                                    <input name="commission_adult" id="commission_adult" class="form-control"
                                           placeholder="Commission adult" value="{{$user->balance->commission_adult}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="commission_child">Commission child</label>
                                    <input name="commission_child" id="commission_child" class="form-control"
                                           placeholder="Commission child" value="{{$user->balance->commission_child}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="commission_infant">Commission infant</label>
                                    <input name="commission_infant" id="commission_infant" class="form-control"
                                           placeholder="Commission infant
"
                                           value="{{$user->balance->commission_infant}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="balance">balance</label>
                                    <input name="balance" id="balance" class="form-control"
                                           placeholder="balance" value="{{$user->balance->amount}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="code">code 3 chs</label>
                                    <input name="code" id="code" class="form-control"
                                           placeholder="code" value="{{$user->code}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="site">site</label>
                                    <input name="site" id="site" class="form-control"
                                           placeholder="site" value="{{$user->site}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="address">address</label>
                                    <input name="address" id="address" class="form-control"
                                           placeholder="address" value="{{$user->address}}">
                                </div>
                                <div class="col-md-12">
                                    <div class="file_upload_container">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="logo">logo</label>
                                                <input name="logo" type="file" id="logo" class="form-control"></div>
                                            <div class="col-md-6">
                                                @if ($user->logo)
                                                    <img width="150px" src="images/{{$user->logo}}">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-4 text-center">
                                    <button type="submit" style="width: 150px;margin-top: 20px;">save</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="box-body">
                        <table id="table" class="table table-bordered dt-responsive">
                            <thead>
                            <tr>
                                <th>Issued date</th>
                                <th>token</th>
                                <th>Status</th>
                                <th>Payment status</th>
                                <th>Invoice number</th>
                                <th>Amount</th>
                                <th>Before balance</th>
                                <th>After balance</th>
                                <th>Ticket number</th>
                                <th>Airline pnr</th>
                                <th>Download invoice</th>
                                <th>Download ticket</th>
                                <th>depart date</th>
                                <th>Unique id</th>
                                <th>Passengers</th>

                            </tr>
                            </thead>
                            <tbody>
                            @php $i= 1; @endphp
                            @foreach ($books as $book)
                                @php($invoice_number=$book->users->code.'-'.intval(date('Y',strtotime($book->payments->created_at)))%100 . \App\Services\MyHelperFunction::turn_4digit_format($book->payments->invoice_number))

                                <tr>
                                    <td>{{ date("Y-m-d \n H:i",strtotime($book->updated_at)) }}</td>
                                    <td>
                                        {{$book->token}}
                                    </td>
                                    <td>
                                        <a href="{{route('admin.search_ticket_result',[ 'id'=>$book->id ])}}">{{ $book->status }}</a>
                                    </td>
                                    <td>
                                        <a>{{ $book->payments->status }}</a>
                                        @if ($book->payments->status=="APPROVED")
                                            <a class="approve_button"
                                               href="{{route('admin.agency.complete_payment',['user'=>$book->users->id, 'payment'=>$book->payments->id])}}">complete</a>
                                        @endif
                                    </td>
                                    <td>
                                        <a>{{ $invoice_number }}</a>
                                    </td>
                                    <td>
                                        <a>{{ $book->payments->before_balance - $book->payments->after_balance}}</a>
                                    </td>
                                    <td>
                                        <a>{{ $book->payments->before_balance }}</a>
                                    </td>
                                    <td>
                                        <a>{{ $book->payments->after_balance }}</a>
                                    </td>

                                    <td>
                                        @if ($book->ticket_number)
                                            {{ $book->ticket_number }}
                                        @elseif($book->passengers[0]->ticket_number)
                                            @foreach($book->passengers as $passenger)
                                                {{ $passenger->ticket_number }}
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $book->airline_pnr }}</td>
                                    <td><a href="invoices/{{$invoice_number}}.pdf">Download</a></td>
                                    <td><a href="tickets/{{$book->token}}.pdf">Download</a></td>
                                    <td>{{ date("Y-m-d \n H:i",strtotime($book->flights->depart_time)) }}</td>
                                    <td>{{ $book->UniqueId }}</td>
                                    <td>
                                        @php($j=0)
                                        @foreach($book->passengers as $passenger)
                                            {{$j>0 ? " , " : ""}}
                                            {{$passenger->first_name." ".$passenger->last_name}}
                                            @php($j++)
                                        @endforeach
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Issued date</th>
                                <th>token</th>
                                <th>Status</th>
                                <th>Payment status</th>
                                <th>Invoice number</th>
                                <th>Amount</th>
                                <th>Before balance</th>
                                <th>After balance</th>
                                <th>Ticket number</th>
                                <th>Airline pnr</th>
                                <th>Download invoice</th>
                                <th>Download ticket</th>
                                <th>depart date</th>
                                <th>Unique id</th>
                                <th>Passengers</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.box -->

            </div>
        </div>

    </section>
@endsection



@section('script')

@endsection
