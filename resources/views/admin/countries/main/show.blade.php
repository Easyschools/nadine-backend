@extends('admin.dashboard.layouts.master')
@section('content')

    <div class="card">
        <div class="card-header">
            <h5>Basic Table</h5>
            <span class="d-block m-t-5">use class <code>table</code> inside table element</span>
        </div>
        <div class="card-body table-border-style table-bordered">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>

                        <th>code</th>
                        <th>name</th>

                    </tr>
                    </thead>
                    <tbody>
                    @if($country)
                        <tr>
                            <td>{{$country->code}}</td>
                            <td>{{$country->name}}</td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
