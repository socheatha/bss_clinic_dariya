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
	{!! Form::open(['url' => route('user.store'),'method' => 'post','autocomplete'=>'off']) !!}
		<input autocomplete="no" name="hidden" type="text" style="display:none;">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						{!! Html::decode(Form::label('first_name', __('label.form.user.first_name')." <small>*</small>")) !!}
						{!! Form::text('first_name', '', ['class' => 'form-control '. (($errors->has("first_name"))? "is-invalid" : ""),'placeholder' =>
						'first name','required']) !!}
						{!! $errors->first('first_name', '<span class="invalid-feedback">:message</span>') !!}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						{!! Html::decode(Form::label('last_name', __('label.form.user.last_name')." <small>*</small>")) !!}
						{!! Form::text('last_name', '', ['class' => 'form-control '. (($errors->has("last_name"))? "is-invalid" : ""),'placeholder' =>
						'last name','required']) !!}
						{!! $errors->first('last_name', '<span class="invalid-feedback">:message</span>') !!}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						{!! Html::decode(Form::label('phone', __('label.form.user.phone'))) !!}
						{!! Form::text('phone', '', ['class' => 'form-control ','placeholder' => 'phone']) !!}
						{!! $errors->first('phone', '<span class="invalid-feedback">:message</span>') !!}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						{!! Html::decode(Form::label('email', __('label.form.email') .'<small>*</small>')) !!}
						{!! Form::email('email', '', ['class' => 'form-control '. (($errors->has("email"))? "is-invalid" : ""),'placeholder' => 'email', 'autocomplete'=>'new-password', 'required']) !!}
						{!! $errors->first('email', '<span class="invalid-feedback">:message</span>') !!}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						{!! Html::decode(Form::label('gender', __('label.form.user.gender')." <small>*</small>")) !!}
						{!! Form::select('gender', ['1'=>__('label.form.male'),'2'=>__('label.form.female'),'3'=>__('label.form.other')], '', ['class' => 'form-control custom-select '. (($errors->has("gender"))? "is-invalid" : ""), 'placeholder' => __('label.form.choose'), 'required']) !!}
						{!! $errors->first('gender', '<span class="invalid-feedback">:message</span>') !!}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						{!! Html::decode(Form::label('password', __('label.form.user.password') .'<small>*</small>')) !!}
						{!! Form::password('password', ['class' => 'form-control '. (($errors->has("password"))? "is-invalid" : ""),'placeholder' => 'password', 'autocomplete'=>'new-password', 'required']) !!}
						{!! $errors->first('password', '<span class="invalid-feedback">:message</span>') !!}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						{!! Html::decode(Form::label('password_confirmation', __('label.form.user.confirm_password') .'<small>*</small>')) !!}
						{!! Form::password('password_confirmation', ['class' => 'form-control '. (($errors->has("password_confirmation"))? "is-invalid" : ""),'placeholder' => 'confirm-password', 'autocomplete'=>'new-password', 'required']) !!}
						{!! $errors->first('password_confirmation', '<span class="invalid-feedback">:message</span>') !!}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						{!! Html::decode(Form::label('status', __('label.form.user.status'))) !!}
						<div class="togglebutton mt-1">
							<label>
								{!! Form::checkbox('status', 1, true) !!}
								<span class="toggle toggle-success"></span>
							</label>
						</div>
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