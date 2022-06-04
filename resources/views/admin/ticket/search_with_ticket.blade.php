@extends('layouts.admin',["ticket_view"=>1])

@section('content')
    <section class="content">

        <div class="row">
            <div class="col-lg-6 col-xs-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Invoices Stats</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">

                        <div class="search_container">
                            <form action="{{route('admin.search_ticket_result')}}" method="post">
                                {{csrf_field()}}
                                <label for="id">unique id , token , ticket number , airline pnr</label>
                                <input type="text" name="id" id="id" placeholder="unique id , token , ticket number , airline pnr">

                                <button type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

    </section>

@endsection