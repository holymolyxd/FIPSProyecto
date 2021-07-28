<div class="sidebar shadow">
    <div class="section-top">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="{{ url('static/images/logoINACAP.png') }}" alt="INACAP" class="img-fluid">
                </a>
            </div>

            <div class="user">
                <span class="subtitle">Hola:</span>
                <div class="name">
                    {{ Auth::user()->name }}
                    <a href="{{ url('/logout') }}" data-toggle="tooltip" data-placement="top" title="Salir">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
                <div class="email">{{ Auth::user()->email }}</div>
            </div>
        </div>

    <div class="main">
        <ul>
            @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('ver-dashboard') || auth()->user()->hasRole("coordinador") && auth()->user()->hasPermission('ver-dashboard'))
            <li>
                <a href="{{ url('/admin') }}" class="lk-dashboard"><i class="fas fa-home"></i> Dashboard</a>
            </li>
            @endif
            <!--@if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('ver-slider') || auth()->user()->hasRole("coordinador") && auth()->user()->hasPermission('ver-slider'))
            <li>
                <a href="#"><i class="fas fa-paste"></i> Sidebar</a>
            </li>
            @endif
                -->
            @if(auth()->user()->hasRole("administrador") && (auth()->user()->hasPermission('ver-listado-de-roles') || auth()->user()->hasPermission('ver-listado-de-permisos')))
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
               @if(Route::currentRouteName() == "role_list" || Route::currentRouteName() == "role_edit" || Route::currentRouteName() == "role_add"
                    || Route::currentRouteName() == "role_search" || Route::currentRouteName() == "permission_list"|| Route::currentRouteName() == "permission_edit"
                    || Route::currentRouteName() == "permission_add" || Route::currentRouteName() == "role_auditing" || Route::currentRouteName() == "permission_auditing"
                    || Route::currentRouteName() == "permission_search")
               style="background-color:rgb(208, 0, 0); color: #ffffff !important;"
                @endif>
                <i class="fas fa-key"></i>
                Autorizaciones
            </a>
            <ul class="collapse" id="homeSubmenu">
                @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('ver-listado-de-roles'))
                <li>
                    <a href="{{ url('/admin/roles/1') }}" class="lk-role_list lk-role_edit lk-role_add lk-role_search lk-role_auditing"><i class="fas fa-user-tag"></i> Roles</a>
                </li>
                @endif
                @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('ver-listado-de-permisos'))
                <li>
                    <a href="{{ url('/admin/permissions/1') }}" class="lk-permission_list lk-permission_edit lk-permission_add lk-permission_search lk-permission_auditing"><i class="fas fa-address-card"></i> Permisos</a>
                </li>
                @endif
            </ul>
            @endif
            @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('ver-listado-de-usuarios'))
            <li>
                <a href="{{ url('/admin/users/1') }}" class="lk-user_list lk-user_edit lk-user_add lk-user_permissions lk-user_search"><i class="fas fa-users"></i> Usuarios</a>
            </li>
            @endif
            <li>
                <a href="{{ url('/admin/posts') }}" class="lk-posts_list lk-posts_search lk-posts_auditing lk-post_edit"><i class="fab fa-product-hunt"></i> Publicaciones</a>
            </li>
            <li>
                <a href="{{ url('/admin/comments') }}" class="lk-comments_list lk-comment_edit lk-comment_auditing lk-comment_search"><i class="fas fa-comments"></i> Comentarios</a>
            </li>
            <!--
            <a href="#homeSubmenuRegions" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
               @if(Route::currentRouteName() == "region_list" || Route::currentRouteName() == "commune_list")
               style="background-color:rgb(208, 0, 0); color: #ffffff !important;"
                @endif>
                <i class="fas fa-atlas"></i>
                Localizaciones
            </a>
                <ul class="collapse" id="homeSubmenuRegions">
                    <li>
                        <a href="{{ url('/admin/regions') }}" class="lk-region_list"><i class="far fa-bookmark"></i> Regiones</a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/communes') }}" class="lk-commune_list"><i class="fas fa-location-arrow"></i> Comunas</a>
                    </li>
                </ul>
            -->
        </ul>
    </div>
</div>
