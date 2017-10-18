		<div class="{{ $sidebarSmCols }} {{ $sidebarMdCols }} {{ $sidebarLgCols }} {{ $sidebarXlCols }} sidebar">
			<h3>{{ $currentUser->first_name }} {{ $currentUser->last_name }}</h3>
			<h4 class="text-uppercase extra-breathing-space">Administration</h4>
			<ul class="list-unstyled">
				<li class="{{ setActive('cp/dashboard') }}"><a href="/cp/dashboard" title=""><i class="text-center icon fa fa-tachometer" aria-hidden="true"></i>Dashboard</a></li>
				@if ($currentUser->hasPermission('view_companies'))
					<li class="{{ setActive('cp/companies') }}"><a href="/cp/companies" title="Companies"><i class="text-center icon fa fa-building" aria-hidden="true"></i>Companies</a></li>
				@endif
				@if ($currentUser->hasPermission('view_users'))
					<li class="{{ setActive('cp/users') }}"><a href="/cp/users" title="Users"><i class="text-center icon fa fa-users" aria-hidden="true"></i>Users</a></li>
				@endif
				@if ($currentUser->hasPermission('view_locations'))
					<li class="{{ setActive('cp/locations') }}"><a href="/cp/locations" title="Locations"><i class="text-center icon fa fa-map-marker" aria-hidden="true"></i>Locations</a></li>
				@endif
				@if ($currentUser->hasPermission('view_orders'))
					<li class="{{ setActive('cp/orders') }}"><a href="/cp/orders" title="Orders"><i class="text-center icon fa fa-shopping-cart" aria-hidden="true"></i>Orders</a></li>
				@endif
				@if ($currentUser->hasPermission('view_carts'))
					<li class="{{ setActive('cp/carts') }}"><a href="/cp/carts" title="Carts"><i class="text-center icon fa fa-cart-plus" aria-hidden="true"></i>Carts</a></li>
				@endif
				@if ($currentUser->hasPermission('view_articles') || $currentUser->hasPermission('view_article_categories'))	
					<li>
						<a href="javascript:void(0);" title="Articles" rel="nofollow" id="submenu" class="{{ setClass('cp/articles', 'highlight') }}"><i class="text-center icon fa fa-newspaper-o" aria-hidden="true"></i>Articles<span class="pull-right"><i class="fa fa-angle-left {{ setClass('cp/articles', 'fa-rotate') }}" aria-hidden="true"></i></span></a>
						<ul class="list-unstyled {{ setClass('cp/articles', 'open') }}">
							@php($id = request()->id)
							@if ($currentUser->hasPermission('view_articles'))	
								<li class="{{ setActive(['cp/articles/all', 'cp/articles/create', 'cp/articles/'.$id.'/edit', 'cp/articles/'.$id.'/delete']) }}"><a href="/cp/articles" title="Articles"><i class="text-center icon fa fa-circle-o" aria-hidden="true"></i>Articles</a></li>
							@endif
							@if ($currentUser->hasPermission('view_article_categories'))	
								<li class="{{ setActive('cp/articles/categories') }}"><a href="/cp/articles/categories" title="Article Categories"><i class="text-center icon fa fa-circle-o" aria-hidden="true"></i>Article Categories</a></li>
							@endif
						</ul>
					</li>
				@endif
				@if ($currentUser->hasPermission('view_assets'))	
					<li class="{{ setActive('cp/assets') }}"><a href="/cp/assets" title="Assets"><i class="text-center icon fa fa-folder-open" aria-hidden="true"></i>Assets</a></li>
				@endif
				@if ($currentUser->hasPermission('view_carousels'))	
					<li class="{{ setActive('cp/carousels') }}"><a href="/cp/carousels" title="Carousels"><i class="text-center icon fa fa-picture-o" aria-hidden="true"></i>Carousels</a></li>
				@endif
				@if ($currentUser->hasPermission('view_templates'))
					<li class="{{ setActive('cp/templates') }}"><a href="/cp/templates" title="Templates"><i class="text-center icon fa fa-columns" aria-hidden="true"></i>Templates</a></li>
				@endif
				@if ($currentUser->hasPermission('view_pages'))
					<li class="{{ setActive('cp/pages') }}"><a href="/cp/pages" title="Pages"><i class="text-center icon fa fa-file" aria-hidden="true"></i>Pages</a></li>
				@endif
				@if ($currentUser->hasPermission('edit_pages'))
					<li class="{{ setActive('cp/menu') }}"><a href="/cp/menu" title="Menu"><i class="text-center icon fa fa-list" aria-hidden="true"></i>Menu</a></li>
				@endif
				@if ($currentUser->hasPermission('view_globals'))
					<li class="{{ setActive('cp/globals') }}"><a href="/cp/globals" title="Globals"><i class="text-center icon fa fa-globe" aria-hidden="true"></i>Globals</a></li>
				@endif
				@if ($currentUser->hasPermission('view_roles') || $currentUser->hasPermission('view_permissions') || $currentUser->hasPermission('view_statuses'))
					<li>
						<a href="javascript:void(0);" title="Advanced" rel="nofollow" id="submenu" class="{{ setClass('cp/advanced', 'highlight') }}"><i class="text-center icon fa fa-cogs" aria-hidden="true"></i>Advanced<span class="pull-right"><i class="fa fa-angle-left {{ setClass('cp/advanced', 'fa-rotate') }}" aria-hidden="true"></i></span></a>
						<ul class="list-unstyled {{ setClass('cp/advanced', 'open') }}">
							@if ($currentUser->hasPermission('view_roles'))
								<li class="{{ setActive('cp/advanced/roles') }}"><a href="/cp/advanced/roles" title="Roles"><i class="text-center icon fa fa-circle-o" aria-hidden="true"></i>Roles</a></li>
							@endif	
							@if ($currentUser->hasPermission('view_permissions'))
								<li class="{{ setActive('cp/advanced/permissions') }}"><a href="/cp/advanced/permissions" title="Permissions"><i class="text-center icon fa fa-circle-o" aria-hidden="true"></i>Permissions</a></li>
							@endif	
							@if ($currentUser->hasPermission('view_statuses'))
								<li class="{{ setActive('cp/advanced/statuses') }}"><a href="/cp/advanced/statuses" title="Statuses"><i class="text-center icon fa fa-circle-o" aria-hidden="true"></i>Statuses</a></li>
							@endif	
						</ul>
					</li>
				@endif
			</ul>
			<h4 class="text-uppercase">User</h4>
			<ul class="list-unstyled">
				@if ($currentUser->canReceiveNotifications())
					<li class="{{ setActive('cp/users/'.$currentUser->id.'/notifications') }}"><a href="/cp/users/{{ $currentUser->id }}/notifications" title="Notifications"><i class="text-center icon fa fa-commenting" aria-hidden="true"></i>Messages&nbsp;<span id="notifications-unread" class="float-right badge badge-pill badge-suspended{{ ($currentUser->unreadNotifications->count() == 0) ? ' hidden' : '' }}" style="margin-top: 3px;padding-left: 8px;padding-right: 8px;">{{ $currentUser->unreadNotifications->count() }}</span></a></li>
				@endif
				<li class="{{ setActive('cp/users/'.$currentUser->id.'/edit/password') }}"><a href="/cp/users/{{ $currentUser->id }}/edit/password" title="Change Password"><i class="text-center icon fa fa-key" aria-hidden="true"></i>Change Password</a></li>
				<li class="{{ setActive('cp/users/'.$currentUser->id.'/edit/settings') }}"><a href="/cp/users/{{ $currentUser->id }}/edit/settings" title="Settings"><i class="text-center icon fa fa-sliders" aria-hidden="true"></i>Settings</a></li>
				<li><a href="javascript:void(0);" title="Logout" id="logout"><i class="text-center icon fa fa-sign-out" aria-hidden="true"></i>Logout</a></li>
			</ul>
			<form name="logoutUser" id="logoutUser" class="logoutUser" action="/logout" method="POST" style="display: none;">
				{{ csrf_field() }}
			</form>
		</div>
		