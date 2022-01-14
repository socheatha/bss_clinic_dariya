<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Repositories\SettingRepository;
use Auth;
use Artisan;

class SettingController extends Controller
{

	protected $settings;

	public function __construct(SettingRepository $repository)
	{
		$this->settings = $repository;
	}

	public function index()
	{
		return view('setting.index');
	}

	public function update(SettingRequest $request)
	{
		if ($this->settings->update($request)) {
			Artisan::call('cache:clear');
			// Redirect
			return redirect()->route('setting.index')
				->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]) . $request->name);
		}
	}
}
