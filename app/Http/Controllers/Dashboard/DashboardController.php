<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 16/02/21
 * Time: 05:06 م
 */

namespace App\Http\Controllers\Dashboard;


class DashboardController
{
    public function index()
    {
        return view('admin.index');
    }
}
