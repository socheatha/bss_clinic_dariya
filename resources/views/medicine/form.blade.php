<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			{!! Html::decode(Form::label('name', __('label.form.name') .' <small>*</small>')) !!}
			{!! Form::text('name', ((isset($medicine->name))? $medicine->name : '' ), ['class' => 'form-control '. (($errors->has("name"))? "is-invalid" : ""),'placeholder' => 'name', 'required']) !!}
			{!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			{!! Html::decode(Form::label('code', __('label.form.medicine.code'))) !!}
			{!! Form::text('code', ((isset($medicine->code))? $medicine->code : '' ), ['class' => 'form-control '. (($errors->has("code"))? "is-invalid" : ""),'placeholder' => 'code']) !!}
			{!! $errors->first('code', '<div class="invalid-feedback">:message</div>') !!}
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			{!! Html::decode(Form::label('price', __('label.form.medicine.price') .'($) <small>*</small>')) !!}
			{!! Form::text('price', ((isset($medicine->price))? $medicine->price : '' ), ['class' => 'form-control is_number '. (($errors->has("price"))? "is-invalid" : ""),'placeholder' => 'price', 'required']) !!}
			{!! $errors->first('price', '<div class="invalid-feedback">:message</div>') !!}
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			{!! Html::decode(Form::label('usage_id', __('label.form.medicine.usage') .' <small>*</small>')) !!}
			{!! Form::select('usage_id', $usages, ((isset($medicine->usage_id))? $medicine->usage_id : '' ), ['class' => 'form-control select2 usage_id','placeholder' => __('label.form.choose'), 'required']) !!}
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			{!! Html::decode(Form::label('description', __('label.form.remark'))) !!}
			{!! Form::textarea('description', ((isset($medicine->description))? $medicine->description : '' ), ['class' => 'form-control ','style' => 'height: 121px;','placeholder' => 'remark']) !!}
		</div>
	</div>
</div>