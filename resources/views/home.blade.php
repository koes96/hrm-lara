{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@include('template.head')
<!--sidebar wrapper -->
@include('template.sidebar')
<!--start header -->
@include('template.navbar')
<!--end header -->
<!--start page wrapper -->
<div  class="page-wrapper">
    <div class="page-content">
        <router-view></router-view>
        <datatable-component></datatable-component>
    </div>
</div>
<!--end page wrapper -->
@include('template.footer')
@include('template.script')
