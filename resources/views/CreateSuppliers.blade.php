@extends('layouts.app')

@section('css')
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{asset('assets/css/pages/wizard/wizard-1.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <create-edit-supplier :create-mood="true"></create-edit-supplier>
    </div>
@endsection

@section('js')

    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset('assets/js/pages/custom/wizard/wizard-1.js')}}"></script>
    <!--end::Page Scripts-->

@endsection
