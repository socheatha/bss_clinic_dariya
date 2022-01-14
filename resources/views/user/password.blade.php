@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-header">
		<b>{!! Auth::user()->subModule() !!}</b>

		<div class="card-tools">
			@can('User Index')
				<a href="{{route('user.index')}}" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-table"></i> &nbsp;{{ __('label.buttons.back_to_list', [ 'name' => Auth::user()->module() ]) }}</a>
			@endcan
		</div>

		<!-- Error Message -->
		@component('components.crud_alert')
		@endcomponent
	</div>
	{!! Form::open(['url' => route('user.update', [$user->id, 'resetPassowrd']),'method' => 'post','autocomplete'=>'off']) !!}
		{!! Form::hidden('_method', 'PUT') !!}
		<div class="card-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						{!! Html::decode(Form::label('email', __('module.table.user.email'))) !!}
						{!! Form::email('email', $user->email, ['class' => 'form-control '. (($errors->has("email"))? "is-invalid" : ""),'placeholder' => 'email','readonly']) !!}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						{!! Html::decode(Form::label('password', __('label.form.user.password') .'<small>*</small>')) !!}
						{!! Form::password('password',['class' => 'form-control '. (($errors->has("password"))? "is-invalid" : ""),'placeholder' => 'password','autocomplete' => 'new-password', 'required']) !!}
						{!! $errors->first('password', '<span class="invalid-feedback">:message</span>') !!}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						{!! Html::decode(Form::label('password_confirmation', __('label.form.user.confirm_password') .'<small>*</small>')) !!}
						{!! Form::password('password_confirmation',['class' => 'form-control '. (($errors->has("password_confirmation"))? "is-invalid" : ""),'placeholder' => 'confirm-password','autocomplete' => 'new-password', 'required']) !!}
						{!! $errors->first('password_confirmation', '<span class="invalid-feedback">:message</span>') !!}
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