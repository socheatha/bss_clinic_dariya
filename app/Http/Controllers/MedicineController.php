<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Usage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MedicineRequest;
use App\Repositories\MedicineRepository;
use Auth;

class MedicineController extends Controller
{

	protected $medicines;

	public function __construct(MedicineRepository $repository)
	{
		$this->medicines = $repository;
	}

	public function index()
	{
		$this->data = [
			'medicines' => $this->medicines->getData(),
		];
		return view('medicine.index', $this->data);
	}

	public function getDetail(Request $request)
	{
		return $this->medicines->getDetail($request);
	}

	public function create()
	{
		$this->data = [
			'usages' => Usage::getSelectData('id', 'name', '', 'id', 'asc'),
		];
		return view('medicine.create', $this->data);
	}

	public function store(MedicineRequest $request)
	{
		if ($this->medicines->create($request)) {
			return redirect()->route('medicine.create')
				->with('success', __('alert.crud.success.create', ['name' => Auth::user()->module()]) . $request->name);
		}
	}

	public function edit(Medicine $medicine)
	{
		$this->data = [
			'medicine' => $medicine,
			'usages' => Usage::getSelectData('id', 'name', '', 'id', 'asc'),
		];
		return view('medicine.edit', $this->data);
	}

	public function update(MedicineRequest $request, Medicine $medicine)
	{
		if ($this->medicines->update($request, $medicine)) {
			return redirect()->route('medicine.index')
				->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]) . $request->name);
		}
	}

	public function destroy(Medicine $medicine)
	{
		return redirect()->route('medicine.index')
			->with('success', __('alert.crud.success.delete', ['name' => Auth::user()->module()]) . $this->medicines->destroy($medicine));
	}
}
