<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Services\Orders\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
        private $folderPath = 'admin.orders.';
    protected OrderService $service;
    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }
    public function index(Request $request)
    {
        $result = $this->service->index($request);
        return view($this->folderPath . 'index', compact('result'));
    }
    public function show($id)
    {
        $result = $this->service->show($id);
        return view($this->folderPath . 'show', compact('result'));
    }
    public function create()
    {
        return view($this->folderPath . 'create_and_edit', ['result' => null]);
    }
    // public function store(Request $request)
    // {
    //     try {
    //         $this->service->store($request->validated());
    //         return redirect()->route('admin.cities.index')->with('success', __('attributes.OperationCompletedSuccessfully'));
    //     } catch (\Throwable $e) {
    //         return redirect()->back()->with('error', 'Failed to create city: ' . $e->getMessage());
    //     }
    // }
    public function edit($id)
    {
        $result = $this->service->edit($id);
        return view($this->folderPath . 'create_and_edit', compact('result'));
    }
    public function update(Request $request, $id)
    {
        try {
            $this->service->update($request->all(), $id);
            return redirect()->route('admin.orders.index')->with('success', __('attributes.OperationCompletedSuccessfully'));
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
