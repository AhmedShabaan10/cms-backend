        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">

                <div class="navbar-nav theme-brand flex-row  text-center">
                    <div class="nav-logo">
                        <div class="nav-item theme-logo">
                            <a href="{{ route('dashboard') }}">
                                <img src="{{ asset('src/assets/img/logo.svg') }}" class="navbar-logo" alt="logo"> </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="{{ route('dashboard') }}" class="nav-link"> CMS </a>
                        </div>
                    </div>
                    <div class="nav-item sidebar-toggle">
                        <div class="btn-toggle sidebarCollapse" id="sidebar-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevrons-left">
                                <polyline points="11 17 6 12 11 7"></polyline>
                                <polyline points="18 17 13 12 18 7"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">

                    @php
                        $currentRoute = Route::currentRouteName();
                        $isActive = in_array($currentRoute, ['dashboard']);
                    @endphp
                    <li class="menu {{ $isActive ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <span>Dashboard</span>
                            </div>
                        </a>
                    </li>

                    @php
                        $currentRoute = Route::currentRouteName();
                        $currentRouteBase = explode('.', $currentRoute)[0];
                        $isActive = in_array($currentRouteBase, ['profile']);
                    @endphp
                    @if (Auth::user()->is_super_admin || Auth::user()->hasPermission('users-list'))
                        <li class="menu {{ $isActive ? 'active' : '' }}">
                        <a href="#user-management" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle">
                            
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="-0.645 -0.645 18 18"
                                        id="User-Circle-Single--Streamline-Core" height="18" width="18">
                                        <desc>User Circle Single Streamline Icon: https://streamlinehq.com</desc>
                                        <g id="user-circle-single--circle-geometric-human-person-single-user">
                                            <path id="Vector" fill="#ffffffcc"
                                                d="M8.355 9.54857142857143c1.6479760071428575 0 2.9839285714285717 -1.3359525642857144 2.9839285714285717 -2.9839285714285717S10.002976007142859 3.5807142857142864 8.355 3.5807142857142864 5.37107142857143 4.916666850000001 5.37107142857143 6.564642857142858 6.7070239928571445 9.54857142857143 8.355 9.54857142857143Z"
                                                stroke-width="1.29"></path>
                                            <path id="Intersect" fill="#ffffffcc"
                                                d="M13.453221000000001 14.203022571428573C12.089804357142858 15.392655214285716 10.306572835714288 16.11321428571429 8.355011935714286 16.11321428571429c-1.951572835714286 0 -3.7348401642857145 -0.7205590714285716 -5.098256807142858 -1.9101917142857145C4.304591485714286 12.485473285714287 6.1958889642857145 11.338928571428573 8.355011935714286 11.338928571428573c2.159111035714286 0 4.0503727071428575 1.1465447142857144 5.098209064285715 2.864094Z"
                                                stroke-width="1.29"></path>
                                            <path id="Subtract" fill="#fefeffd1" fill-rule="evenodd"
                                                d="M3.2567431928571433 14.203022571428573C4.304579550000001 12.485473285714287 6.1958889642857145 11.338928571428573 8.355 11.338928571428573c2.159111035714286 0 4.050384642857144 1.1465447142857144 5.098221000000001 2.864094C15.083281500000002 12.780762857142859 16.11321428571429 10.688181492857144 16.11321428571429 8.355 16.11321428571429 4.070257607142858 12.639802071428573 0.5967857142857144 8.355 0.5967857142857144 4.070257607142858 0.5967857142857144 0.5967857142857144 4.070257607142858 0.5967857142857144 8.355c0 2.3331814928571433 1.029932785714286 4.425762857142858 2.659957478571429 5.848022571428572ZM8.355 9.54857142857143c1.6479760071428575 0 2.9839285714285717 -1.3359525642857144 2.9839285714285717 -2.9839285714285717S10.002976007142859 3.5807142857142864 8.355 3.5807142857142864 5.37107142857143 4.916666850000001 5.37107142857143 6.564642857142858 6.7070239928571445 9.54857142857143 8.355 9.54857142857143Z"
                                                clip-rule="evenodd" stroke-width="1.29"></path>
                                            <path id="Vector_2" stroke="#222222" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M8.355 9.54857142857143c1.6479760071428575 0 2.9839285714285717 -1.3359525642857144 2.9839285714285717 -2.9839285714285717S10.002976007142859 3.5807142857142864 8.355 3.5807142857142864 5.37107142857143 4.916666850000001 5.37107142857143 6.564642857142858 6.7070239928571445 9.54857142857143 8.355 9.54857142857143Z"
                                                stroke-width="1.29"></path>
                                            <path id="Vector_3" stroke="#222222" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M3.2584261285714287 14.203500000000002c0.5326193142857144 -0.8742910714285715 1.2811915071428572 -1.5968792142857147 2.1737442214285716 -2.0981792142857145 0.8925527142857145 -0.5014193571428571 1.899067628571429 -0.7647689571428572 2.9228057785714285 -0.7647689571428572 1.02373815 0 2.0302530642857146 0.2633496 2.9228057785714285 0.7647689571428572 0.8925885214285716 0.5013000000000001 1.6410771642857145 1.223888142857143 2.1737680928571432 2.0981792142857145"
                                                stroke-width="1.29"></path>
                                            <path id="Vector_4" stroke="#222222" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M8.355 16.11321428571429c4.284802071428572 0 7.758214285714287 -3.4734122142857147 7.758214285714287 -7.758214285714287C16.11321428571429 4.070257607142858 12.639802071428573 0.5967857142857144 8.355 0.5967857142857144 4.070257607142858 0.5967857142857144 0.5967857142857144 4.070257607142858 0.5967857142857144 8.355c0 4.284802071428572 3.473471892857143 7.758214285714287 7.758214285714287 7.758214285714287Z"
                                                stroke-width="1.29"></path>
                                        </g>
                                    </svg>
                                    <span>User Management</span>
                                </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="user-management"
                            data-bs-parent="#accordionExample">
                            <li class="{{ $currentRouteBase == 'users' ? 'active' : '' }}">
                                @if (Auth::user()->is_super_admin || Auth::user()->hasPermission('users-list'))
                                    <a href="{{ route('users.list') }}"> Users </a>
                                @endif
                            </li>
                            <li class="{{ $currentRouteBase == 'roles' ? 'active' : '' }}">
                                @if (Auth::user()->is_super_admin || Auth::user()->hasPermission('roles-list'))
                                    <a href="{{ route('roles.list') }}"> Roles </a>
                                @endif
                            </li>
                        </ul>
                        </li>
                    @endif

                    @if (Auth::user()->is_super_admin || Auth::user()->hasPermission('products-list'))
                        <li class="menu {{ $isActive ? 'active' : '' }}">
                            <a href="#product-management" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <div class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="24" height="24">
                                            <desc>Box Product Streamline Style</desc>
                                                <g stroke="#222222" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path fill="#ffffffcc" d="M3 7l9 5 9-5" />
                                                    <path fill="#ffffffcc" d="M3 7v10l9 5 9-5V7" />
                                                    <path d="M12 22V12" />
                                                </g>
                                        </svg>
                                        <span>Manage Products</span>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-chevron-right">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </div>
                            </a>
                            <ul class="collapse submenu list-unstyled" id="product-management" data-bs-parent="#accordionExample">
                                <li class="{{ $currentRouteBase == 'products' ? 'active' : '' }}">
                                    @if (Auth::user()->is_super_admin || Auth::user()->hasPermission('products-list'))
                                        <a href="{{ route('list.products') }}"> Products </a>
                                    @endif
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->is_super_admin || Auth::user()->hasPermission('orders-list'))
                        <li class="menu {{ $currentRouteBase == 'orders' ? 'active' : '' }}">
                            <a href="#order-management" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="24" height="24">
                                        <desc>Shopping Cart Streamline Style</desc>
                                        <g stroke="#222222" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="9" cy="21" r="1.5" fill="#ffffffcc" />
                                            <circle cx="18" cy="21" r="1.5" fill="#ffffffcc" />
                                            <path fill="#ffffffcc" d="M2 2h2l3.6 7.59a1 1 0 00.92.61h8.98a1 1 0 00.96-.74l1.54-5.5H6" />
                                            <path d="M10 14h7a1 1 0 001-1v-2" />
                                        </g>
                                    </svg>
                                    <span>Manage Orders</span>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-chevron-right">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </div>
                            </a>
                            <ul class="collapse submenu list-unstyled" id="order-management" data-bs-parent="#accordionExample">
                                <li class="{{ $currentRouteBase == 'orders' ? 'active' : '' }}">
                                    @if (Auth::user()->is_super_admin || Auth::user()->hasPermission('orders-list'))
                                        <a href="{{ route('list.orders') }}"> Orders </a>
                                    @endif
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
        <!--  END SIDEBAR  -->
