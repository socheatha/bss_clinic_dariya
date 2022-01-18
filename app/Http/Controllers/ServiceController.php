<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Repositories\ServiceRepository;
use Auth;

class ServiceController extends Controller
{

	protected $services;

	public function __construct(ServiceRepository $repository)
	{
		$this->services = $repository;
	}

	public function index()
	{
		$this->data = [
			'services' => $this->services->getData(),
		];
		return view('service.index', $this->data);
	}

	public function getDetail(Request $request)
	{
		return $this->services->getDetail($request);
	}

	public function reloadSelectService()
	{
		return $this->services->reloadSelectService();
	}

	public function create()
	{
		return view('service.create');
	}

	public function store(ServiceRequest $request)
	{
		if ($this->services->create($request)) {
			return redirect()->route('service.create')
				->with('success', __('alert.crud.success.create', ['name' => Auth::user()->module()]) . $request->name);
		}
	}

	public function createService(ServiceRequest $request)
	{
		return response()->json([
			'success' => 'success',
			'service' => $this->services->create($request)
		]);
	}

	public function edit(Service $service)
	{
		$this->data = [
			'service' => $service,
		];
		return view('service.edit', $this->data);
	}

	public function update(ServiceRequest $request, Service $service)
	{
		if ($this->services->update($request, $service)) {
			return redirect()->route('service.index')
				->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]) . $request->name);
		}
	}

	public function destroy(Service $service)
	{
		return redirect()->route('service.index')
			->with('success', __('alert.crud.success.delete', ['name' => Auth::user()->module()]) . $this->services->destroy($service));
	}
}
