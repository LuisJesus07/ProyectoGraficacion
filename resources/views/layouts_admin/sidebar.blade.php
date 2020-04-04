    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <img alt="image" class="rounded-circle" src="{{ asset('admin_assets/img/user.jpg') }}"/>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="block m-t-xs font-bold">
                                {{ Auth::user()->name }} {{ Auth::user()->lastname }}
                            </span>
                            <span class="text-muted text-xs block">
                                {{ Auth::user()->role_id }}
                            </span>
                        </a> 
                    </div>
                    <div class="logo-element">
                        BCS
                    </div>
                </li> 
 

                <li class="{{ (request()->is('place*')) ? 'active' : '' }}">
                    <a href="{{ url('/places') }}">
                        <i class="fa fa-map-marker fa-2x"></i> 
                        <span class="nav-label">
                            PLACES
                        </span>
                        <!-- <span class="label label-info float-right">
                            62
                        </span> -->
                    </a>
                </li>  
                
                
            </ul>

        </div>
    </nav>