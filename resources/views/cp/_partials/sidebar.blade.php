		<div class="{{ $sidebarSmCols }} {{ $sidebarMdCols }} {{ $sidebarLgCols }} sidebar">
			<h3>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
			<h4 class="text-uppercase">Administration</h4>
			<ul class="list-unstyled">
				<li class="{{ setActive('cp/dashboard') }}"><a href="/cp/dashboard" title=""><i class="text-center icon fa fa-tachometer" aria-hidden="true"></i>Dashboard</a></li>
				<li class="{{ setActive('cp/companies') }}"><a href="/cp/companies" title="Companies"><i class="text-center icon fa fa-building" aria-hidden="true"></i>Companies</a></li>
				<li class="{{ setActive('cp/users') }}"><a href="/cp/users" title="Users"><i class="text-center icon fa fa-users" aria-hidden="true"></i>Users</a></li>
				<li class="{{ setActive('cp/locations') }}"><a href="/cp/locations" title="Locations"><i class="text-center icon fa fa-map-marker" aria-hidden="true"></i>Locations</a></li>
				<li class="{{ setActive('cp/orders') }}"><a href="/cp/orders" title="Orders"><i class="text-center icon fa fa-shopping-cart" aria-hidden="true"></i>Orders</a></li>
				<li class="{{ setActive('cp/articles') }}"><a href="/cp/articles" title="Articles"><i class="text-center icon fa fa-newspaper-o" aria-hidden="true"></i>Articles</a></li>
				<li class="{{ setActive('cp/assets') }}"><a href="/cp/assets" title="Assets"><i class="text-center icon fa fa-folder-open" aria-hidden="true"></i>Assets</a></li>
				<li class="{{ setActive('cp/pages') }}"><a href="/cp/pages" title="Pages"><i class="text-center icon fa fa-file" aria-hidden="true"></i>Pages</a></li>
				<li class="{{ setActive('cp/menu') }}"><a href="/cp/menu" title="Menu"><i class="text-center icon fa fa-list" aria-hidden="true"></i>Menu</a></li>
				<li>
					<a href="javascript:void(0);" title="Advanced" id="advanced" class="{{ setClass('cp/advanced', 'highlight') }}"><i class="text-center icon fa fa-cogs" aria-hidden="true"></i>Advanced<span class="pull-right"><i class="fa fa-angle-left {{ setClass('cp/advanced', 'fa-rotate') }}" aria-hidden="true"></i></span></a>
					<ul class="list-unstyled {{ setClass('cp/advanced', 'open') }}">
						<li class="{{ setActive('cp/advanced/roles') }}"><a href="/cp/advanced/roles" title="Roles"><i class="text-center icon fa fa-circle-o" aria-hidden="true"></i>Roles</a></li>
						<li class="{{ setActive('cp/advanced/permissions') }}"><a href="/cp/advanced/permissions" title="Permissions"><i class="text-center icon fa fa-circle-o" aria-hidden="true"></i>Permissions</a></li>
						<li class="{{ setActive('cp/advanced/statuses') }}"><a href="/cp/advanced/statuses" title="Statuses"><i class="text-center icon fa fa-circle-o" aria-hidden="true"></i>Statuses</a></li>
					</ul>
				</li>
			</ul>
			<h4 class="text-uppercase">User</h4>
			<ul class="list-unstyled">
				<li class="{{ setActive('cp/users/'.Auth::id().'/edit/password') }}"><a href="/cp/users/{{ Auth::id() }}/edit/password" title="Change Password"><i class="text-center icon fa fa-key" aria-hidden="true"></i>Change Password</a></li>
				<li><a href="javascript:void(0);" title="Logout" id="logout"><i class="text-center icon fa fa-sign-out" aria-hidden="true"></i>Logout</a></li>
			</ul>
			<form name="logoutUser" id="logoutUser" class="logoutUser" action="/logout" method="POST" style="display: none;">
				{{ csrf_field() }}
			</form>
		</div>
		