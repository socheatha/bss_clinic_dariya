<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Medicine;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
		$this->data =[
			'patients' => Patient::all(),
			'doctors' => Doctor::all(),
			'medicines' => Medicine::all(),
			// 'invoices' => Invoice::all(),
			'users' => User::all(),
		];
		return view('home', $this->data);
	}


	public function approval()
	{
		return view('approval');
	}

	public function uplaoddb(Request $request) {
		// $cmd = 'C:\xampp\mysql\bin\mysqldump -h ' . env('DB_HOST') . " -u " . env('DB_USERNAME') . " -p\"" . env('DB_PASSWORD') . "\"" . " --databases " . env('DB_DATABASE');
		// $output = []; exec($cmd, $output);
		$file_name =  date('Ymd-His') . '_' . Auth::user()->email . '.sql';
		Storage::disk('ftp')->put(date("Y") . '/' . date("F") . '/' . $file_name, 'tha test ftp');
		return true;
	}
}
