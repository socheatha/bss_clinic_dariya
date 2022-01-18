<div class="row">
	<div class="col-sm-6">
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					{!! Html::decode(Form::label('name_kh', __('label.form.name_kh') .' <small>*</small>')) !!}
					{!! Form::text('name_kh', ((isset($doctor->name_kh))? $doctor->name_kh : '' ), ['class' => 'form-control '. (($errors->has("name_kh"))? "is-invalid" : ""),'placeholder' => 'name kh','required']) !!}
					{!! $errors->first('name_kh', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					{!! Html::decode(Form::label('name_en', __('label.form.name_en') .' <small>*</small>')) !!}
					{!! Form::text('name_en', ((isset($doctor->name_en))? $doctor->name_en : '' ), ['class' => 'form-control '. (($errors->has("name_en"))? "is-invalid" : ""),'placeholder' => 'name en','required']) !!}
					{!! $errors->first('name_en', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					{!! Html::decode(Form::label('gender', __('label.form.gender')." <small>*</small>")) !!}
					<div class="row">
						<div class="col-sm-6">
							<div class="icheck-primary d-inline">
								<input type="radio" value="1" name="gender" id="male" {{ ((isset($doctor->gender) && $doctor->gender == 2 )? '' : 'checked' ) }}>
								<label for="male">
								</label>
							</div>
							{!! Html::decode(Form::label('male', __('label.form.male'))) !!}
							&nbsp;&nbsp;&nbsp;&nbsp;
							<div class="icheck-primary d-inline">
								<input type="radio" value="2" name="gender" id="female" {{ ((isset($doctor->gender) && $doctor->gender == 2 )? 'checked' : '' ) }}>
								<label for="female">
								</label>
							</div>
							{!! Html::decode(Form::label('female', __('label.form.female'))) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					{!! Html::decode(Form::label('id_card', __('label.form.doctor.id_card'))) !!}
					{!! Form::text('id_card', ((isset($doctor->id_card))? $doctor->id_card : '' ), ['class' => 'form-control '. (($errors->has("id_card"))? "is-invalid" : ""),'placeholder' => 'id card']) !!}
					{!! $errors->first('id_card', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					{!! Html::decode(Form::label('phone', __('label.form.phone'))) !!}
					{!! Form::text('phone', ((isset($doctor->phone))? $doctor->phone : '' ), ['class' => 'form-control '. (($errors->has("phone"))? "is-invalid" : ""),'placeholder' => 'phone']) !!}
					{!! $errors->first('phone', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					{!! Html::decode(Form::label('email', __('label.form.email'))) !!}
					{!! Form::email('email', ((isset($doctor->email))? $doctor->email : '' ), ['class' => 'form-control '. (($errors->has("email"))? "is-invalid" : ""),'placeholder' => 'email']) !!}
					{!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					{!! Html::decode(Form::label('full_address', __('label.form.doctor.full_address'))) !!}
					{!! Form::textarea('full_address', ((isset($doctor->full_address))? $doctor->full_address : '' ), ['class' => 'form-control '. (($errors->has("full_address"))? "is-invalid" : ""),'placeholder' => 'full address']) !!}
					{!! $errors->first('full_address', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-6">
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					{!! Html::decode(Form::label('province_id', __('label.form.doctor.province'))) !!}
					{!! Form::select('address_province_id', $provinces, ((isset($doctor->address_province_id))? $doctor->address_province_id : '' ), ['class' => 'form-control select2 province_id','data-width'=>'100%', 'placeholder' => __('label.form.choose')]) !!}
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group">
					{!! Html::decode(Form::label('district_id', __('label.form.doctor.district'))) !!}
					{!! Form::select('address_district_id', $districts, ((isset($doctor->address_district_id))? $doctor->address_district_id : '' ), ['class' => 'form-control select2 district_id','data-width'=>'100%', 'placeholder' => __('label.form.choose'), (($districts==[])? 'disabled' : '' )]) !!}
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group">
					{!! Html::decode(Form::label('address_commune', __('label.form.doctor.commune'))) !!}
					{!! Form::text('address_commune', ((isset($doctor->address_commune))? $doctor->address_commune : '' ), ['class' => 'form-control '. (($errors->has("address_commune"))? "is-invalid" : ""),'placeholder' => 'commune']) !!}
					{!! $errors->first('address_commune', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group">
					{!! Html::decode(Form::label('address_village', __('label.form.doctor.village'))) !!}
					{!! Form::text('address_village', ((isset($doctor->address_village))? $doctor->address_village : '' ), ['class' => 'form-control '. (($errors->has("address_village"))? "is-invalid" : ""),'placeholder' => 'village']) !!}
					{!! $errors->first('address_village', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					{!! Html::decode(Form::label('description', __('label.form.remark'))) !!}
					{!! Form::textarea('description', ((isset($doctor->description))? $doctor->description : '' ), ['class' => 'form-control ','style' => 'height: 121px;','placeholder' => 'remark']) !!}
				</div>
			</div>
		</div>
	</div>
</div>