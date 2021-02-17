@can('delete', $country)
    <a href="#user-{{ $country->id }}-delete-model"
       class="btn btn-danger btn-sm"
       data-toggle="modal">
        <i class="feather icon-trash-2" data-toggle="modal"></i>
        &nbsp;Delete </a>

    {{--<a href="#user-{{ $country->id }}-delete-model" class="btn btn-danger btn-sm">--}}
        {{--<i class="feather icon-trash-2" data-toggle="modal"></i>--}}
        {{--&nbsp;Delete </a>--}}


    <!-- Modal -->
    <div class="modal fade" id="user-{{ $country->id }}-delete-model" tabindex="-1" role="dialog"
         aria-labelledby="modal-title-{{ $country->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-{{ $country->id }}">@lang('countries.dialogs.delete.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('countries.dialogs.delete.info')
                </div>
                <div class="modal-footer">
                    {{ BsForm::delete(route('dashboard.admin.countries.destroy', $country)) }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('countries.dialogs.delete.cancel')
                    </button>
                    <button type="submit" class="btn btn-danger">
                        @lang('countries.dialogs.delete.confirm')
                    </button>
                    {{ BsForm::close() }}
                </div>
            </div>
        </div>
    </div>
@else
    <button
        type="button"
        disabled
        class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-user-times"></i>
    </button>
@endcan
