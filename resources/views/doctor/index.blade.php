@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-header">
		<b>{!! Auth::user()->subModule() !!}</b>

		<div class="card-tools">
			@can('Doctor Create')
			<a href="{{route('doctor.create')}}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i> &nbsp;{{ __('label.buttons.create') }}</a>
			@endcan
		</div>

		<!-- Error Message -->
		@component('components.crud_alert')
		@endcomponent
	</div>
	<div class="card-body">
		<table id="datatables-2" class="table table-striped table-hover">
			<thead>
				<tr>
					<th width="30px">{!! __('module.table.no') !!}</th>
					<th>{!! __('module.table.name_kh') !!} :: {!! __('module.table.name_en') !!}</th>
					<th>{!! __('module.table.gender') !!}</th>
					<th>{!! __('module.table.phone') !!}</th>
					<th>{!! __('module.table.email') !!}</th>
					<th width="10%">{!! __('module.table.action') !!}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($doctors as $i => $doctor)
					@php
						$record_locked = $doctor->recordLocked();
					@endphp
					<tr>
						<td class="text-center">{{ ++$i }}</td>
						<td>{!! $record_locked ? '<i class="fa fa-lock fa-fw"></i> ' : '' !!}{{ $doctor->name_kh }} {{ $doctor->name_en }}</td>
						<td class="text-center">{{ (($doctor->gender==1)? __('label.form.male') : __('label.form.female')) }}</td>
						<td>{{ $doctor->phone }}</td>
						<td>{{ $doctor->email }}</td>
						<td class="text-center">

							{{-- @can('Patient Show')
								<button type="button" class="btn btn-warning btn-sm btn-flat" onclick="getDetail({{ $doctor->id }})" data-toggle="tooltip" data-placement="left" title="{{ __('label.buttons.show') }}"><i class="fa fa-eye"></i></button>
							@endcan --}}

							@can('Patient Edit')
							<a href="{{ route('doctor.edit', $doctor->id) }}" class="btn btn-info btn-xs btn-flat" data-toggle="tooltip" data-placement="left" title="{{ __('label.buttons.edit') }}"><i class="fa fa-pencil-alt"></i></a>
							@endcan

							@can('Patient Delete')
								@if(!$record_locked)
									<button class="btn btn-danger btn-xs btn-flat BtnDeleteConfirm" value="{{ $doctor->id }}" data-toggle="tooltip" data-placement="left" title="{{ __('label.buttons.delete') }}"><i class="fa fa-trash-alt"></i></button>
									{{ Form::open(['url'=>route('doctor.destroy', $doctor->id), 'id' => 'form-item-'.$doctor->id, 'class' => 'sr-only']) }}
									{{ Form::hidden('_method','DELETE') }}
									{{ Form::hidden('passwordDelete','') }}
									{{ Form::close() }}
								@else
									<button class="btn btn-danger btn-xs btn-flat disabled"><i class="fa fa-trash-alt"></i></button>
								@endif
							@endcan
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<span class="sr-only" id="deleteAlert" data-title="{{ __('alert.swal.title.delete', ['name' => Auth::user()->module()]) }}" data-text="{{ __('alert.swal.text.unrevertible') }}" data-btnyes="{{ __('alert.swal.button.yes') }}" data-btnno="{{ __('alert.swal.button.no') }}" data-rstitle="{{ __('alert.swal.result.title.success') }}" data-rstext="{{ __('alert.swal.result.text.delete') }}"> Delete Message </span>
{{-- Password Confirm modal --}}
@component('components.confirm_password')@endcomponent

<div class="modal fade" id="modal_doctor_detail">
	<div class="modal-dialog mw-100 " style="width: 75%;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">{{ __('alert.modal.title.detail') }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="doctor_detail"></div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	function getDetail(id) {
		$.ajax({
			url: "{{ route('doctor.getDetail') }}",
			method: 'post',
			data: {
				id: id,
			},
			success: function(rs) {
				$('#doctor_detail').html(rs.detail);
				$('#modal_doctor_detail').modal('show');
			}
		});
	}

	$('#datatables-2').DataTable({
		"language": (($('html').attr('lang')) ? datatableKH : {}),
		buttons: true,
		"fnDrawCallback": function(oSettings) {
			$('.BtnDeleteConfirm').click(function() {
				$('#item_id').val($(this).val());
				$('#modal_confirm_delete').modal();
			});

			$('.submit_confirm_password').click(function() {
				var id = $('#item_id').val();
				var password_confirm = $('#password_confirm').val();
				$('[name="passwordDelete"]').val(password_confirm);
				if (password_confirm != '') {
					$.ajax({
						url: "{{ route('user.password_confirm') }}",
						type: 'post',
						data: {
							id: id,
							_token: '{{ csrf_token() }}',
							password_confirm: password_confirm
						},
					})
					.done(function(result) {
						if (result == true) {
							Swal.fire({
								icon: 'success',
								title: "{{ __('alert.swal.result.title.success') }}",
								confirmButtonText: "{{ __('alert.swal.button.yes') }}",
								timer: 1500
							})
							.then((result) => {
								$("form").submit(function(event) {
									$('button').attr('disabled', 'disabled');
								});
								$('[name="passwordDelete"]').val(password_confirm);
								$("#form-item-" + id).submit();
							})
						} else {
							Swal.fire({
								icon: 'warning',
								title: "{{ __('alert.swal.result.title.wrong',['name'=>'ពាក្យសម្ងាត់']) }}",
								confirmButtonText: "{{ __('alert.swal.button.yes') }}",
								timer: 2500
							})
							.then((result) => {
								$('#modal_confirm_delete').modal();
							})
						}
					});
				} else {
					Swal.fire({
						icon: 'warning',
						title: "{{ __('alert.swal.title.empty') }}",
						confirmButtonText: "{{ __('alert.swal.button.yes') }}",
						timer: 1500
					})
					.then((result) => {
						$('#modal_confirm_delete').modal();
					})
				}
			});
		},
	});
</script>
@endsection