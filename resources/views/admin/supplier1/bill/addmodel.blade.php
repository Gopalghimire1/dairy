@extends('admin.layouts.app')
@section('title','Supplier Bill')
@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />
@endsection

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg " style="margin:0px; max-width:1920px !important;" role="document">
        <div class="modal-content" style="height: 100vh;">
            <div class="modal-header mb-2">
                <h4 class="title" id="largeModalLabel">Create Supplier Bill</h4>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">X</button>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('backend/js/pages/forms/advanced-form-elements.js') }}"></script>
<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>

</script>
@endsection
