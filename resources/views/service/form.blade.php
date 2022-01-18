<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			{!! Html::decode(Form::label('name', __('label.form.name') .' <small>*</small>')) !!}
			{!! Form::text('name', ((isset($service->name))? $service->name : '' ), ['class' => 'form-control '. (($errors->has("name"))? "is-invalid" : ""),'placeholder' => 'name', 'required']) !!}
			{!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			{!! Html::decode(Form::label('price', __('label.form.service.price') .'($) <small>*</small>')) !!}
			{!! Form::text('price', ((isset($service->price))? $service->price : '' ), ['class' => 'form-control is_number '. (($errors->has("price"))? "is-invalid" : ""),'placeholder' => 'price', 'required']) !!}
			{!! $errors->first('price', '<div class="invalid-feedback">:message</div>') !!}
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			{!! Html::decode(Form::label('description', __('label.form.description'))) !!}
			{!! Form::textarea('description', ((isset($service->description))? $service->description : '' ), ['class' => 'form-control ','style' => 'height: 121px;','placeholder' => 'description']) !!}
		</div>
	</div>
</div>