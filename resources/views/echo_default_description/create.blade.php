@extends('layouts.app')

@section('css')
	<style class="text/css">
		label[for="father_status1"],
		label[for="father_status0"],
		label[for="mother_status1"],
		label[for="mother_status0"] {
			cursor: pointer;
		}
	</style>
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<b>{!! Auth::user()->subModule() !!}</b>

		<div class="card-tools">
			@can('Echo Default Description Index')
			<a href="{{route('echo_default_description.index')}}" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-table"></i> &nbsp;{{ __('label.buttons.back_to_list', [ 'name' => Auth::user()->module() ]) }}</a>
			@endcan
		</div>

		<!-- Error Message -->
		@component('components.crud_alert')
		@endcomponent
	</div>
	{!! Form::open(['url' => route('echo_default_description.store'),'method' => 'post','autocomplete'=>'off']) !!}
		<div class="card-body">
			@include('echo_default_description.form')
		</div>

		<div class="card-footer text-muted text-center">
			@include('components.submit')
		</div>
	{{ Form::close() }}

</div>
<br />
<br />
<br />
<br />
@endsection
@section('js')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
	$('.my-editor').each(function(e) {
		CKEDITOR.replace(this.id, {
			height: '750',
			font_names: 'Calibrib Bold; Calibri Italic; Calibri; Roboto Regular; Roboto Bold; Khmer OS Battambang; Khmer OS Muol Light; Khmer OS Content; Khmer OS Kuolen;',
			toolbar: [{
					name: 'basicstyles',
					groups: ['basicstyles', 'cleanup'],
					items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat']
				},
				{
					name: 'paragraph',
					groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
					items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
				},
				{
					name: 'document',
					groups: ['mode', 'document', 'doctools'],
					items: ['Source', '-', 'Save', 'NewPage', 'ExportPdf', 'Preview', 'Print', '-', 'Templates']
				},
				{
					name: 'insert',
					items: ['Table']
				},
				{
					name: 'styles',
					items: ['Styles', 'Format', 'Font', 'FontSize']
				},
				{
					name: 'colors',
					items: ['TextColor', 'BGColor']
				},
				{
					name: 'clipboard',
					groups: ['clipboard', 'undo']
				},
			]
		});
	});
</script>
@endsection