@component('admin.dashboard.layouts.components.sidebarItem')
    @slot('url', '#')
    @slot('name', trans('dashboard.home'))
    @slot('icon', 'fas fa-tachometer-alt')
    @slot('routeActive', 'dashboard.home')
@endcomponent
@include('admin.countries.sidebar')

