<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Repositories\PermissionRepository;
use Spatie\Permission\Models\Permission;
use Auth;

class PermissionController extends Controller
{
	protected $permissions;

	public function __construct(PermissionRepository $repository)
	{
		$this->permissions = $repository;
	}

	public function index()
	{
		$this->data = [
			'permissions' => $this->permissions->getData(),
		];
		return view('permission.index', $this->data);
	}

	public function create()
	{
		return view('permission.create');
	}

	public function store(PermissionRequest $request)
	{
		if ($this->permissions->create($request)) {
			return redirect()->route('permission.create')
				->with('success', __('alert.crud.success.create', ['name' => Auth::user()->module()]) . $request->name);
		}
	}

	public function edit(Permission $permission)
	{
		$this->data = [
			'permission' => $permission,
		];
		return view('permission.edit', $this->data);
	}

	public function update(PermissionRequest $request, $id)
	{
		if ($this->permissions->update($request, $id)) {
			return redirect()->route('permission.index')
				->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]) . $request->name);
		}
	}

	public function destroy($id)
	{
		return redirect()->route('permission.index')
			->with('success', __('alert.crud.success.delete', ['name' => Auth::user()->module()]) . $this->permissions->destroy($id));
	}

	public function permission_to_role()
	{
		$this->data = [
			'permissions' => $this->permissions->getData(),
		];
		return view('permission.permission_to_role', $this->data);
	}
}
