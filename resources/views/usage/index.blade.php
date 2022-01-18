@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-header">
		<b>{!! Auth::user()->subModule() !!}</b>

		<div class="card-tools">
			@can('Usage Create')
			<a href="{{route('usage.create')}}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i> &nbsp;{{ __('label.buttons.create') }}</a>
			@endcan
		</div>

		<!-- Error Message -->
		@component('components.crud_alert')
		@endcomponent
	</div>
	<div class="card-body">
		<table id="datatables" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th width="6%">{!! __('module.table.no') !!}</th>
					<th>{{ __('module.table.name') }}</th>
					<th>{{ __('module.table.description') }}</th>
					<th width="10%">{{ __('module.table.action') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($usages as $i => $usage)
					@php 
						$record_locked = $usage->recordLocked();
					@endphp
					<tr>
						<td class="text-center">{{ ++$i }}</td>
						<td>{!! $record_locked ? '<i class="fa fa-lock fa-fw"></i> ' : '' !!}{{ $usage->name }}</td>
						<td>{{ $usage->description }}</td>
						<td class="text-center">

							@can('Usage Edit')
							<a href="{{ route('usage.edit',$usage->id) }}" class="btn btn-info btn-xs btn-flat" data-toggle="tooltip" data-placement="left" title="{{ __('label.buttons.edit') }}"><i class="fa fa-pencil-alt"></i></a>
							@endcan

							@can('Usage Delete')
								@if (!$record_locked) 
									<button class="btn btn-danger btn-xs btn-flat BtnDelete" value="{{ $usage->id }}" data-toggle="tooltip" data-placement="left" title="{{ __('label.buttons.delete') }}"><i class="fa fa-trash-alt"></i></button>
									{{ Form::open(['url'=>route('usage.destroy', $usage->id), 'id' => 'form-item-'.$usage->id, 'class' => 'sr-only']) }}
									{{ Form::hidden('_method','DELETE') }}
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
	<span class="sr-only" id="deleteAlert" data-title="{{ __('alert.swal.title.delete', ['name' => Auth::user()->module()]) }}" data-text="{{ __('alert.swal.text.unrevertible') }}" data-btnyes="{{ __('alert.swal.button.yes') }}" data-btnno="{{ __('alert.swal.button.no') }}" data-rstitle="{{ __('alert.swal.result.title.success') }}" data-rstext="{{ __('alert.swal.result.text.delete') }}"> Delete Message </span>
</div>
@endsection