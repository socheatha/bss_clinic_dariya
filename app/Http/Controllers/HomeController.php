<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Prescription;
use App\Models\Labor;
use App\Models\Echoes;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\Service;

use Illuminate\Support\Facades\Storage;
use Auth;
use DB;
use File;

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
		$this->data = [
			'list_panel' => [
				[
					'label' 	=> __('sidebar.invoice.main'),
					'route' 	=> route('invoice.index'),
					'color' 	=> '#223344',
					'icon' 		=> 'fa fa-file-invoice',
					'count' 	=> Invoice::count(),
					'is_allowed'=> Auth::user()->can(['Invoice Index', 'Invoice Create', 'Invoice Edit', 'Invoice Delete']),
				],
				[
					'label' 	=> __('sidebar.prescription.main'),
					'route' 	=> route('prescription.index'),
					'color' 	=> '#224444',
					'icon' 		=> 'fa fa-file-medical-alt nav-icon',
					'count' 	=> Prescription::count(),
					'is_allowed'=> Auth::user()->can(['Prescription Index', 'Prescription Create', 'Prescription Edit', 'Prescription Delete']),
				],
				[
					'label' 	=> __('sidebar.labor.main'),
					'route' 	=> route('labor.index'),
					'color' 	=> '#225544',
					'icon' 		=> 'nav-icon las la-flask',
					'count' 	=> Labor::count(),
					'is_allowed'=> count(Auth::user()->LaborTypes()->get()) && Auth::user()->can(['Labor Index', 'Labor Create', 'Labor Edit', 'Labor Delete']),
				],
				[
					'label' 	=> __('sidebar.echo.main'),
					'route' 	=> url('echoes/grossesse-non-evolue/create'),
					'color' 	=> '#226644',
					'icon' 		=> 'nav-icon fas fa-file-video',
					'count' 	=> Echoes::count(),
					'is_allowed'=> count(Auth::user()->echoDefaultDescriptions()->get()) && Auth::user()->can(['Echo Index','Echo Create', 'Echo Edit', 'Echo Delete','Echo Print']),
				],
				[
					'label' 	=> __('sidebar.patient.main'),
					'route' 	=> route('patient.index'),
					'color' 	=> '#333344',
					'icon' 		=> 'fa fa-user-injured nav-icon',
					'count' 	=> Patient::count(),
					'is_allowed'=> Auth::user()->can(['Patient Index', 'Patient Create', 'Patient Edit', 'Patient Delete']),
				],
				[
					'label' 	=> __('sidebar.doctor.main'),
					'route' 	=> route('doctor.index'),
					'color' 	=> '#344444',
					'icon' 		=> 'fa fa-user-md nav-icon',
					'count' 	=> Doctor::count(),
					'is_allowed'=> Auth::user()->can(['Doctor Index', 'Doctor Create', 'Doctor Edit', 'Doctor Delete']),
				],
				[
					'label' 	=> __('sidebar.medicine.main'),
					'route' 	=> route('medicine.index'),
					'color' 	=> '#355544',
					'icon' 		=> 'fa fa-pills nav-icon',
					'count' 	=> Medicine::count(),
					'is_allowed'=> Auth::user()->can(['Medicine Index', 'Medicine Create', 'Medicine Edit', 'Medicine Delete']),
				],
				[
					'label' 	=> __('sidebar.service.main'),
					'route' 	=> route('service.index'),
					'color' 	=> '#466644',
					'icon' 		=> 'fa fa-concierge-bell nav-icon',
					'count' 	=> Service::count(),
					'is_allowed'=> Auth::user()->can(['Service Index', 'Service Create', 'Service Edit', 'Service Delete']),
				],
			]
		];
		return view('home', $this->data);
	}

	public function approval()
	{
		return view('approval');
	}

	public function uplaod_sync_database(Request $request)
	{
		if (\AppHelper::IsInternetConnected() != true) return false;
		$cmd = \AppHelper::GetMySqlDump() . ' -h ' . env('DB_HOST') . ' -u ' . env('DB_USERNAME') . (env('DB_PASSWORD') ? ' -p"' . env('DB_PASSWORD') . '"' : '') . ' --databases ' . env('DB_DATABASE');
		$output = [];
		exec($cmd, $output);
		$output = implode($output, "\n");
		$file_name =  date('Ymd-His') . '_' . Auth::user()->email . '.sql';
		return Storage::disk('ftp')->put(date("Y") . '/' . date("F") . '/' . $file_name, $output) ?: 0;
	}

	public function update_missing_sql(Request $request)
	{
		// Find available SQL update
		$list_files = File::files(public_path('execute_sql_files'));
		foreach ($list_files as $file) {
			if (!in_array(pathinfo($file, PATHINFO_EXTENSION), ['sql', 'SQL'])) continue;
			if (File::exists($file . '.lock')) continue;

			// Lock file and execute query
			$query = File::get($file);
			if (!empty($query)) {
				try {
					DB::unprepared($query);
					File::put($file . '.lock', date('Y-m-d H:i:s') . "\r\r OK");
				} catch (\Illuminate\Database\QueryException $ex) {
					File::put($file . '.lock', date('Y-m-d H:i:s') . "\r\r" . $ex->getMessage());
				}
			}
		}
	}
}