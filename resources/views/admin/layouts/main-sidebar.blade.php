<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">


                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="home"></i>
                        <span> {{ __('attributes.dashboard') }} </span>
                    </a>
                </li>


                <li class="menu-title mt-2"></li>


                <li>
                    <a class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}"
                        href="{{ route('admin.contacts.index') }}">
                        <i data-feather="message-circle"></i>
                        @if (App\Models\Contact::where('active', 0)->count())
                            <span
                                class="badge bg-danger float-end">{{ App\Models\Contact::where('active', 0)->count() ?? 0 }}</span>
                        @endif
                        <span> {{ __('attributes.contacts') }} </span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->routeIs('admin.subscription.*') ? 'active' : '' }}"
                        href="{{ route('admin.subscription.index') }}">
                        <i data-feather="bell"></i>
                        @if (App\Models\Subscription::count())
                            <span class="badge bg-success float-end">{{ App\Models\Subscription::count() ?? 0 }}</span>
                        @endif
                        <span> {{ __('attributes.subscriptions') }} </span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                        href="{{ route('admin.orders.index') }}">
                        <i data-feather="shopping-cart"></i>
                        @if (App\Models\Order::where('status', 'pending')->count())
                            <span class="badge bg-danger float-end">{{ App\Models\Order::where('status', 'pending')->count() ?? 0 }}</span>
                        @endif
                        <span>{{ __('attributes.orders') }}</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('admin.cities.*') ? 'active' : '' }}"
                        href="{{ route('admin.cities.index') }}">
                        <i data-feather="map"></i>
                        <span>{{ __('attributes.cities') }}</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('admin.areas.*') ? 'active' : '' }}"
                        href="{{ route('admin.areas.index') }}">
                        <i data-feather="map-pin"></i>
                        <span>{{ __('attributes.area') }}</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}"
                        href="{{ route('admin.sliders.index') }}">
                        <i data-feather="sliders"></i>
                        <span>{{ __('attributes.sliders') }}</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}"
                        href="{{ route('admin.banners.index') }}">
                        <i data-feather="layers"></i>
                        <span>{{ __('attributes.banners') }}</span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                        href="{{ route('admin.categories.index') }}">
                        <i data-feather="layers"></i>
                        <span> {{ __('attributes.categories') }} </span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                        href="{{ route('admin.products.index') }}">
                        <i data-feather="box"></i>
                        <span> {{ __('attributes.products') }} </span>
                    </a>
                </li>

                <li>
                    <a class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                        href="{{ route('admin.settings.edit') }}">
                        <i data-feather="settings"></i>
                        <span>{{ __('attributes.settings') }}</span>
                    </a>
                </li>


            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
