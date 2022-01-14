<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Auth;
use Hash;
use Validator;
use Artisan;

class UserController extends Controller
{

	protected $users;

	public function __construct(UserRepository $repository)
	{
		$this->users = $repository;
	}

	public function index()
	{
		$this->data = [
			'users' => $this->users->getData(),
		];
		return view('user.index', $this->data);
	}


	public function create()
	{
		$this->data = [
			// 'user' => $user,
		];
		return view('user.create', $this->data);
	}

	public function store(UserRequest $request)
	{
		if ($this->users->create($request)) {
			return redirect()->route('user.index')
				->with('success', __('alert.crud.success.create', ['name' => Auth::user()->module()]) . $request->first_name . ' ' . $request->last_name);
		}
	}

	public function profile()
	{
		$this->data = [
			'profileTab' => session('profileTab'),
		];
		return view('user.profile', $this->data);
	}

	public function role(User $user)
	{
		$this->data = [
			'user' => $user,
			'roles' => Role::getSelectData(),
		];
		return view('user.role', $this->data);
	}

	public function update_role(Request $request, User $user)
	{
		if ($this->users->update_role($user, $request)) {
			return redirect()->route('user.role', $user->id)
				->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]));
		}
	}

	public function edit(User $user)
	{
		$this->data = [
			'user' => $user,
		];
		return view('user.edit', $this->data);
	}

	public function update(Request $request, User $user, $type)
	{
		session()->put('profileTab', ((isset($request->profileTab)) ? $request->profileTab : 'permission'));

		if ($type == 'image') {
			$validator = Validator::make($request->all(), [
				'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
			]);
			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			// Define Upload Image Path
			$path = public_path() . '/images/users/';
			if ($this->users->updateImage($request, $user, $path)) {
				Artisan::call('cache:clear');
				return redirect()->route('user.profile')
					->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]) . Auth::user()->first_name . ' ' . Auth::user()->first_name);
			}
		} else if ($type == 'resetPassowrd') {
			$validator = Validator::make($request->all(), [
				'password' => 'required|string|min:8',
				'password_confirmation' => 'required|same:password'
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			if ($this->users->updatePassword($request, $user)) {
				return redirect()->route('user.index')
					->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]) . Auth::user()->first_name . ' ' . Auth::user()->first_name);
			}
		} else if ($type == 'updatePassowrd') {
			if (Hash::check($request->current_password, $user->password)) {
				$validator = Validator::make($request->all(), [
					'password' => 'required|string|min:8',
					'password_confirmation' => 'required|same:password'
				]);

				if ($validator->fails()) {
					return back()->withErrors($validator)->withInput();
				}

				if ($this->users->updatePassword($request, $user)) {
					return redirect()->route('user.profile', $user->id)
						->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]) . Auth::user()->first_name . ' ' . Auth::user()->first_name);
				}
			} else {
				return redirect()->back()->with('error', __('validation.current_password'));
			}
		} else {
			if ($this->users->update($request, $user)) {
				if ($type == 'edit') {
					$this->middleware('can:User Edit');
					return redirect()->route('user.index')
						->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]) . $request->first_name . ' ' . $request->last_name);
				} else {
					return redirect()->route('user.profile')
						->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]) . $request->first_name . ' ' . $request->last_name);
				}
			}
		}
	}

	public function destroy(Request $request, User $user)
	{
		return redirect()->route('user.index')
			->with('success', __('alert.crud.success.delete', ['name' => Auth::user()->module()]) . $this->users->destroy($request, $user));
	}

	public function password(User $user)
	{
		$this->data = [
			'user' => $user,
		];
		return view('user.password', $this->data);
	}

	public function password_confirm(Request $request)
	{
		return $this->users->checkPassword($request);
	}
}
