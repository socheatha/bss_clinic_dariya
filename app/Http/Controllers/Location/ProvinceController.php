<?php

namespace App\Http\Controllers\Location;

use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProvinceRequest;
use App\Repositories\Location\ProvinceRepository;
use Auth;

class ProvinceController extends Controller
{

    protected $provinces;

    public function __construct(ProvinceRepository $repository)
    {
        $this->provinces = $repository;
    }

    public function index()
    {
        $this->data = [
            'provinces' => $this->provinces->getData(),
        ];
        return view('province.index', $this->data);
    }

    public function getSelectDistrict(Request $request)
    {
        return $this->provinces->getSelectDistrict($request);
    }

    public function create()
    {
        return view('province.create');
    }

    public function store(ProvinceRequest $request)
    {
        if ($this->provinces->create($request)) {
            return redirect()->route('province.create')
                ->with('success', __('alert.crud.success.create', ['name' => Auth::user()->module()]) . $request->name);
        }
    }

    public function edit(Province $province)
    {
        $this->data = [
            'province' => $province,
        ];
        return view('province.edit', $this->data);
    }

    public function update(ProvinceRequest $request, Province $province)
    {
        if ($this->provinces->update($request, $province)) {
            return redirect()->route('province.index')
                ->with('success', __('alert.crud.success.update', ['name' => Auth::user()->module()]) . $request->name);
        }
    }

    public function destroy(Province $province)
    {
        return redirect()->route('province.index')
            ->with('success', __('alert.crud.success.delete', ['name' => Auth::user()->module()]) . $this->provinces->destroy($province));
    }
}
