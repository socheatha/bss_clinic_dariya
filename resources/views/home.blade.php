@extends('layouts.app')

@section('content')
	<div class="row">
		@foreach ($list_panel as $panel)
			@if ($panel['is_allowed'])
				<div class="col-lg-3 col-6">
					<div class="small-box" style="background-color: {{ $panel['color'] }}; color: #eee;">
						<div class="inner">
							<h3>{{ $panel['count'] }}</h3>
							<p>{{ $panel['label'] }}</p>
						</div>
						<div class="icon">
							<i class="{{ $panel['icon'] }}"></i>
						</div>
						<a href="{{ $panel['route'] }}" class="small-box-footer">{{ __('label.buttons.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
			@endif
		@endforeach

	{{-- <div class="card">
		<div class="card-header">
			{{ __('Dashboard') }}
			
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i></button>
				<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
					<i class="fas fa-times"></i></button>
			</div>
		</div>

		<div class="card-body">

		</div>
	</div> --}}
@endsection