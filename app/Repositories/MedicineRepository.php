<?php

namespace App\Repositories;

use App\Models\Medicine;
use Auth;


class MedicineRepository
{


	public function getData()
	{
		return Medicine::all();
	}

	public function getDetail($request)
	{
		$medicine = Medicine::find($request->id);
		$name = $medicine->usage->name;
		return response()->json([
			'medicine' => $medicine,
		]);
	}

	public function create($request)
	{
		$medicine = Medicine::create([
			'name' => $request->name,
			'price' => $request->price,
			'code' => $request->code,
			'usage_id' => $request->usage_id,
			'description' => $request->description,
			'created_by' => Auth::user()->id,
			'updated_by' => Auth::user()->id,
		]);

		return $medicine;
	}

	public function update($request, $medicine)
	{
		return $medicine->update([
			'name' => $request->name,
			'price' => $request->price,
			'code' => $request->code,
			'usage_id' => $request->usage_id,
			'description' => $request->description,
			'updated_by' => Auth::user()->id,
		]);
	}

	public function destroy($medicine)
	{
		$name = $medicine->name;
		if ($medicine->delete()) {
			return $name;
		}
	}
}
