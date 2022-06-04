@extends('layouts.front')
@section('content')
    <section class="padding-tb-100px">
        <div class="container {{$rtl_ignore ? "force_ltr" : ""}}" >
            {!! $text !!}
        </div>
    </section>
@endsection