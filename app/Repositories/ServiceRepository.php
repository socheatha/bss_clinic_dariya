<?php

namespace App\Repositories;

use App\Models\Service;
use Auth;


class ServiceRepository
{
	public function getData()
	{
		return Service::get();
	}

	public function reloadSelectService()
	{
		$services = Service::orderBy('name', 'asc')->get();
		$options = '<option value="">' . __('label.form.choose') . '</option>';
		foreach ($services as $key => $service) {
			$options .= '<option value="' . $service->id . '">' . $service->name . '</option>';
		}
		return $options;
	}

	public function getDetail($request)
	{
		$service = Service::find($request->id);
		return response()->json([
			'service' => $service,
		]);
	}

	public function create($request)
	{
		$service = Service::create([
			'name' => $request->name,
			'price' => $request->price,
			'description' => $request->description,
			'created_by' => Auth::user()->id,
			'updated_by' => Auth::user()->id,
		]);
		return $service;
	}

	public function update($request, $service)
	{
		return $service->update([
			'name' => $request->name,
			'price' => $request->price,
			'description' => $request->description,
			'updated_by' => Auth::user()->id,
		]);
	}

	public function destroy($service)
	{
		$name = $service->name;
		if ($service->delete()) {
			return $name;
		}
	}
}
