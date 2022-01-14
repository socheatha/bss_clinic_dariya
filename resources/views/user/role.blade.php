@extends('layouts.app')
@section('content')

<div class="card">
	<div class="card-header">
		<b>{!! Auth::user()->subModule() !!}</b>

		<div class="card-tools">
			<a href="{{route('user.index')}}" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-table"></i> &nbsp;{{ __('label.buttons.back_to_list', [ 'name' => Auth::user()->module() ]) }}</a>
		</div>

		<!-- Error Message -->
		@component('components.crud_alert')
		@endcomponent
	</div>
	{!! Form::open(['url' => route('user.update_role', [$user->id, 'edit']),'method' => 'post','autocomplete'=>'off']) !!}
		{!! Form::hidden('_method', 'PUT') !!}
		<div class="card-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						{!! Html::decode(Form::label('role', __('label.form.user.role')." <small>*</small>")) !!}
						{!! Form::select('role', $roles, ((isset($user->roles->first()->name))? $user->roles->first()->name : '' ), ['class' => 'form-control select2 select2-purple', 'data-dropdown-css-class' => 'select2-purple','placeholder' => __('label.form.choose'),'required']) !!}
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer text-muted text-center">
			@include('components.submit')
		</div>
	{{ Form::close() }}
</div>
@endsection