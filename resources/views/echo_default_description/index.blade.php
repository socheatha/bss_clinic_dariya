@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-header">
		<b>{!! Auth::user()->subModule() !!}</b>

		<div class="card-tools">
			@can('Permission Create')
			<a href="{{route('echo_default_description.create')}}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i> &nbsp;{{ __('label.buttons.create') }}</a>
			@endcan
		</div>

		<!-- Error Message -->
		@component('components.crud_alert')
		@endcomponent
	</div>
	<div class="card-body">
		<table id="datatables-2" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th width="30px">{!! __('module.table.no') !!}</th>
					<th>{!! __('module.table.name') !!}</th>
					<th>{!! __('module.table.echo_default_description.slug') !!}</th>
					<th width="300px">{!! __('module.table.description') !!}</th>
					<th width="10%">{!! __('module.table.action') !!}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($echo_default_descriptions as $i => $echo_default_description)
					@php 
						$record_locked = $echo_default_description->recordLocked();
					@endphp
					<tr>
						<td class="text-center">{{ ++$i }}</td>
						<td>{!! $record_locked ? '<i class="fa fa-lock fa-fw"></i> ' : '' !!}{{ $echo_default_description->name }}</td>
						<td>{{ $echo_default_description->slug }}</td>
						<td class="text-center js_load_dynamic_content" data-btn_name="ចុចទីនេះដើម្បីមើលលម្អិត">{!! $echo_default_description->description !!}</td>
						<td class="text-center">
							@can('Echo Default Description Edit')
								<a href="{{ route('echo_default_description.edit', $echo_default_description->id) }}" class="btn btn-info btn-xs btn-flat" data-toggle="tooltip" data-placement="left" title="{{ __('label.buttons.edit') }}"><i class="fa fa-pencil-alt"></i></a>
							@endcan

							@can('Echo Default Description Delete')
								@if (!$record_locked)
									<button class="btn btn-danger btn-xs btn-flat BtnDeleteConfirm" value="{{ $echo_default_description->id }}" data-toggle="tooltip" data-placement="left" title="{{ __('label.buttons.delete') }}"><i class="fa fa-trash-alt"></i></button>
									{{ Form::open(['url'=>route('echo_default_description.destroy', $echo_default_description->id), 'id' => 'form-item-'.$echo_default_description->id, 'class' => 'sr-only']) }}
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
@endsection
@section('js')
<script type="text/javascript">
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