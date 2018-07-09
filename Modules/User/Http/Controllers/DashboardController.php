<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * Mostra o painel de controle.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user::pages.dashboard.index');
    }

}
