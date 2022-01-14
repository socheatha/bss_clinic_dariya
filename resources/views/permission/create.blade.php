@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-header">
		<b>{!! Auth::user()->subModule() !!}</b>

		<div class="card-tools">
			@can('Permission Index')
			<a href="{{route('permission.index')}}" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-table"></i> &nbsp;{{ __('label.buttons.back_to_list', [ 'name' => Auth::user()->module() ]) }}</a>
			@endcan
		</div>

		<!-- Error Message -->
		@component('components.crud_alert')
		@endcomponent
	</div>
	
	{!! Form::open(['url' => route('permission.store'),'method' => 'post','class' => 'mt-3']) !!}
		<div class="card-body">
			@include('permission.form')
		</div>

		<div class="card-footer text-muted text-center">
			@include('components.submit')
		</div>
	{{ Form::close() }}
</div>
@endsection