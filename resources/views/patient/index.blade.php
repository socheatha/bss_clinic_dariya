@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        <b>{!! Auth::user()->subModule() !!}</b>

        <div class="card-tools">
            @can('Patient Create')
            <a href="{{route('patient.create')}}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i> &nbsp;{{ __('label.buttons.create') }}</a>
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
                    <th width="10%">{!! __('module.table.no') !!}</th>
                    <th>{!! __('module.table.name') !!}</th>
                    <th>{!! __('module.table.gender') !!}</th>
                    <th>{!! __('module.table.patient.age') !!}</th>
                    <th>{!! __('module.table.email') !!}</th>
                    <th>{!! __('module.table.phone') !!}</th>
                    <th width="10%">{!! __('module.table.action') !!}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $i => $patient)
                    @php
						$record_locked = $patient->recordLocked();
					@endphp
                    <tr>
                        <td class="text-center">{{ str_pad($patient->id, 6, "0", STR_PAD_LEFT) }}</td>
                        <td>{!! $record_locked ? '<i class="fa fa-lock fa-fw"></i> ' : '' !!}{{ $patient->name }}</td>
                        <td class="text-center">{{ (($patient->gender==1)? __('label.form.male') : __('label.form.female')) }}</td>
                        <td class="text-center">{{ $patient->age }} {{ __('module.table.selection.age_type_' . $patient->age_type) }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>{{ $patient->phone }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-xs btn-flat" onclick="getDetail({{ $patient->id }})" data-toggle="tooltip" data-placement="left" title="{{ __('label.buttons.show') }}"><i class="fa fa-list"></i></button>

                            {{-- @can('Patient Show')
                                <button type="button" class="btn btn-warning btn-xs btn-flat" onclick="getDetail({{ $patient->id }})" data-toggle="tooltip" data-placement="left" title="{{ __('label.buttons.show') }}"><i class="fa fa-eye"></i></button>
                            @endcan --}}

                            @can('Patient Edit')
                            <a href="{{ route('patient.edit', $patient->id) }}" class="btn btn-info btn-xs btn-flat" data-toggle="tooltip" data-placement="left" title="{{ __('label.buttons.edit') }}"><i class="fa fa-pencil-alt"></i></a>
                            @endcan

                            @can('Patient Delete')
                                @if(!$record_locked)
                                    <button class="btn btn-danger btn-xs btn-flat BtnDeleteConfirm" value="{{ $patient->id }}" data-toggle="tooltip" data-placement="left" title="{{ __('label.buttons.delete') }}"><i class="fa fa-trash-alt"></i></button>
                                    {{ Form::open(['url'=>route('patient.destroy', $patient->id), 'id' => 'form-item-'.$patient->id, 'class' => 'sr-only']) }}
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

<div class="modal fade" id="modal_patient_detail">
    <div class="modal-dialog mw-100 " style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{ __('alert.modal.title.detail') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="patient_detail">
                    <div class="row">
                        <div class="col xs-12 col-sm-4 col-md-4" id="history_list" style="max-height: 650px; overflow: auto;">
                            <!-- Spare data for AJAX load -->
                        </div>
                        <div class="col xs-12 col-sm-8 col-md-8">
                            <iframe id="print_page_result" data-srcdoc="<p align='center'>...</p>" width="100%" height="650" frameBorder="1"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    function getDetail(id) {
        $('#print_page_result').attr('srcdoc', $('#print_page_result').data('srcdoc'));
        getPatientInfo(id);
        $.ajax({
            url: "{{ route('patient.getDetail') }}",
            method: 'post',
            data: {
                id: id,
            },
            success: function(rs) {
                var patient = rs.patient;
                var hisory = JSON.parse(rs.P_history);
                var html_structure = `<table class="table table-striped table-hover">
						<tr>
							<th class="text-center">{!! __('module.table.name') !!}</th>
							<th class="text-center">{!! __('module.table.date') !!}</th>
							<th class="text-center">{!! __('module.table.patient.age') !!}</th>
							<th class="text-center">{!! __('module.table.action') !!}</th>
						</tr>
					`;
                hisory.forEach((h, i) => {
                    _age_type = "{!! __('module.table.selection.age_type_1') !!}";
                    if (h['pt_age_type'] && h['pt_age_type'] == 2) _age_type = "{!! __('module.table.selection.age_type_2') !!}";
                    html_structure += `<tr>
							<td><a href="javascript:getPatientInfo(${id})">${h['pt_name']}</a></td>
							<td class="text-center">${h['date']}</td>
							<td class="text-center">${bss_number(h['pt_age'])} ${_age_type}</td>
							<td class="text-center"><a href="javascript:getPrintPage('${h['link']}')">${h['label_info']}</a></td>
						</tr>`;
                });
                html_structure += `</table>`;
                $('#history_list').html(html_structure);
                $('#modal_patient_detail').modal('show');
            }
        });
    }

    function getPrintPage($url) {
        $('#print_page_result').attr('srcdoc', '<p align=center> ......... </p>');
        $.ajax({
            url: $url,
            method: 'get',
            success: function(rs) {
                $('#print_page_result').attr('srcdoc', rs);
            }
        });
    }

    function getPatientInfo(p_id) {
        $.ajax({
            url: 'patient/' + p_id + '/edit',
            method: 'get',
            success: function(rs) {
                // start to scrapt data (JSOP)
                $form_edit = $(rs).find('.content');
                $form_edit.find('.card-header').html(`<p class="text-center text-bold">{!! __("sidebar.patient.main") !!}</p>`);
                $form_edit.find('.card-footer').remove();
                $form_edit.find('small').remove();
                $form_edit.find('*').attr('readonly', 'readonly');
                $('#print_page_result').attr('srcdoc', `<body><link href="/css/app.css" rel="stylesheet"><link href="http://localhost:8000/css/custom-style.css" rel="stylesheet">${$form_edit.html()}</body>`);
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