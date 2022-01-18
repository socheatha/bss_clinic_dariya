<?php

namespace App\Repositories;

use App\Models\Usage;


class UsageRepository
{
	public function getData()
	{
		return Usage::all();
	}

	public function create($request)
	{
		$usage = Usage::create([
			'name' => $request->name,
			'description' => $request->description,
		]);
		return $usage;
	}

	public function update($request, $usage)
	{
		return $usage->update([
			'name' => $request->name,
			'description' => $request->description,
		]);
	}

	public function destroy($usage)
	{
		$name = $usage->name;
		if ($usage->delete()) {
			return $name;
		}
	}
}
