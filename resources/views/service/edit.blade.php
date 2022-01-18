@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-header">
		<b>{!! Auth::user()->subModule() !!}</b>

		<div class="card-tools">
			@can('Service Index')
			<a href="{{route('service.index')}}" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-table"></i> &nbsp;{{ __('label.buttons.back_to_list', [ 'name' => Auth::user()->module() ]) }}</a>
			@endcan
		</div>

		<!-- Error Message -->
		@component('components.crud_alert')
		@endcomponent
	</div>
	{!! Form::open(['url' => route('service.update', [$service->id, 'edit']),'method' => 'post','autocomplete'=>'off']) !!}
		{!! Form::hidden('_method', 'PUT') !!}
		<div class="card-body">
			@include('service.form')
		</div>
		<div class="card-footer text-muted text-center">
			@include('components.submit')
		</div>
	{{ Form::close() }}
</div>
@endsection