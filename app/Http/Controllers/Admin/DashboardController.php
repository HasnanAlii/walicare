<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Bisa tambahkan data untuk dashboard nanti, misalnya jumlah users, donations, dsb.
        return view('admin.dashboard');
    }
}
