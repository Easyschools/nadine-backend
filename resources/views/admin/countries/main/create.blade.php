@extends('admin.dashboard.layouts.master', ['title' => trans('countries.actions.create')])
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Basic Component</h5>
        </div>
        <div class="card-body">
            <h5>Form controls</h5>
            <hr>
            <div class="row">
                <div class="col-sm-12">

                    {{ BsForm::resource('countries')->post(route('dashboard.admin.countries.store'), ['files' => true]) }}

                    @include('admin.countries.main.partials.form')

                    {{ BsForm::submit()->label(trans('countries.actions.save')) }}

                </div>
            </div>
        </div>
    </div>

@endsection
