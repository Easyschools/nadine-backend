{{--@can('update', $country)--}}
    <a href="{{ route('dashboard.admin.countries.edit', $country) }}" class="btn btn-info btn-sm">
        <i class="feather icon-edit"></i>
        &nbsp;Edit
    </a>
{{--@endcan--}}
