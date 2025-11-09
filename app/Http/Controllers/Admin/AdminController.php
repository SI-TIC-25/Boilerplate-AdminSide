<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizProgress;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function home(): View
    {
        $this->setMenuSession();
        $this->setUserSession();

        return view('AdminPages.dashboard');
    }

}
