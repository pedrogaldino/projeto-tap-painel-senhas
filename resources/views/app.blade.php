@extends('layout')

@push('head')
    <script type="text/javascript">
        (function(d, t) {
            var g = d.createElement(t),
                s = d.getElementsByTagName(t)[0];
            g.src = "https://cdn.pushalert.co/integrate_bc058b9dd8d0f5beb190ac4d265fa619.js";
            s.parentNode.insertBefore(g, s);
        }(document, "script"));
    </script>
@endpush

@section('content')

    <notification-component senha="{{ request('senha') }}"></notification-component>

@endsection
