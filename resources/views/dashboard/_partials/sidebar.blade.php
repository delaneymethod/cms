		<div class="col-md-3 col-lg-3 sidebar">
			<h3>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
			<h4 class="text-uppercase">Administration</h4>
			<ul class="list-unstyled">
				<li class="{{ setActive(['dashboard']) }}"><a href="{{ url('/dashboard') }}" title=""><i class="text-center icon fa fa-tachometer" aria-hidden="true"></i>Dashboard</a></li>
				<li class="{{ setActive(['dashboard/users', 'dashboard/users/create']) }}"><a href="{{ url('/dashboard/users') }}" title="Users"><i class="text-center icon fa fa-users" aria-hidden="true"></i>Users</a></li>
				<li class="{{ setActive(['dashboard/locations', 'dashboard/locations/create']) }}"><a href="{{ url('/dashboard/locations') }}" title="Locations"><i class="text-center icon fa fa-map-marker" aria-hidden="true"></i>Locations</a></li>
				<li class="{{ setActive(['dashboard/orders', 'dashboard/order/create']) }}"><a href="{{ url('/dashboard/orders') }}" title="Orders"><i class="text-center icon fa fa-shopping-cart" aria-hidden="true"></i>Orders</a></li>
				<li class="{{ setActive(['dashboard/articles', 'dashboard/articles/create']) }}"><a href="{{ url('/dashboard/articles') }}" title="Articles"><i class="text-center icon fa fa-newspaper-o" aria-hidden="true"></i>Articles</a></li>
				<li class="{{ setActive(['dashboard/pages', 'dashboard/pages/create']) }}"><a href="{{ url('/dashboard/pages') }}" title="Pages"><i class="text-center icon fa fa-file-o" aria-hidden="true"></i>Pages</a></li>
				<li class="{{ setActive(['dashboard/menu']) }}"><a href="{{ url('/dashboard/menu') }}" title="Menu"><i class="text-center icon fa fa-list" aria-hidden="true"></i>Menu</a></li>
				<li>
					<a href="javascript:void(0);" title="Advanced" id="advanced" class="{{ setClass(['dashboard/advanced', 'dashboard/advanced/roles', 'dashboard/advanced/roles/create', 'dashboard/advanced/permissions', 'dashboard/advanced/statuses', 'dashboard/advanced/statuses/create'], 'highlight') }}"><i class="text-center icon fa fa-cogs" aria-hidden="true"></i>Advanced<span class="pull-right"><i class="fa fa-angle-left {{ setClass(['dashboard/advanced', 'dashboard/advanced/roles', 'dashboard/advanced/permissions', 'dashboard/advanced/statuses'], 'fa-rotate') }}" aria-hidden="true"></i></span></a>
					<ul class="list-unstyled {{ setClass(['dashboard/advanced', 'dashboard/advanced/roles', 'dashboard/advanced/roles/create', 'dashboard/advanced/permissions', 'dashboard/advanced/statuses', 'dashboard/advanced/statuses/create'], 'open') }}">
						<li class="{{ setActive(['dashboard/advanced/roles', 'dashboard/advanced/roles/create']) }}"><a href="{{ url('/dashboard/advanced/roles') }}" title="Roles"><i class="text-center icon fa fa-circle-o" aria-hidden="true"></i>Roles</a></li>
						<li class="{{ setActive(['dashboard/advanced/permissions']) }}"><a href="{{ url('/dashboard/advanced/permissions') }}" title="Permissions"><i class="text-center icon fa fa-circle-o" aria-hidden="true"></i>Permissions</a></li>
						<li class="{{ setActive(['dashboard/advanced/statuses', 'dashboard/advanced/statuses/create']) }}"><a href="{{ url('/dashboard/advanced/statuses') }}" title="Statuses"><i class="text-center icon fa fa-circle-o" aria-hidden="true"></i>Statuses</a></li>
					</ul>
				</li>
			</ul>
			<h4 class="text-uppercase">User</h4>
			<ul class="list-unstyled">
				<li><a href="{{ route('logout') }}" title="Logout" id="logout"><i class="text-center icon fa fa-sign-out" aria-hidden="true"></i>Logout</a></li>
			</ul>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				{{ csrf_field() }}
			</form>
		</div>
		