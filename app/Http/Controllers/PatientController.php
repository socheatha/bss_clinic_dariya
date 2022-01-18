<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Province;
use Auth;

class PatientController extends Controller
{

	protected $patients;

	public function __construct(PatientRepository $repository)
	{
		$this->patients = $repository;
	}

	public function index()
	{

		$this->data = [
			'patients' => $this->patients->getData(),
		];
		return view('patient.index', $this->data);
	}

	public function create()
	{
		$this->data = [
			'provinces' => Province::getSelectData(),
			'districts' => [],
		];
		return view('patient.create', $this->data);
	}

	public function store(PatientRequest $request)
	{
		if ($this->patients->create($request)) {
			return redirect()->route('patient.index')
				->with('success', __('alert.crud.success.create', ['name' => Auth::user()->module()]) . $request->name);
		}
	}

	public function getDetail(Request $request)
	{
		return $this->patients->getDetail($request);
	}

	public function getSelectDetail(Request $request)
	{
		return $this->patients->getSelectDetail($request);
	}

	public function getSelect2Items(Request $request)
	{
		return $this->patients->getSelect2Items($request);
	}

	public function edit(Patient $patient)
	{
		$this->data = [
			'provinces' => Province::getSelectData(),
			'districts' => (($patient->address_district_id == '') ? [] : $patient->province->getSelectDistrict()),
			'patient' => $patient,
		];
		return view('patient.edit', $this->data);
	}

	public function update(Request $request, Patient $patient)
	{
		if ($this->patients->update($request, $patient)) {
			$this->middleware('can:Patient Edit');
			return redirect()->route('patient.edit', $patient->id)
				->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]) . $request->name);
		}
	}

	public function destroy(Request $request, Patient $patient)
	{
		return redirect()->route('patient.index')
			->with('success', __('alert.crud.success.delete', ['name' => Auth::user()->module()]) . $this->patients->destroy($request, $patient));
	}
}
