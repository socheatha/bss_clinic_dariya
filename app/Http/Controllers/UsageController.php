<?php

namespace App\Http\Controllers;

use App\Models\Usage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsageRequest;
use App\Repositories\UsageRepository;
use Auth;

class UsageController extends Controller
{

	protected $usages;

	public function __construct(UsageRepository $repository)
	{
		$this->usages = $repository;
	}

	public function index()
	{
		$this->data = [
			'usages' => $this->usages->getData(),
		];

		return view('usage.index', $this->data);
	}

	public function getSelectDistrict(Request $request)
	{
		return $this->usages->getSelectDistrict($request);
	}

	public function create()
	{
		$this->data = [
			'usages' => Usage::getSelectData('id', 'name', '', 'id', 'asc'),
		];
		return view('usage.create', $this->data);
	}

	public function store(UsageRequest $request)
	{
		if ($this->usages->create($request)) {
			return redirect()->route('usage.create')
				->with('success', __('alert.crud.success.create', ['name' => Auth::user()->module()]) . $request->name);
		}
	}

	public function edit(Usage $usage)
	{
		$this->data = [
			'usage' => $usage,
			'usages' => Usage::getSelectData('id', 'name', '', 'id', 'asc'),
		];
		return view('usage.edit', $this->data);
	}

	public function update(UsageRequest $request, Usage $usage)
	{
		if ($this->usages->update($request, $usage)) {
			return redirect()->route('usage.index')
				->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]) . $request->name);
		}
	}

	public function destroy(Usage $usage)
	{
		return redirect()->route('usage.index')
			->with('success', __('alert.crud.success.delete', ['name' => Auth::user()->module()]) . $this->usages->destroy($usage));
	}
}
