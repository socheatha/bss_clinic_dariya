<?php

namespace App\Repositories;

use App\Models\EchoDefaultDescription;
use Auth;


class EchoDefaultDescriptionRepository
{
	public function getData()
	{
		return EchoDefaultDescription::all();
	}

	public function getDetail($request)
	{
		$echo_default_description = EchoDefaultDescription::find($request->id);
		return response()->json([
			'echo_default_description' => $echo_default_description,
		]);
	}

	public function create($request)
	{
		$echo_default_description = EchoDefaultDescription::create([
			'name' => $request->name,
			'slug' => $request->slug,
			'description' => $request->description,
			'created_by' => Auth::user()->id,
			'updated_by' => Auth::user()->id,
		]);

		return $echo_default_description;
	}

	public function update($request, $echo_default_description)
	{
		return $echo_default_description->update([
			'name' => $request->name,
			'slug' => $request->slug,
			'description' => $request->description,
			'updated_by' => Auth::user()->id,
		]);
	}

	public function destroy($echo_default_description)
	{
		$name = $echo_default_description->name;
		if ($echo_default_description->delete()) {
			return $name;
		}
	}
}
