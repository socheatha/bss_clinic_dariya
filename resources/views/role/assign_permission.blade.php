@extends('layouts.app')

@section('css')
<style type="text/css">
  option {
    height: 35px;
    /* margin: */
    line-height: 2em;
    padding: 7px 10px;
  }
</style>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <b>{!! Auth::user()->subModule() !!}</b>

    <div class="card-tools">
      <a href="{{route('role.index')}}" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-table"></i> &nbsp;{{ __('label.buttons.back_to_list', [ 'name' => Auth::user()->module() ]) }}</a>
    </div>

    <!-- Error Message -->
    @component('components.crud_alert')
    @endcomponent
  </div>
  {!! Form::open(['url' => route('role.update_assign_permission', $role->id),'method' => 'post','class' => 'mt-3']) !!}
    {!! Form::hidden('_method', 'PUT') !!}
    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <div class="form-group">
            {{-- {!! Html::decode(Form::label('role', __('label.form.user.role')." <small>*</small>")) !!} --}}
            <select class="duallistbox" multiple="multiple" name="permission[]">
              @foreach ($permissions as $permission)
                @if (in_array($permission->id, $permission_existed))
                  <option selected value="{{ $permission->name }}">{{ $permission->name }}</option>
                @else
                  <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-muted text-center">
      @include('components.submit')
    </div>
  {{ Form::close() }}
</div>
@endsection