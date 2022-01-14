<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			{!! Html::decode(Form::label('name', __('label.form.name') .' <small>*</small>')) !!}
			{!! Form::text('name', ((isset($echo_default_description->name))? $echo_default_description->name : '' ), ['class' => 'form-control '. (($errors->has("name"))? "is-invalid" : ""),'placeholder' => 'name', 'required']) !!}
			{!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			{!! Html::decode(Form::label('slug', __('label.form.echo_default_description.slug') .'<small>*</small>')) !!}
			{!! Form::text('slug', ((isset($echo_default_description->slug))? $echo_default_description->slug : '' ), ['class' => 'form-control '. (($errors->has("slug"))? "is-invalid" : ""),'placeholder' => 'slug', 'required']) !!}
			{!! $errors->first('slug', '<div class="invalid-feedback">:message</div>') !!}
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			{!! Html::decode(Form::label('description', __('label.form.description') .'<small>*</small>')) !!}
			{!! Form::textarea('description', ((isset($echo_default_description->description))? $echo_default_description->description : '' ), ['class' => 'form-control my-editor ','style' => 'height: 121px;', 'placeholder' => 'description', 'required']) !!}
		</div>
	</div>
</div>