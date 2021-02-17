@if(isset($can['ability'], $can['model']) && Gate::allows($can['ability'], $can['model'])
                || ! isset($can))

    <li class="nav-item {{ isset($tree) && is_array($tree) ? ' pcoded-hasmenu' : '' }} ">

        <a href="#"
           class="nav-link  {{ isset($isActive) && $isActive ?  ' active' : '' }}">
           {{--class="nav-link  ">--}}

            @isset($icon)
                <span class="pcoded-micon">
                                         <i class="  {{ $icon }}"></i>
                    {{--<i class="feather icon-activity"></i>--}}
                </span>
            @endisset


            <span class="pcoded-mtext">

                 {{ $name }}

            </span>


        </a>

        @if(isset($tree) && is_array($tree) && count($tree))

            <ul class="pcoded-submenu">
                @foreach($tree as $item)
                    @if(isset($item['can']['ability'], $item['can']['model'])
                                           && Gate::allows($item['can']['ability'], $item['can']['model'])
                                           || ! isset($item['can']))
                        <li>
                            <a href="{{ $item['url'] }}">


                                {{ $item['name'] }}


                            </a>

                        </li>


                    @endif
                @endforeach
            </ul>
        @endif

    </li>

@endif
