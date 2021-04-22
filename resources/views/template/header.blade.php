<header class="main-header">
  <a href="index2.html" class="logo">
    <span class="logo-mini"><b>A</b>MP</span>
    <span class="logo-lg"><b>Admin</b>Page</span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>
    <div class="navbar-custom-menu">
    {{-- @auth --}}
     <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          @if(config('app.locale') == 'vi')
          <img src="{{asset('img/vi.png')}}" alt="">
          @else
          <img src="{{asset('img/en.png')}}" alt="">
          @endif
           <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{route('lang',['lang'=>'en'])}}">English</a></li>
            <li><a href="{{route('lang',['lang'=>'vi'])}}">Tiếng Việt</a></li>
            
          </ul>
        </li>
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            @isset(auth()->user()->avatar)
            <img src="{{auth()->user()->avatar}}" class="user-image" alt="User Image">
            @endif
            <span class="hidden-xs">{{ auth()->user()->name ?? '' }}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              @isset(auth()->user()->avatar)
              <img src="{{auth()->user()->avatar}}" class="img-circle" alt="User Image">
              @else
              <img src="{{asset('avatar.png')}}" class="img-circle" alt="User Image">
              @endif
              <p>
                {{ auth()->user()->name ?? ''  }}
                @auth
                <small>Member since {{date('m-Y',strtotime(auth()->user()->created_ad))}}</small>
                @endauth
              </p>
            </li>
            
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{route('profile.show')}}" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </div>
            </li>
          </ul>
        </li>
      </ul>
      {{-- @endauth --}}
    </div>
  </nav>
</header>