<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;
use Spatie\Permission\Models\Role;
use Auth;

class RoleController extends Controller
{

	protected $roles;

	public function __construct(RoleRepository $repository)
	{
		$this->roles = $repository;
	}

	public function index()
	{
		$this->data = [
			'roles' => $this->roles->getData(),
		];
		return view('role.index', $this->data);
	}

	public function create()
	{
		return view('role.create');
	}

	public function store(RoleRequest $request)
	{
		if ($this->roles->create($request)) {
			return redirect()->route('role.create')
				->with('success', __('alert.crud.success.create', ['name' => Auth::user()->module()]) . $request->name);
		}
	}

	public function edit(Role $role)
	{
		$this->data = [
			'role' => $role,
		];
		return view('role.edit', $this->data);
	}

	public function update(RoleRequest $request, $id)
	{
		if ($this->roles->update($request, $id)) {
			return redirect()->route('role.index')
				->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]) . $request->name);
		}
	}

	public function destroy($id)
	{
		return redirect()->route('role.index')
			->with('success', __('alert.crud.success.delete', ['name' => Auth::user()->module()]) . $this->roles->destroy($id));
	}

	public function assign_permission(Role $role, PermissionRepository $permissions)
	{
		$this->data = [
			'role' => $role,
			'permissions' => $permissions->getData(),
			'permission_existed' => $role->permissions->pluck('id')->toArray(),
		];
		return view('role.assign_permission', $this->data);
	}

	public function update_assign_permission(Request $request, Role $role)
	{
		if ($this->roles->update_assign_permission($request, $role)) {
			return redirect()->route('role.assign_permission', $role->id)
				->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]) . $role->name);
		}
	}
}
