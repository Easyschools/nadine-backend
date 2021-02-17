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
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.dashboard.index');
    }
}
