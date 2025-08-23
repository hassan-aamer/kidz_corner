<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $count = [
            'users' => \App\Models\User::count(),
            'products' => \App\Models\Product::count(),
            'categories' => \App\Models\Category::count(),
            'contacts' => \App\Models\Contact::count(),
            'orders' => \App\Models\Order::count(),
        ];
        return view('admin.dashboard', compact('count'));
    }
}
