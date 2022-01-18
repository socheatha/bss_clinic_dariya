@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-header">
		<b>{!! Auth::user()->subModule() !!}</b>

		<div class="card-tools">
			@can('Doctor Index')
			<a href="{{route('doctor.index')}}" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-table"></i> &nbsp;{{ __('label.buttons.back_to_list', [ 'name' => Auth::user()->module() ]) }}</a>
			@endcan
		</div>

		<!-- Error Message -->
		@component('components.crud_alert')
		@endcomponent
	</div>
	{!! Form::open(['url' => route('doctor.update', [$doctor->id, 'edit']),'method' => 'post','autocomplete'=>'off']) !!}
		{!! Form::hidden('_method', 'PUT') !!}
		<div class="card-body">
			@include('doctor.form')
		</div>
		<div class="card-footer text-muted text-center">
			@include('components.submit')
		</div>
	{{ Form::close() }}
</div>
@endsection

@section('js')
<script type="text/javascript">
	$('[name="address_province_id"]').change(function(e) {
		if ($(this).val() != '') {
			$.ajax({
				url: "{{ route('province.getSelectDistrict') }}",
				method: 'post',
				data: {
					id: $(this).val(),
				},
				success: function(data) {
					$('[name="address_district_id"]').attr({
						"disabled": false
					});
					$('[name="address_district_id"]').html(data);
				}
			});
		} else {
			$('[name="address_district_id"]').attr({
				"disabled": true
			});
			$('[name="address_district_id"]').html('<option value="">{{ __("label.form.choose") }}</option>');
		}
	});
</script>
@endsection