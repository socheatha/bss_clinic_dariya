<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Echoes;
use App\Models\Patient;
use App\Models\EchoDefaultDescription;
use Yajra\DataTables\Facades\DataTables;
use Hash;
use Auth;
use Image;
use File;
use App\Repositories\Component\GlobalComponent;


class EchoesRepository
{


	public function getDatatable($request, $type)
	{
		
		$from = $request->from;
		$to = $request->to;
		$echo_default_description = EchoDefaultDescription::where('slug', $type)->first();
		$echoess = Echoes::where('echo_default_description_id', $echo_default_description->id)->whereBetween('date', [$from, $to])->orderBy('date', 'asc')->get();

		return Datatables::of($echoess)
			->addColumn('actions', function () {
				$button = '';
				return $button;
			})
			->make(true);
	}

	public function getEchoesPreview($id)
	{
		$GlobalComponent = new GlobalComponent;

		$no = 1;
		$total = 0;
		$total_discount = 0;
		$grand_total = 0;
		$echoes_detail = '';
		$tbody = '';

		$echoes = Echoes::find($id);

		$title = 'Echoes (INV'. date('Y', strtotime($echoes->date)) .'-'.str_pad($echoes->inv_number, 6, "0", STR_PAD_LEFT) .')';
		$total_riel = number_format($total*$echoes->rate, 0);
		$total_discount_riel = number_format($total_discount*$echoes->rate, 0);
		$grand_total_riel = number_format($grand_total*$echoes->rate, 0);

		
		$gtt = explode(".", number_format($grand_total,2));
		$gtt_dollars = $gtt[0];
		$gtt_cents = $gtt[1];

		$grand_total_in_word = Auth::user()->num2khtext($gtt_dollars, false) . 'ដុល្លារ' . (($gtt_cents>0)? ' និង'. Auth::user()->num2khtext($gtt_cents, false) .'សេន' : '');
		$grand_total_riel_in_word = Auth::user()->num2khtext(round($grand_total*$echoes->rate, 0), false);

		if(empty($echoes->province)){ $echoes->province = new \stdClass(); $echoes->province->name = ''; }
		if(empty($echoes->district)){ $echoes->district = new \stdClass(); $echoes->district->name = ''; }
		
		if ($echoes->echo_default_description->slug == 'letter-form-the-hospital') {
			$echoes_detail = '<section class="echoes-print" style="position: relative;">
				' . $GlobalComponent->PrintHeader('echo', $echoes) . '
				<br/>
				<br/>	
				<div class="echo_description">
					'. $echoes->description .'
				</div>
			</section>';
		}else{
			$echoes_detail = '<section class="echoes-print" style="position: relative;">
				' . $GlobalComponent->PrintHeader('echo', $echoes) . '
				<div class="echo_description">
					<div style="margin-bottom: 10px;">
						រោគវិនិច្ឆ័យ: '. $echoes->pt_diagnosis .'
					</div>
					'. $echoes->description .'
				</div>
				<table class="table-detail" width="100%">
					<tr>
						<td width="70%" style="padding: 10px;">
							<img src="/images/echoes/'. $echoes->image .'" alt="IMG" height="300px">
						</td>
						<td>
							<div>Le. '. date('d-m-Y', strtotime($echoes->date)) .'</div>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<div>'. Auth::user()->setting()->sign_name_en .'</div>
						</td>
					</tr>
				</table>
				<div class="color_red" style="color: red; text-decoration: underline; text-align: center; position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%);">សូមយកវេជ្ជបញ្ជាមកវិញពេលមកពិនិត្យលើក្រោយ</div>
				<br/>
			</section>';
		}

		return response()->json(['echoes_detail' => $echoes_detail, 'title' => $title]);
		// return $echoes_detail;

	}

	public function create($request, $path, $type)
	{
		$echo_default_description = EchoDefaultDescription::where('slug', $type)->first();
		$request->patient_id = GlobalComponent::GetPatientIdOrCreate($request);
		$echoes = Echoes::create(GlobalComponent::MergeRequestPatient($request, [
			'date' => $request->date,
			'pt_diagnosis' => $request->pt_diagnosis,
			// 'description' => $request->description,
			'description' => str_replace('\'', '\\\'', $request->description),
			'echo_default_description_id' => $echo_default_description->id,
			'created_by' => Auth::user()->id,
			'updated_by' => Auth::user()->id,
		]));
		
		if ($request->file('image')) {
			$image = $request->file('image');
			$echoes_image = time() .'_'. $echoes->id .'.png';
			$img = Image::make($image->getRealPath())->save($path.$echoes_image);
			$echoes->update(['image'=>$echoes_image]);
		}
		return $echoes;
	}

	public function update($request, $echoes, $path)
	{
		$echoes->update(GlobalComponent::MergeRequestPatient($request, [
			'date' => $request->date,
			'pt_diagnosis' => $request->pt_diagnosis,
			'description' => $request->description,
			'updated_by' => Auth::user()->id,
		]));
		
		if ($request->file('image')) {
			$image = $request->file('image');
			$echoes_image = (($echoes->image!='default.png')? $echoes->image : time() .'_'. $echoes->id .'.png');
			$img = Image::make($image->getRealPath())->save($path.$echoes_image);
			$echoes->update(['image'=>$echoes_image]);
		}
		return $echoes;
	}

	public function destroy($request, $echoes, $path)
	{
    if (Hash::check($request->passwordDelete, Auth::user()->password)){
			
			$image = $echoes->image;
			if($echoes->delete()){

				if ($echoes->image!='default.png') {
					File::deleteDirectory($path.$image);
				}

				return $request->pt_name;
			}
    }else{
        return false;
    }
	}


}