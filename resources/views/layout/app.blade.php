<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  @include('phobrv::template.head')
  @yield('styles')
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    @include('phobrv::template.header')
    @include('phobrv::template.sidebar')
    <div class="content-wrapper">
      <section class="content-header">
        @yield('header')
        @include('phobrv::template.breadcrumb')
      </section>
      <section class="content">
        @include('phobrv::template.error')
        @yield('content')
      </section>
    </div>
    @include('phobrv::template.footer')
  </div>
  @include('phobrv::template.jsScript')
  @yield('scripts')
</body>
</html>
