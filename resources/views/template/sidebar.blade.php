<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      @auth
      <div class="pull-left image">
       <img src="{{auth()->user()->avatar ?? asset('avatar.png') }}" class="img-circle" alt="User Image">
     </div>
     <div class="pull-left info">
      <p>{{ auth()->user()->name ?? '' }}</p>
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
    @endauth
  </div>
  <ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    @if( count( config('sidebar.menu') ) > 0 )
    @foreach( config('sidebar.menu') as $menu )
    @can($menu['permissions'])
    @if( $menu['children'] )
    @php
    $active = '';
    foreach( $menu['children'] as $submenu ){
      if(Request::is($submenu['href']))
      $active = 'active';
    }
    @endphp
    <li class="treeview {{ $active }} ">
      <a href="#">
        <i class="fa {{ $menu['icon'] }}"></i>
        <span>@lang($menu['title'])</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @foreach( $menu['children'] as $submenu )
        @can($submenu['permissions'])
        <li>
          <a href="{{ url($submenu['href'])}}">
            <i class="fa fa-circle-o"></i>
            @lang($submenu['title'])
          </a>
        </li>
        @endcan
        @endforeach
      </ul>
    </li>
    @else
    <li>
      <a href="{{ url($menu['href'] ) }}">
        <i class="fa {{ $menu['icon'] }}"></i>
        <span>@lang($menu['title'])</span>
      </a>
    </li>
    @endif
    @endcan
    @endforeach
    @endif

  </ul>
</section>
</aside>