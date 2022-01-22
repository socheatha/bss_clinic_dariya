<?php

function secure_element($param)
{
	return \AppHelper::secure_element(...$param);
}
$user = Auth::user();
$menu_active = $user->sidebarActive();

// Dynamic menu of echo description
$echo_descriptions = [];

foreach ($user->echoDefaultDescriptions()->get() as $kkey => $echo_default) {
	$menu_active = $echo_default->slug == @$type ? $echo_default->slug : $menu_active;
	$echo_descriptions[] = [
		'unique' => $echo_default->slug, 'main_map' => 'm001', 'icon' => 'far fa-circle nav-icon',
		'label' => $echo_default->name,
		'route' =>  route('echoes.create', $echo_default->slug),
		'is_allow' => $user->can('Echo Index', 'Echo Create', 'Echo Edit', 'Echo Delete'),
	];
}

// Main label
$sidebar_main_section = [
	'm001' => __('sidebar.header.main_data'),
	'm002' => __('sidebar.header.other_management'),
];

// Menu
$sidebar_menu = [
	[
		'unique' => 'invoice', 'main_map' => 'm001', 'icon' => 'fa fa-file-invoice nav-icon',
		'label' => __('sidebar.invoice.main'),
		'route' => route('invoice.create'),
		'is_allow' => $user->can('Invoice Index', 'Invoice Create', 'Invoice Edit', 'Invoice Delete'),
	],
	[
		'unique' => 'prescription', 'main_map' => 'm001', 'icon' => 'fa fa-file-medical-alt nav-icon',
		'label' => __('sidebar.prescription.main'),
		'route' =>  route('prescription.create'),
		'is_allow' => $user->can('Prescription Index', 'Prescription Create', 'Prescription Edit', 'Prescription Delete'),
	],
	[
		'unique' => 'labor', 'main_map' => 'm001', 'icon' => 'nav-icon las la-flask',
		'label' => 'ការពិនិត្យឈាម',
		'route' =>  route('labor.create', 'blood-test'),
		'is_allow' => $user->can('Labor Index', 'Labor Create', 'Labor Edit', 'Labor Delete'),
	],
	[
		'unique' => 'labor', 'main_map' => 'm001', 'icon' => 'nav-icon fas fa-vial',
		'label' => __('sidebar.labor_service.main'),
		'route' =>  '#',
		'is_allow' => true,
		'childs' => [
			[
				'unique' => 'labor_service', 'main_map' => 'm001', 'icon' => 'far fa-circle nav-icon',
				'label' => __('sidebar.labor_service.sub.labor_service'),
				'route' =>  route('labor_service.index'),
				'is_allow' => count($user->LaborTypes()->get()) && $user->can('Labor Service Index', 'Labor Service Create', 'Labor Service Edit', 'Labor Service Delete'),
			],
			[
				'unique' => 'labor_category', 'main_map' => 'm001', 'icon' => 'far fa-circle nav-icon',
				'label' => __('sidebar.labor_service.sub.labor_category'),
				'route' =>  route('labor_category.index'),
				'is_allow' => count($user->LaborTypes()->get()) && $user->can('Labor Category Index', 'Labor Category Create', 'Labor Category Edit', 'Labor Category Delete'),
			]
		]
	],
	[
		'unique' => 'echoes', 'main_map' => 'm001', 'icon' => 'nav-icon fas fa-file-video',
		'label' => __('sidebar.echo.main'),
		'route' => '#',
		'is_allow' => true,
		'childs' => $echo_descriptions
	],
	[
		'unique' => 'echo_default_description', 'main_map' => 'm001', 'icon' => 'far fa-file-video nav-icon',
		'label' => __('sidebar.echo_default_description.main'),
		'route' =>  route('echo_default_description.index'),
		'is_allow' => $user->can('Echo Default Description Index', 'Echo Default Description Create', 'Echo Default Description Edit', 'Echo Default Description Delete'),
	],
	[
		'unique' => 'patient', 'main_map' => 'm001', 'icon' => 'fa fa-user-injured nav-icon',
		'label' => __('sidebar.patient.main'),
		'route' =>  route('patient.index'),
		'is_allow' => $user->can('Patient Index', 'Patient Create', 'Patient Edit', 'Patient Delete'),
	],
	[
		'unique' => 'doctor', 'main_map' => 'm001', 'icon' => 'fa fa-user-md nav-icon',
		'label' => __('sidebar.doctor.main'),
		'route' =>  route('doctor.index'),
		'is_allow' => $user->can('Doctor Index', 'Doctor Create', 'Doctor Edit', 'Doctor Delete'),
	],
	[
		'unique' => 'medicine', 'main_map' => 'm001', 'icon' => 'fa fa-pills nav-icon',
		'label' => __('sidebar.medicine.main'),
		'route' =>  route('medicine.index'),
		'is_allow' => $user->can('Medicine Index', 'Medicine Create', 'Medicine Edit', 'Medicine Delete'),
	],
	[
		'unique' => 'service', 'main_map' => 'm001', 'icon' => 'fa fa-concierge-bell nav-icon',
		'label' => __('sidebar.service.main'),
		'route' =>  route('service.index'),
		'is_allow' => $user->can('Service Index', 'Service Create', 'Service Edit', 'Service Delete'),
	],
	[
		'unique' => 'usage', 'main_map' => 'm001', 'icon' => 'fa fa-hand-holding-water nav-icon',
		'label' => __('sidebar.usage.main'),
		'route' =>  route('usage.index'),
		'is_allow' => $user->can('Usage Index', 'Usage Create', 'Usage Edit', 'Usage Delete'),
	]
];

$sidebar_menu = array_merge($sidebar_menu, [
	[
		'unique' => 'user', 'main_map' => 'm002', 'icon' => 'fa fa-user nav-icon',
		'label' => __('sidebar.user.sub.user'),
		'route' =>  route('user.index'),
		'is_allow' => $user->can('User Index', 'User Create', 'User Edit', 'User Delete', 'User Assign Role', 'User Assign Permission'),
	],
	[
		'unique' => 'role', 'main_map' => 'm002', 'icon' => 'fa fa-user-graduate nav-icon',
		'label' => __('sidebar.user.sub.role'),
		'route' =>  route('role.index'),
		'is_allow' => $user->can('Role Index', 'Role Create', 'Role Edit', 'Role Delete', 'Role User Assign'),
	],
	[
		'unique' => 'permission', 'main_map' => 'm002', 'icon' => 'fa fa-shield-alt nav-icon',
		'label' => __('sidebar.user.sub.permission.sub.permission'),
		'route' =>  route('permission.index'),
		'is_allow' => $user->can('Permission Index', 'Permission Create', 'Permission Edit', 'Permission Delete', 'Permission Role Assign', 'Permission User Assign', 'Usage Index', 'Usage Create', 'Usage Edit', 'Usage Delete'),
	],
	[
		'unique' => 'setting', 'main_map' => 'm002', 'icon' => 'fa fa-cogs nav-icon',
		'label' => __('sidebar.setting.main'),
		'route' =>  route('setting.index'),
		'is_allow' => $user->can('Setting Index'),
	],
	[
		'unique' => 'province', 'main_map' => 'm002', 'icon' => 'fa fa-map nav-icon',
		'label' => __('sidebar.province.main'),
		'route' =>  route('province.index'),
		'is_allow' => $user->can('Province Index', 'Province Create', 'Province Edit', 'Province Delete'),
	],
]);
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-indigo sidebar-light-primary">
	<!-- Brand Logo -->
	<a href="{{ route('home') }}" class="brand-link">
		<img src="/images/setting/logo.png" alt="{{ Auth::user()->setting()->clinic_name }}" class="brand-image img-circle elevation-3">
		<span class="brand-text font-weight-light">{{ Auth::user()->setting()->clinic_name_kh }}</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column {{ ((Auth::user()->setting()->legacy == '1')? 'nav-legacy nav-flat' : 'sidebar-light-indigo') }} nav-child-indent text-sm" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
				with font-awesome or any other icon font library -->
				<li class="nav-item">
					<a href="{{ route('home') }}" class="nav-link {{ ((Auth::user()->sidebarActive() == 'home' )? 'active':'') }}">
						<i class="fa fa-home nav-icon"></i>
						<p>{{ __('sidebar.home.main') }}</p>
					</a>
				</li>

				<?php
				$sidebar_render = '';
				foreach ($sidebar_menu as $index => $menu) {
					$element_type = !empty($menu['childs']) ? 'group' : 'menu';
					if ($element_type == 'group') { // If group, show menu inside it parent

						$childs_render = $list_unique = [];

						// Loop and generate menu as html string
						foreach ($menu['childs'] as $index_child => $child) {
							if ($child['is_allow']) {
								$list_unique[] = secure_element([$child, 'unique']);

								if (secure_element([$child, 'string_raw', ''])) {
									// If no structure, developer can put html string if they want
									$childs_render[] = secure_element([$child, 'string_raw']);
								} else {
									// Generatare html string by structure
									$childs_render[] = '<li class="nav-item">
											<a href="' . secure_element([$child, 'route', '#']) . '" class="nav-link ' . ($menu_active == secure_element([$child, 'unique', rand(111, 999)]) ? 'active' : '') . '">
												<i class="' . secure_element([$child, 'icon', 'fa fa-cubes']) . '"></i><p>' . secure_element([$child, 'label']) . '</p>
											</a>
										</li>';
								}
							}
						}

						// If menu have right or permission, then show it inside group
						if (sizeof($childs_render) > 0) {

							// Add main label if it's not yet add
							if (secure_element([$sidebar_main_section, secure_element([$child, 'main_map']), ''])) {
								echo '<li class="nav-header">' . $sidebar_main_section[$child['main_map']] . '</li>';
								unset($sidebar_main_section[$child['main_map']]);
							}

							// Render group with menu
							echo '
									<li class="nav-item has-treeview ' . (in_array($menu_active, $list_unique) ? 'menu-open' : '') . '">
										<a href="#" class="nav-link ' . (in_array($menu_active, $list_unique) ? 'active' : '') . '">
											<i class="' . secure_element([$menu, 'icon']) . '"></i>
											<p>' . secure_element([$menu, 'label']) . '<i class="right fas fa-angle-left"></i></p>
										</a>
										<ul class="nav nav-treeview">
											' . implode("\r\n", $childs_render) . '
										</ul>
									</li>
								';
						}
					} elseif ($element_type == 'menu') { // If child show menu direct
						if ($menu['is_allow']) {

							// Add main label if it's not yet add
							if (secure_element([$sidebar_main_section, secure_element([$menu, 'main_map']), ''])) {
								echo '<li class="nav-header">' . $sidebar_main_section[$menu['main_map']] . '</li>';
								unset($sidebar_main_section[$menu['main_map']]);
							}

							if (secure_element([$menu, 'string_raw', ''])) {
								// If no structure, developer can put html string if they want
								echo secure_element([$menu, 'string_raw']);
							} else {
								echo '<li class="nav-item">
										<a href="' . secure_element([$menu, 'route', '#']) . '" class="nav-link ' . ($menu_active == secure_element([$menu, 'unique', rand(111, 999)]) ? 'active' : '') . '">
											<i class="' . secure_element([$menu, 'icon', 'fa fa-cubes']) . '"></i><p>' . secure_element([$menu, 'label']) . '</p>
										</a>
									</li>';
							}
						}
					}
				}
				?>
			</ul>
			<br />
			<br />
			<br />
			<br />
			<br />
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>