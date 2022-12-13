<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
                    </ul>
                   
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="flag-icon flag-icon-{{App::isLocale('ar') == 'ar' ? 'ae' : 'us'}}"></i>
                        <span class="selected-language">{{App::isLocale('ar') == 'ar'  ? 'العربية' : 'English'}}</span></a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                            @foreach (Locales::$lang as $keyLang => $lang)
                                <a class="dropdown-item"  data-language="{{$keyLang}}" onclick="performSetLocale('{{$keyLang}}')">
                                    <i class="flag-icon flag-icon-{{$lang['flag']}}"></i> {{$lang['name']}}</a>
                            
                            @endforeach
                          
                               
                        </div>
                    </li>
                

                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">{{auth()->user()->name}}</span><span class="user-status">{{__('dash.available')}}</span></div><span>
                                <img class="round" src="{{asset('assets/images/avater.png')}}" alt="avatar" height="40" width="40"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-divider"></div>
                            <form action="{{route('auth.logout')}}" method="post">
                                @csrf
                                <button class="dropdown-item" type="submit"><i class="feather icon-power"></i> {{__('dash.logout')}}</button>
                            </form>
                        
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
