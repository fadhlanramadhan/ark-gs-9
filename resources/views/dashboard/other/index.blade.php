@extends('templates.main')

@section('title_page')
    <h1>Recap <small><b>PO Sent</b></small></h1> 
    {{-- <h1>Recap <small><b>PO Sent</b></small> | <a href="{{ route('dashboard.other.grpo') }}"><small>GRPO</small></a></h1>  --}}
@endsection

@section('breadcrumb_title')
    dashboard / other
@endsection

@section('content')
    <div class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-12">
            @include('dashboard.other.static_v_dynamic')
          </div>
        </div>

      </div>
    </div>
@endsection