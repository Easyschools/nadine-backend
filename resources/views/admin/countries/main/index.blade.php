@extends('admin.dashboard.layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                {{ trans('cruds.city.title_singular') }} {{ trans('global.list') }}
            </h5>
        </div>


        <div class="card-body">

            @include('admin.countries.main.partials.actions.create')
            <div class="table-responsive">
                <div id="report-table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="report-table_length"><label>Show <select
                                        name="report-table_length" aria-controls="report-table"
                                        class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> entries</label></div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="report-table_filter" class="dataTables_filter"><label>Search:<input type="search"
                                                                                                         class="form-control form-control-sm"
                                                                                                         placeholder=""
                                                                                                         aria-controls="report-table"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="report-table" class="table table-bordered table-striped mb-0 dataTable no-footer"
                                   role="grid" aria-describedby="report-table_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="report-table" rowspan="1"
                                        colspan="1" aria-sort="ascending"
                                        aria-label="Icon: activate to sort column descending" style="width: 33px;">Icon
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="report-table" rowspan="1"
                                        colspan="1" aria-label="Name: activate to sort column ascending"
                                        style="width: 96px;">Name
                                    </th>
                                    <th width="50%" class="sorting" tabindex="0" aria-controls="report-table"
                                        rowspan="1" colspan="1"
                                        aria-label="Description: activate to sort column ascending"
                                        style="width: 355px;">Description
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="report-table" rowspan="1"
                                        colspan="1" aria-label="Options: activate to sort column ascending"
                                        style="width: 262px;">Options
                                    </th>
                                </tr>
                                </thead>
                                <tbody>


                                @forelse($countries as $country)
                                    <tr role="row" class="odd">
                                        <td>Tokyo</td>
                                        <td class="sorting_1">{{$country->name}}</td>
                                        <td>{{$country->code}}</td>

                                        <td>
                                            <a href="{{url(route('dashboard.admin.countries.show',$country))}}"
                                               class="btn btn-primary btn-sm">
                                                <i class="feather icon-plus"></i>
                                                show
                                            </a>
                                            @include('admin.countries.main.partials.actions.edit')
                                            @include('admin.countries.main.partials.actions.delete')
                                            {{--<a href="#!" class="btn btn-info btn-sm"><i class="feather icon-edit"></i>&nbsp;Edit--}}
                                            {{--</a>--}}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="report-table_info" role="status" aria-live="polite">Showing
                                1 to 5 of 5 entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="report-table_paginate">
                                <ul class="pagination">
                                    <li class="paginate_button page-item previous disabled" id="report-table_previous">
                                        <a href="#" aria-controls="report-table" data-dt-idx="0" tabindex="0"
                                           class="page-link">Previous</a></li>
                                    <li class="paginate_button page-item active"><a href="#"
                                                                                    aria-controls="report-table"
                                                                                    data-dt-idx="1" tabindex="0"
                                                                                    class="page-link">1</a></li>
                                    <li class="paginate_button page-item next disabled" id="report-table_next"><a
                                            href="#" aria-controls="report-table" data-dt-idx="2" tabindex="0"
                                            class="page-link">Next</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>




@endsection

