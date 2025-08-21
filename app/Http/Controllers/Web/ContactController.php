<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Contact\ContactService;
use App\Services\Categories\CategoryService;
use App\Http\Requests\Contact\ContactRequest;

class ContactController extends Controller
{
    protected ContactService $service;
    protected CategoryService $categoryService;
    public function __construct(ContactService $service, CategoryService $categoryService)
    {
        $this->service = $service;
        $this->categoryService = $categoryService;
    }
    public function index()
    {
        $result = [
            'categories_search' => $this->categoryService->index()->where('active', 1)->take(10),
        ];
        return view('web.pages.contact', compact('result'));
    }
    public function store(ContactRequest $request)
    {
        try {
            $this->service->store($request->validated());
            return redirect()->back()->with('success', __('attributes.OperationCompletedSuccessfully'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to create Contact: ' . $e->getMessage());
        }
    }
}
