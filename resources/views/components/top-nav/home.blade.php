<nav class="navbar navbar-sm navbar-expand-lg navbar-fixed navbar-white">
    <div class="navbar-inner shadow-md">
        <div class="ml-25 mr-25 d-flex h-100 justify-content-xl-between align-items-center">
            <!-- the small Dashboard selection menu -->
            <div class="d-inline-flex">
                <h2 class="d-xl-inline-block text-140 font-bold text-dark-m2 mb-0 pb-1">
                    Apps <span class="text-80 font-normal"><i>0.1.0</i></span>
                </h2>
            </div>
        </div>


        <div class=" navbar-menu collapse navbar-collapse navbar-backdrop" id="navbarMenu2">
            <div class="navbar-nav navbar-links">
                <ul class="nav">
                    <li class="nav-item mx-2">
                        <a href="{{ route('home') }}"
                            class="
                btn 
                btn-a-bold 
                btn-outline-secondary 
                btn-h-lighter-secondary
                btn-brc-tp 
                px-4 px-lg-2  
                {{ request()->routeIs('home') ? 'btn-a-outline-primary bgc-h-primary-l4 btn-a-bgc-tp active' : 'btn-a-lighter-secondary' }}">
                            Home
                        </a>
                    </li>
                    @can('manage', App\Models\HubLink::class)
                        <li class="nav-item mx-2">
                            <a href="{{ route('hublinks.index') }}" class="
                            btn 
                            btn-a-bold                 
                            btn-outline-secondary 
                            btn-h-lighter-secondary 
                            btn-brc-tp 
                            px-4 px-lg-2
                            {{ request()->routeIs('hublinks.*') ? 'btn-a-outline-primary bgc-h-primary-l4 btn-a-bgc-tp active' : 'btn-a-lighter-secondary' }}
                            ">
                                Links Manager
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>

        <div class="ml-auto mr-xl-3 navbar-menu collapse navbar-collapse navbar-backdrop" id="navbarMenu">
        </div>

    </div>
</nav>