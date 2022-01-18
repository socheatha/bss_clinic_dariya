<?php

namespace App\Repositories;

use App\Models\Patient;
use Auth;
use Hash;


class PatientRepository
{
	public function getData()
	{
		return Patient::all();
	}

	public function getSelect2Items($request)
	{
		if ($request->ajax()) {
			$page = $request->page;
			if ($request->term != '') {
				$resultCount = 5;
			} else {
				$resultCount = 1;
			}
			$offset = ($page - 1) * $resultCount;
			if ($request->term == '') {
				$patients = Patient::orderBy('name', 'asc')->limit(20)->get();
			} else {
				$patients = Patient::orderBy('name', 'asc')->skip($offset)->take($resultCount)
					->where('name', 'LIKE',  '%' . $request->term . '%')
					->orWhere('id', 'LIKE',  '%' . $request->term . '%')
					->get();
			}
			$query_results = array();
			$group_rs = array();
			$children = array();
			$group_array = array();
			foreach ($patients as $i => $patient) {
				$children = [];
				$child['id'] = $patient->id;
				$child['text'] = str_pad($patient->id, 6, "0", STR_PAD_LEFT) . ' :: ' . $patient->name;
				array_push($query_results, $child);
			}
			$count = Patient::count();
			$endCount = $offset + $resultCount;
			$morePages = $endCount > $count;
			$results = array(
				"results" => $query_results,
				"pagination" => array(
					"more" => $morePages
				)
			);
			return response()->json($results);
		}
	}

	public function getDetail($request)
	{
		// find Precription + Invoice + Echo of this patient, ..., then sort by date and return
		$P_precription = \DB::table('prescriptions')->select(['id', 'pt_name', 'date', 'pt_age', 'pt_age_type'])->where('patient_id', $request->id)->orderBy('id', 'DESC')->get()->toarray();
		$P_invoice = \DB::table('invoices')->select(['id', 'pt_name', 'date', 'pt_age', 'pt_age_type'])->where('patient_id', $request->id)->orderBy('id', 'DESC')->get()->toarray();
		$P_echo = \DB::table('echoes')->select(['echoes.id', 'echoes.pt_name', 'echoes.date', 'echoes.pt_age', 'echo_default_descriptions.slug'])->leftJoin('echo_default_descriptions', 'echoes.echo_default_description_id', '=', 'echo_default_descriptions.id')->where('echoes.patient_id', $request->id)->orderBy('echoes.id', 'DESC')->get()->toarray();
		$P_labor = \DB::table('labors')->select(['id', 'labor_type', 'pt_name', 'date'])->where('patient_id', $request->id)->orderBy('id', 'DESC')->get()->toarray();
		$P_result = array_merge(
			array_map(function ($P) {
				$P->segment = 'prescription';
				$P->link = "prescription/{$P->id}/print";
				$P->label_info = __("sidebar.prescription.main");
				return $P;
			}, $P_precription),
			array_map(function ($P) {
				$P->segment = 'invoice';
				$P->link = "invoice/{$P->id}/print";
				$P->label_info = __("sidebar.invoice.main");
				return $P;
			}, $P_invoice),
			array_map(function ($P) {
				$P->segment = 'echo';
				$P->link = "echoes/{$P->slug}/{$P->id}/print";
				$P->label_info = __("sidebar.echo.main");
				return $P;
			}, $P_echo),
			array_map(function ($P) {
				$P->segment = 'labor';
				$P->link = "labor/{$P->id}/print";
				$P->label_info = __("sidebar.labor.main") . ($P->labor_type == 1 ? ' - ' . __("module.table.labor.create_label_1") : ($P->labor_type == 2 ? ' - ' . __("module.table.labor.create_label_2") : ''));
				return $P;
			}, $P_labor)
		);
		array_multisort(array_column($P_result, 'date'), SORT_DESC, $P_result);

		return response()->json([
			'P_history' => json_encode($P_result)
		]);
	}

	public function getSelectDetail($request)
	{
		$patient = Patient::find($request->id);
		$patient->no = str_pad($patient->id, 6, "0", STR_PAD_LEFT);
		$patient->pt_gender = (($patient->gender == 1) ? 'ប្រុស' : 'ស្រី');

		$return_result['patient'] = $patient;
		if ($request->with_address_selection && $patient->address_code && strlen(trim($patient->address_code)) == 8) {
			$_4level_address = new \App\Http\Controllers\Location\FourLevelAddressController();
			$return_result['address'] = $_4level_address->BSSFullAddress($patient->address_code, 'option');
		}
		return response()->json($return_result);
	}

	public function create($request)
	{
		$patient = Patient::create([
			'name' => $request->name,
			'age' => $request->age,
			'age_type' => $request->age_type ?: '1',
			'gender' => $request->gender,
			'id_card' => $request->id_card,
			'phone' => $request->phone,
			'email' => $request->email,
			'full_address' => $request->full_address,
			'address_code' => $request->pt_village_id,
			'description' => $request->description,
			'created_by' => Auth::user()->id,
			'updated_by' => Auth::user()->id,
		]);
		return $patient;
	}

	public function update($request, $patient)
	{
		return $patient->update([
			'name' => $request->name,
			'age' => $request->age,
			'age_type' => $request->age_type ?: '1',
			'gender' => $request->gender,
			'id_card' => $request->id_card,
			'phone' => $request->phone,
			'email' => $request->email,
			'full_address' => $request->full_address,
			'address_code' => $request->pt_village_id,
			'description' => $request->description,
			'updated_by' => Auth::user()->id,
		]);
	}

	public function destroy($request, $patient)
	{
		if (Hash::check($request->passwordDelete, Auth::user()->password)) {
			if ($patient->delete()) {
				return $patient->name;
			}
		} else {
			return false;
		}
	}
}
