<?php

namespace App\Repositories\Component;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\FourLevelAddress;
use Auth;

class GlobalComponent extends Controller
{	
	protected $logo;
	protected $clinic_name_kh;
	protected $clinic_name_en;
	protected $description;
	protected $address;
	protected $phone;
	protected $sign_name_kh;
	protected $sign_name_en;
	protected $echo_description;
	protected $echo_address;
	protected $unique_clinic_name;

	public function __construct() {
		$setting_obj =  auth()->user()->setting();
		
		$this->unique_clinic_name = trim(strtoupper(auth()->user()->roles->first()->name));
		foreach (['logo', 'clinic_name_kh', 'clinic_name_en', 'description', 'address', 'phone', 'sign_name_kh', 'sign_name_en', 'echo_description', 'echo_address'] as $obj_member) {
			$this->{$obj_member} = $setting_obj->{$obj_member};
		}
		
	}

	public function PrintHeader($module = 'invoice', $object = null)
	{
		$html_header = '';
		$title_module = ($module == 'invoice' ? 'វិក្កយបត្រ' : ($module == 'prescription' ? 'វេជ្ជបញ្ជា' : ($module == 'labor' ? 'Laboratory Report' : '_______________')));
		$number = ($module == 'invoice' ? 'inv_number' : ($module == 'prescription' ? 'code' : ($module == 'labor' ? 'labor_number' : 'number')));
		$html_diagnosis = $module == 'labor' ? '' : ('
			<td width="50%" style="">
				រោគវិនិច្ឆ័យ: <span class="pt_diagnosis">'. ($object->pt_diagnosis ?? '') .'</span>
			</td>
		');
		
		// Top Header
		// if ($module == 'echo') {
		// 	if ($object->echo_default_description->slug == 'letter-form-the-hospital') {
		// 		$html_header .= '
		// 			<div class="KHOSMoulLight text-center" style=="font-size: 16px;">ព្រះរាជាណាចក្រកម្ពុជា</div>
		// 			<div class="KHOSMoulLight text-center" style=="font-size: 16px;">ជាតិ   សាសនា    ព្រះមហាក្សត្រ</div>
		// 			<table class="table-header" width="100%">
		// 				<tr>
		// 					<td  width="30%" class="text-center">
		// 						<div style="width: 3cm; height: 3cm; margin: 0 auto;"><img src="/images/setting/logo.png" alt="IMG"></div>
		// 						<div class="KHOSMoulLight" style="padding: 5px 0;">មន្ទីសុខាភិបាលខេត្តកំពង់ចាម</div>
		// 						<div class="KHOSMoulLight">'. $this->clinic_name_kh .'</div>
		// 					</td>
		// 					<td width="30%" class="text-center">
		// 					</td>
		// 					<td width="40%" class="text-center">
		// 						<br/>
		// 						<div>'. $this->address .'</div>
		// 						<div style="padding: 5px 0;">Tel: '. $this->phone .'</div>
		// 					</td>
		// 				</tr>
		// 			</table>
		// 		';
		// 	} else {
		// 		$html_header .= '
		// 			<table class="table-header" width="100%">
		// 				<tr>
		// 					<td width="40%">
		// 						<div class="KHOSMoulLight"style="color: red;">'. $this->sign_name_kh .'</div>
		// 						<div style="color: blue; font-weight: bold; text-transform: uppercase; padding: 5px 0;">'. $this->sign_name_en .'</div>
		// 						<div>'. $this->echo_description .'</div>
		// 					</td>
		// 					<td  width="20%">
		// 						<img src="/images/setting/logo.png" alt="IMG">
		// 					</td>
		// 					<td width="40%" class="text-center">
		// 						<div>'. $this->echo_address .'</div>
		// 						<div style="padding: 5px 0;">Tel: '. $this->phone .'</div>
		// 					</td>
		// 				</tr>
		// 			</table>
		// 		';
		// 	}
		// } else {
			$html_header .= '		
				<table class="table-header" width="100%">
					<tr>					
						<td rowspan="3" width="110px" style="padding: 0 !important;">
							<img src="/images/setting/logo.png" alt="IMG">
						</td>
						<td class="text-center">
							<div style="font-size: 25px; color: #14a5b6;" class="KHOSMoulLight">' . $this->clinic_name_kh . '</div>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="text-center" style="padding: 0;">
							<div style="font-size: 20px; color: #fa6f1e;" class="KHOSMoulLight">'. $this->clinic_name_en .'</div>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="text-center" style="padding: 1px 0;">
							<div>'. $this->description .'</div>
						</td>
					</tr>
				</table>
			';
		// }
		// Sub Header

		$html_header .= '
			<table class="table-information" width="100%" style="margin: 10px 0;">
				<tr>
					<td colspan="3" style="border-top: 1px solid #555; padding-top: 5px;">
						<div class="text-center KHOSMoulLight"  style="font-size: 18px; padding: 0 0 5px 0;">' . $title_module . '</div>
					</td>
				</tr>
				<tr>
					<td width="35%">
						កាលបរិច្ឆេទ/Date: <span>'. date('d-m-Y', strtotime($object->date)) .'</span>
					</td>
					<td width="35%" style="">
						លេខកូដអ្នកជំងឺ/Patien ID: <span class="labor_number">'. str_pad(($object->$number ?? 0), 6, "0", STR_PAD_LEFT) .'</span>
					</td>
					<td width="30%" style="">
						លេខកូដ/Code: <span class="labor_number">'. str_pad(($object->$number ?? 0), 6, "0", STR_PAD_LEFT) .'</span>
					</td>
				</tr>
				<tr>
					<td>
						ឈ្មោះ/Name: <span class="pt_name">'. ($object->pt_name ?? '') .'</span>
					</td>
					<td>
						អាយុ/Age: <span class="pt_age">'. ($object->pt_age ?? '') . ' ' .  (($object->pt_age_type ? __('module.table.selection.age_type_' . $object->pt_age_type) : '')).'</span>
					</td>
					<td>
						ភេទ/Sex: <span class="pt_gender">'. ($object->pt_gender ?? '') .'</span>
					</td>
				</tr>
				<tr>
					<td style="border-bottom: 1px solid #555; padding-bottom: 5px;">
						ស្នើដោយ/Prescripteur: <span>'. ($object->created_by_name ?? '') .'</span>
					</td>
					<td colspan="2" style="border-bottom: 1px solid #555; padding-bottom: 5px;">
						គំរូ/Sample: <span>'. ($object->type ?? '') .'</span>
					</td>
				</tr>
			</table>
		';
		return $html_header;		
	}

	public static function DoctorSignature($doctor_name = '', $title_signature = 'គ្រូពេទ្យព្យាបាល')
	{
		return "
		<div class='text-center doctor_signature' style='position: absolute; right: 30px; bottom: 2.2cm;'>
				<div class='KHOSMoulLight'>$title_signature</div>
				<div class='sign_box'>
					<img src='/images/setting/doctor_signature.jpg' class='sr-only' alt=''>
				</div>
				<div><span class='KHOSMoulLight' style='font-size: 14px;'>វេជ្ជបណ្ឌិត.</span> <span class='KHOSMoulLight' style='font-size: 16px;'>" . ($doctor_name ?: auth()->user()->setting()->sign_name_kh) . "</span></div>
			</div>
		";
	}

	public function FooterComeBackText($text = '', $color = 'color_red')
	{
		$html_footer_comeback ="<div style=' text-align: center; position: absolute; bottom: 0.4cm; left: 0; width: 100%; padding: 0 0.8cm;'>
										<div style=' border-top: 1px solid #555; padding-top: 10px;'>អាសយដ្ឋាន៖ ". $this->address ."</div>
										<div style='padding-top: 2px;'>ទូរស័ព្ទទំនាក់ទំនង៖ ". $this->phone ."</div>
									</div>
								";
		return $html_footer_comeback;
	}

	public static function GetPatientIdOrCreate($request)
	{	
		$patient_id = 0;	
		$patient_name = trim($request->pt_name);
		if (!empty($patient_name)) {
			$patient = Patient::where('name', $patient_name)->first();

			if ($patient != null) {
				$patient_id = $patient->id;
			} else {
				$created_patient = Patient::create([
					'name' => $patient_name,
					'age' => $request->pt_age ?? '0',
					'age_type' => $request->pt_age_type ?: '1',
					'gender' => (($request->pt_gender == 'ប្រុស' || strtolower(trim($request->pt_gender)) == 'male') ? '1' : '2'),
					'phone' => $request->pt_phone ?? '',
					'address_code' => $request->pt_village_id,
					'created_by' => auth()->user()->id,
					'updated_by' => auth()->user()->id,
				]);
				$patient_id = $created_patient->id;
			}
		}
		
		return $patient_id;		
	}

	public static function MergeRequestPatient($request, $array)
	{
		return array_merge([
			'patient_id' => $request->patient_id ?: self::GetPatientIdOrCreate($request),
			'pt_no' => str_pad($request->patient_id, 6, "0", STR_PAD_LEFT),
			'pt_name' => $request->pt_name,
			'pt_gender' => $request->pt_gender,
			'pt_age' => $request->pt_age,
			'pt_age_type' => $request->pt_age_type ?: '1',
			'pt_phone' => $request->pt_phone,
			'pt_address_code' => $request->pt_village_id,
			'pt_address_full_text' => self::GetAddressFullText($request->pt_village_id),
		], $array);
	}

	public static function GetAddressFullText($code) {
		return $code ? FourLevelAddress::select('_path_kh')->where('_code', $code)->first()['_path_kh'] : null;
	}
}

/*
	How to use : 
		use App\Repositories\Component\GlobalComponent as GComponent;
		GComponent::FooterComeBackText('សូមយកលទ្ធផលពិនិត្យឈាមនេះមកវិញពេលមកពិនិត្យលើកក្រោយ')
		GComponent::DoctorSignature()
*/
