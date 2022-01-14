@extends('layouts.app')

@section('css')
<style class="text/css">
	#datatables th,
	#datatables td {
		padding: 8px;
	}
</style>
@endsection

@section('content')
<div class="row">
	<div class="col-md-3">

		<!-- Profile Image -->
		<div class="card card-primary card-outline">
			<div class="card-body box-profile">
				<div class="text-center">
					<img class="profile-user-img img-fluid img-circle" src="/images/users/{{ Auth::user()->image }}" alt="User profile picture">
				</div>

				<h3 class="profile-username text-center">{{ Auth::user()->first_name .' '. Auth::user()->last_name }}</h3>

				<p class="text-muted text-center">{{ Auth::user()->position }}</p>

				<ul class="list-group list-group-unbordered mb-3">
					<li class="list-group-item">
						<b>{{ __('label.form.email') }}</b> <a class="float-right">{{ Auth::user()->email }}</a>
					</li>
					<li class="list-group-item">
						<b>{{ __('label.form.user.phone') }}</b> <a class="float-right">{{ Auth::user()->phone }}</a>
					</li>
					<li class="list-group-item">
						<b>{{ __('label.form.user.gender') }}</b> <a class="float-right">{{ ((Auth::user()->gender=='1')? __('label.form.male') : ((Auth::user()->gender=='2')? __('label.form.female') : __('label.form.other'))) }}</a>
					</li>
					<li class="list-group-item">
						<b>{{ __('label.form.user.language') }}</b> <a class="float-right">{{ ((Auth::user()->language == 'kh')? __('label.lang.khmer') : __('label.lang.english')) }}</a>
					</li>
					<li class="list-group-item">
						<b>{{ __('label.form.user.status') }}</b> <a class="float-right">{!! ((Auth::user()->status)? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>') !!}</a>
					</li>
				</ul>

				<a class="btn btn-danger btn-block btn-flat" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
					<i class="fa fa-sign-out-alt"></i> &nbsp;{{ __('label.buttons.sign_out') }}</a>
				</a>

			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->

		{{-- <!-- About Me Box -->
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">About Me</h3>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<strong><i class="fas fa-book mr-1"></i> Education</strong>

				<p class="text-muted">
					B.S. in Computer Science from the University of Tennessee at Knoxville
				</p>

				<hr>

				<strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

				<p class="text-muted">Malibu, California</p>

				<hr>

				<strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

				<p class="text-muted">
					<span class="tag tag-danger">UI Design</span>
					<span class="tag tag-success">Coding</span>
					<span class="tag tag-info">Javascript</span>
					<span class="tag tag-warning">PHP</span>
					<span class="tag tag-primary">Node.js</span>
				</p>

				<hr>

				<strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

				<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card --> --}}
	</div>
	<!-- /.col -->
	<div class="col-md-9">
		<div class="card">
			<div class="card-header p-2">
				<ul class="nav nav-pills">
					<li class="nav-item"><a class="nav-link {{ (($profileTab == 'permission' || $profileTab == '')? 'active' : '') }}" href="#permission" data-toggle="tab">{!! __('module.table.user.permission') !!}</a></li>
					<li class="nav-item"><a class="nav-link {{ (($profileTab == 'edit')? 'active' : '') }}" href="#edit" data-toggle="tab">{!! __('module.table.user.edit') !!}</a></li>
					<li class="nav-item"><a class="nav-link {{ (($profileTab == 'password')? 'active' : '') }}" href="#password" data-toggle="tab">{!! __('module.table.user.password') !!}</a></li>
					<li class="nav-item"><a class="nav-link {{ (($profileTab == 'image')? 'active' : '') }}" href="#image" data-toggle="tab">{!! __('module.table.user.image') !!}</a></li>
				</ul>
			</div><!-- /.card-header -->
			<div class="card-body">
				<div class="tab-content">

					<div class="tab-pane {{ (($profileTab == 'permission' || $profileTab == '')? 'active' : '') }}" id="permission">
						<table class="table table-striped table-valign-middle" id="datatables">
							<thead>
								<tr>
									<th width="30%">{!! __('module.table.name') !!}</th>
									<th>{!! __('module.table.description') !!}</th>
								</tr>
							</thead>
							<tbody>
								{{-- @if (Auth::user()->getAllPermissions()->count() == Auth::user()->allPermissions()->count())
								<tr>
									<td class="text-center" colspan="2"> {{ __('alert.all_permission') }} ​</td>
								</tr>
								@else --}}
								@foreach (Auth::user()->getAllPermissions() as $item => $permission)
								<tr>
									<td width="30%">{{ $permission->name }}</td>
									<td><small>{{ $permission->description }}</small></td>
								</tr>
								@endforeach
								{{-- @endif --}}
							</tbody>
						</table>
					</div>
					<!-- /.tab-pane -->

					<div class="tab-pane {{ (($profileTab == 'edit')? 'active' : '') }}" id="edit">

						<!-- Error Message -->
						@component('components.crud_alert')
						@endcomponent

						{!! Form::open(['url' => route('user.update', [Auth::user()->id, 'profile']),'method' => 'post','autocomplete'=>'off','class'=>'mt-3']) !!}
						{!! Form::hidden('_method', 'PUT') !!}
						{!! Form::hidden('profileTab', 'edit') !!}
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									{!! Html::decode(Form::label('first_name', __('label.form.user.first_name')." <small>*</small>")) !!}
									{!! Form::text('first_name', Auth::user()->first_name, ['class' => 'form-control '. (($errors->has("first_name"))? "is-invalid" : ""),'placeholder' => 'first name','required']) !!}
									{!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
								</div>
								<div class="row">
									<div class="col-sm-9">
										<div class="form-group">
											{!! Html::decode(Form::label('gender', __('label.form.user.gender')." <small>*</small>")) !!}
											{!! Form::select('gender', ['1'=>__('label.form.male'),'2'=>__('label.form.female'),'3'=>__('label.form.other')], Auth::user()->gender, ['class' => 'form-control custom-select', 'placeholder' => __('label.form.choose'),'required']) !!}
											{!! $errors->first('gender', '<span class="help-block">:message</span>') !!}
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group text-center">
											{!! Html::decode(Form::label('status', __('label.form.user.status'))) !!}
											<div class="togglebutton mt-1">
												<label>
													{!! Form::checkbox('status', Auth::user()->status, ((Auth::user()->status==1)? true : false )) !!}
													<span class="toggle toggle-success"></span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							{{-- / .col --}}

							<div class="col-sm-6">
								<div class="form-group">
									{!! Html::decode(Form::label('last_name', __('label.form.user.last_name')." <small>*</small>")) !!}
									{!! Form::text('last_name', Auth::user()->last_name, ['class' => 'form-control '. (($errors->has("last_name"))? "is-invalid" : ""),'placeholder' =>
									'last name','required']) !!}
									{!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
								</div>
								<div class="form-group">
									{!! Html::decode(Form::label('phone', __('label.form.user.phone'))) !!}
									{!! Form::text('phone', Auth::user()->phone, ['class' => 'form-control ','placeholder' => 'phone']) !!}
									{!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
								</div>
							</div>

						</div>
						{{-- / .row --}}

						<div class="card-footer text-muted text-center mt-4 pb-0 pt-3">
							@include('components.submit')
						</div>
						<!-- ./card-Footer -->
						{{ Form::close() }}

					</div>
					<!-- /.tab-pane -->

					<div class="tab-pane {{ (($profileTab == 'password')? 'active' : '') }}" id="password">

						<!-- Error Message -->
						@component('components.crud_alert')
						@endcomponent

						{!! Form::open(['url' => route('user.update', [Auth::user()->id, 'updatePassowrd']),'method' => 'post','autocomplete'=>'off']) !!}
						{!! Form::hidden('_method', 'PUT') !!}
						{!! Form::hidden('profileTab', 'password') !!}

						<div class="form-group">
							{!! Html::decode(Form::label('email', __('label.form.email'))) !!}
							{!! Form::email('email', Auth::user()->email, ['class' => 'form-control '. (($errors->has("email"))? "is-invalid" : ""),'placeholder' => 'email','readonly']) !!}
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									{!! Html::decode(Form::label('current_password', __('label.form.user.current_password') .'<small>*</small>')) !!}
									{!! Form::password('current_password',['class' => 'form-control '. (($errors->has("current_password"))? "is-invalid" : ""),'placeholder' => 'current password','autocomplete' => 'new-password', 'required']) !!}
									{!! $errors->first('current_password', '<span class="invalid-feedback">:message</span>') !!}
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									{!! Html::decode(Form::label('password', __('label.form.user.password') .'<small>*</small>')) !!}
									{!! Form::password('password',['class' => 'form-control '. (($errors->has("password"))? "is-invalid" : ""),'placeholder' => 'password','autocomplete' => 'new-password', 'required']) !!}
									{!! $errors->first('password', '<span class="invalid-feedback">:message</span>') !!}
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									{!! Html::decode(Form::label('password_confirmation', __('label.form.user.confirm_password') .'<small>*</small>')) !!}
									{!! Form::password('password_confirmation',['class' => 'form-control '. (($errors->has("password_confirmation"))? "is-invalid" : ""),'placeholder' => 'confirm-password','autocomplete' => 'new-password', 'required']) !!}
									{!! $errors->first('password_confirmation', '<span class="invalid-feedback">:message</span>') !!}
								</div>
							</div>
						</div>

						<div class="card-footer text-muted text-center mt-4 pb-0 pt-3">
							@include('components.submit')
						</div>
						<!-- ./card-Footer -->
						{{ Form::close() }}

					</div>
					<!-- /.tab-pane -->

					<div class="tab-pane {{ (($profileTab == 'image')? 'active' : '') }}" id="image">
						{!! Form::open(['url' => route('user.update', [Auth::user()->id, 'image']), 'method'=>'post', 'enctype'=>'multipart/form-data','class' =>
						'mt-3', 'autocomplete'=>'off']) !!}
						{!! Form::hidden('_method', 'PUT') !!}
						{!! Form::hidden('profileTab', 'image') !!}
						<div class="row justify-content-center">
							<div class="col-sm-4 text-center">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new img-thumbnail" style="max-width: 100%;">
										<img data-src="" src="/images/users/{{ Auth::user()->image }}" alt="{{ Auth::user()->name }}">
									</div>
									<div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 248px;"></div>
									<div class="mt-2">
										<span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">{{ __('label.buttons.select') }}</span><span class="fileinput-exists">{{ __('label.buttons.change') }}</span><input type="file" name="image" /></span>
										<a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">{{ __('label.buttons.remove') }}</a>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<br />
						</div>
						{{-- / .row --}}

						<div class="card-footer text-muted text-center mt-4 pb-0 pt-3">
							@include('components.submit')
						</div>
						{{ Form::close() }}
					</div>
					<!-- /.tab-pane -->
				</div>
				<!-- /.tab-content -->
			</div><!-- /.card-body -->
		</div>
		<!-- /.nav-tabs-custom -->
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->
@endsection

@section('js')
<script type="text/javascript">

</script>
@endsection