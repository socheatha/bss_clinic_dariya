@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-header">
		<b>{!! Auth::user()->subModule() !!}</b>
	</div>
	@php
	$back_addr = substr_replace($addr, '', -2);
	$code_length = $addr ? strlen($addr) : 0;
	@endphp
	<div class="card-body">
		<table id="datatables" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>{!! __('module.table.no') !!}</th>
					<th>{{ __('module.table.name_kh') }} :: {{ __('module.table.name_en') }} ({{ $code_length == 2 ? __('label.form.patient.district') : ($code_length == 4 ? __('label.form.patient.commune') : ($code_length == 6 ? __('label.form.patient.village') : __('label.form.patient.province'))) }})</th>
					<th>
						{!! $code_length >=2 ? '<a href="?addr=' . $back_addr . '" class=""><i class="fa fa-undo"></i></a> -- ' : '' !!}
						{{ $code_length == 2 ? __('label.form.patient.commune') : ($code_length == 4 ? __('label.form.patient.village') : ($code_length == 6 ? '' : __('label.form.patient.district'))) }}
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($address as $i => $addr)
				<tr>
					<td class="text-center">{{ ++$i }}</td>
					<td>{{ $addr['_name_kh'] }} :: {{ $addr['_name_en'] }}</td>
					<td class="text-center">
						{!! ($code_length < 6) ? '<a href="?addr=' . $addr['_code'] .'"><i class="fa fa-folder-open"></i></a>' : '--' !!}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection