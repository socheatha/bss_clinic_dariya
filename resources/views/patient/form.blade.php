<div class="row">
	<div class="col-sm-6">
		<div class="row">
			<div class="col-sm-8">
				<div class="form-group">
					{!! Html::decode(Form::label('name', __('label.form.name') .'<small>*</small>')) !!}
					{!! Form::text('name', ((isset($patient->name))? $patient->name : '' ), ['class' => 'form-control '. (($errors->has("name"))? "is-invalid" : ""),'placeholder' => 'name','required']) !!}
					{!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					{!! Html::decode(Form::label('gender', __('label.form.gender'))) !!}
					{!! Form::select('gender', ['1' => __('label.form.male'), '2' => __('label.form.female')], $patient->gender ?? '', ['class' => 'form-control custom-select']) !!}
					{!! $errors->first('gender', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					{!! Html::decode(Form::label('age', __('label.form.patient.age')." <small>*</small>")) !!}
					{!! Form::number('age', ((isset($patient->age))? $patient->age : '' ), ['class' => 'form-control is_integer '. (($errors->has("age"))? "is-invalid" : ""),'placeholder' => 'age']) !!}
					{!! $errors->first('age', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group">
					{!! Html::decode(Form::label('age_type', __('label.form.patient.age_type'))) !!}
					{!! Form::select('age_type', ['1' => __('module.table.selection.age_type_1'), '2' => __('module.table.selection.age_type_2')], ($patient->age_type ?? '1'), ['class' => 'form-control custom-select']) !!}
					{!! $errors->first('age_type', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					{!! Html::decode(Form::label('phone', __('label.form.phone'))) !!}
					{!! Form::text('phone', ((isset($patient->phone))? $patient->phone : '' ), ['class' => 'form-control '. (($errors->has("phone"))? "is-invalid" : ""),'placeholder' => 'phone']) !!}
					{!! $errors->first('phone', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					{!! Html::decode(Form::label('id_card', __('label.form.patient.id_card'))) !!}
					{!! Form::text('id_card', ((isset($patient->id_card))? $patient->id_card : '' ), ['class' => 'form-control '. (($errors->has("id_card"))? "is-invalid" : ""),'placeholder' => 'id card']) !!}
					{!! $errors->first('id_card', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					{!! Html::decode(Form::label('email', __('label.form.email'))) !!}
					{!! Form::email('email', ((isset($patient->email))? $patient->email : '' ), ['class' => 'form-control '. (($errors->has("email"))? "is-invalid" : ""),'placeholder' => 'email']) !!}
					{!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					{!! Html::decode(Form::label('full_address', __('label.form.patient.full_address'))) !!}
					{!! Form::textarea('full_address', ((isset($patient->full_address))? $patient->full_address : '' ), ['class' => 'form-control '. (($errors->has("full_address"))? "is-invalid" : ""), 'style' => 'height: 121px;', 'placeholder' => 'full address']) !!}
					{!! $errors->first('full_address', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					{!! Html::decode(Form::label('description', __('label.form.remark'))) !!}
					{!! Form::textarea('description', ((isset($patient->description))? $patient->description : '' ), ['class' => 'form-control ', 'style' => 'height: 121px;', 'placeholder' => 'remark']) !!}
				</div>
			</div>
		</div>
	</div>

	<?php
	$_4level_address = new \App\Http\Controllers\Location\FourLevelAddressController();
	$_4level_level = $_4level_address->BSSFullAddress($_POST['pt_village_id'] ?? $pre_select_obj->address_code ?? 'xxxxxxxxxxxxxxx', 'array_selection');
	$_data_properties = ['class' => 'form-control select2 province_id', 'data-width' => '100%', 'placeholder' => __('label.form.choose'), 'required' => 'required'];
	?>
	<div class="col-sm-6">
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					{!! Html::decode(Form::label('province_id', __('label.form.patient.province'))) !!}
					{!! Form::select('pt_province_id', $_4level_level[0][0], $_4level_level[0][1], $_data_properties) !!}
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					{!! Html::decode(Form::label('district_id', __('label.form.patient.district'))) !!}
					{!! Form::select('pt_district_id', $_4level_level[1][0], $_4level_level[1][1], $_data_properties) !!}
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group">
					{!! Html::decode(Form::label('address_commune', __('label.form.patient.commune'))) !!}
					{!! Form::select('pt_commune_id', $_4level_level[2][0], $_4level_level[2][1], $_data_properties) !!}
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group">
					{!! Html::decode(Form::label('address_village', __('label.form.patient.village'))) !!}
					{!! Form::select('pt_village_id', $_4level_level[3][0], $_4level_level[3][1], $_data_properties) !!}
				</div>
			</div>
		</div>
	</div>
</div>