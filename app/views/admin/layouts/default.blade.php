<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{Request::path()}}</title>
        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        @include('admin.partials.css_assets')
        <style type="text/css">
            .error {
            color :red;
            }
        </style>
    </head>
        <body class="no-skin">
            @include('admin.partials.navbar')
            @include('admin.partials.js_assets')
            @include('admin.partials.sidebar')
            <div class="main-content">
                <div class="main-content-inner">
                  @include('admin.partials.messages')
                    @yield('main')
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.main-content-inner -->
            </div><!-- /.main-content -->
            @include('admin.partials.footer')
        </body>
</html>

