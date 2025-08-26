<?php

namespace App\Http\Controllers\Admin\Areas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Cities\CityService;
use App\Http\Requests\Cities\CityRequest;
use App\Models\City;

class AreaController extends Controller
{
    private $folderPath = 'admin.areas.';
    protected CityService $service;
    public function __construct(CityService $service)
    {
        $this->service = $service;
    }
    public function index(Request $request)
    {
        $result = City::where('parent_id', '!=', null)->get();
        return view($this->folderPath . 'index', compact('result'));
    }
    public function show($id)
    {
        $result = $this->service->show($id);
        return view($this->folderPath . 'index', compact('result'));
    }
    public function create()
    {
        $cities = City::where('parent_id', null)->get();
        return view($this->folderPath . 'create_and_edit', ['result' => null], compact('cities'));
    }
    public function store(CityRequest $request)
    {
        try {
            $this->service->store($request->validated());
            return redirect()->route('admin.areas.index')->with('success', __('attributes.OperationCompletedSuccessfully'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to create city: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $result = $this->service->edit($id);
        $cities = City::where('parent_id', null)->get();
        return view($this->folderPath . 'create_and_edit', compact('result', 'cities'));
    }
    public function update(CityRequest $request, $id)
    {
        try {
            $this->service->update($request->validated(), $id);
            return redirect()->route('admin.areas.index')->with('success', __('attributes.OperationCompletedSuccessfully'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to update city: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        $this->service->destroy($id);
    }
    public function changeStatus(Request $request)
    {
        $this->service->changeStatus($request);
    }
}
