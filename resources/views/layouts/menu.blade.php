@php
    $data_fitur = session("akses")->toArray();
    $arr = [];
    $jumlahmenu = count($data_fitur);
@endphp

@foreach ($data_fitur as $row)
    @php
        $arr[$row->KelompokFitur][] = $row;
    @endphp
@endforeach
<div id="sidebar-menu" class="sidebar-menu">
    <ul>
        @if ($jumlahmenu > 20)
            <li class="{{ request()->is("home") ? "active" : "" }}">
                <a href="{{ route("home") }}"><i class="feather-home"></i> <span>Dashboard</span></a>
                <div class="out-circle"></div>
            </li>
            @foreach ($arr as $key => $val)
                @php
                    $jumlahsub = count($val);
                @endphp
                @if ($jumlahsub > 1)
                    @php
                        $li_active = 'class="submenu"';
                        $anchor_active = 'class="subdrop"';
                        $ul_active = 'style="display: none;"';
                    @endphp
                    @foreach ($val as $k => $v)
                        @if (strtolower(@$menu) == strtolower($v->NamaFitur))
                            @php
                                $li_active = 'class="submenu active"';
                                $anchor_active = 'class="active subdrop"';
                                $ul_active = 'style="display: block;"';
                                break;
                            @endphp
                        @endif
                    @endforeach
                    <li {!! $li_active !!}>
                        <a href="#" {!! $anchor_active !!}><i class="{{ @$val[0]->Icon }}"></i>
                            <span>{{ ucwords(strtolower($key)) }}</span> <span class="menu-arrow"></span></a>
                        <ul {!! $ul_active !!}>
                            @foreach ($val as $k => $v)
                                @php
                                    $active = strtolower(@$menu) == strtolower($v->NamaFitur) ? 'class="active"' : "";
                                    $url = @$v->Slug ?? "home";
                                @endphp

                                <li>
                                    <a {!! $active !!} href="{{ url($url) }}">{{ $v->NamaFitur }}</a>
                                    <div class="out-circle"></div>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    @foreach ($val as $k => $v)
                        @php
                            $active = strtolower(@$menu) == strtolower($v->NamaFitur) ? 'class="active"' : "";
                            $url = @$v->Slug ?? "home";
                        @endphp

                        <li {!! $active !!}>
                            <a href="{{ url($url) }}"><i class="{{ $v->Icon }}"></i>
                                <span>{{ $v->NamaFitur }}</span></a>
                                <div class="out-circle"></div>
                        </li>
                    @endforeach
                @endif
            @endforeach
        @else
            <li class="menu-title">
                <span>MAIN MENU</span>
            </li>
            <li class="{{ request()->is("home") ? "active" : "" }}">
                <a href="{{ route("home") }}"><i class="feather-home"></i> <span>Dashboard</span></a>
                <div class="out-circle"></div>
            </li>
            @foreach ($arr as $key => $val)
                @php
                    $jumlahsub = count($val);
                @endphp
                @if ($jumlahsub > 1)
                    <li class="menu-title">
                        <span>{{ strtoupper($key) }}</span>
                        <div class="out-circle"></div>
                    </li>
                @endif
                @foreach ($val as $k => $v)
                    @php
                        $active = strtolower(@$menu) == strtolower($v->NamaFitur) ? 'class="active"' : "";
                        $url = @$v->Slug ?? "home";
                    @endphp

                    <li {!! $active !!}>
                        <a href="{{ url($url) }}"><i class="{{ $v->Icon }}"></i>
                            <span>{{ $v->NamaFitur }}</span></a>
                            <div class="out-circle"></div>
                    </li>
                @endforeach
            @endforeach
        @endif
    </ul>
</div>
