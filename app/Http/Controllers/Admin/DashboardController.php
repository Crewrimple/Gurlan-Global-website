<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\NewsPost;
use App\Models\Product;
use App\Models\TeamMember;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'productsCount' => Product::count(),
            'newsCount' => NewsPost::count(),
            'teamCount' => TeamMember::count(),
            'messagesCount' => ContactMessage::where('is_read', false)->count(),
        ]);
    }
}
