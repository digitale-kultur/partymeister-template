<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>PAGE TITLE</title>

    <link href="{{ mix('/css/motor-frontend.css') }}" rel="stylesheet" type="text/css"/>
    <link href="/css/evoke2022.css" rel="stylesheet" type="text/css"/>

    <!-- Custom styles for this template -->
    @yield('view_styles')
    <style type="text/css">
    </style>
</head>
<body>
@include('motor-cms::layouts.frontend.partials.navigation')
<div class="grid-container">
    @include('motor-cms::layouts.frontend.partials.template-sections', ['rows' => $template['items']])
</div>

<script src="{{mix('js/motor-frontend.js')}}"></script>
@yield('view-scripts')
<script>
    $(document).foundation();
</script>
</body>
</html>
