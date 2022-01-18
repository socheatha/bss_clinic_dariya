<?php

namespace App\Repositories;

use App\Models\Doctor;
use Auth;
use Hash;


class DoctorRepository
{
	public function getData()
	{
		return Doctor::all();
	}

	public function getDetail($request)
	{
		$doctor = Doctor::find($request->id);
		$detail = '';
		return response()->json([
			'detail' => $detail,
		]);
	}

	public function create($request)
	{
		$doctor = Doctor::create([
			'name_kh' => $request->name_kh,
			'name_en' => $request->name_en,
			'gender' => $request->gender,
			'id_card' => $request->id_card,
			'phone' => $request->phone,
			'email' => $request->email,
			'full_address' => $request->full_address,
			'address_district_id' => $request->address_district_id,
			'address_province_id' => $request->address_province_id,
			'address_commune' => $request->address_commune,
			'address_village' => $request->address_village,
			'description' => $request->description,
			'created_by' => Auth::user()->id,
			'updated_by' => Auth::user()->id,
		]);
		return $doctor;
	}

	public function update($request, $doctor)
	{
		return $doctor->update([
			'name_kh' => $request->name_kh,
			'name_en' => $request->name_en,
			'gender' => $request->gender,
			'id_card' => $request->id_card,
			'phone' => $request->phone,
			'email' => $request->email,
			'full_address' => $request->full_address,
			'address_district_id' => $request->address_district_id,
			'address_province_id' => $request->address_province_id,
			'address_commune' => $request->address_commune,
			'address_village' => $request->address_village,
			'description' => $request->description,
			'updated_by' => Auth::user()->id,
		]);
	}

	public function destroy($request, $doctor)
	{
		if (Hash::check($request->passwordDelete, Auth::user()->password)) {
			if ($doctor->delete()) {
				return $doctor->name_kh;
			}
		} else {
			return false;
		}
	}
}
