<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Group\Entities\Group;
use Illuminate\Routing\Controller;
use Modules\Project\Entities\Program;
use Modules\Project\Entities\Project;
use Modules\Member\Entities\Member;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Publication;

class DashboardController extends Controller
{
    /**
     * @static int
     */
    const PER_PAGE = 3;

    /**
     * Mostra o painel de controle.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $counts = [
            'groups' => Group::count(),
            'members' => Member::count(),
            'programs' => Program::count(),
            'projects' => Project::count(),
            'products' => Product::count(),
            'publications' => Publication::count(),
        ];
        $groups = Group::orderBy('created_at', 'desc')
            ->simplePaginate(self::PER_PAGE);
        $members = Member::orderBy('created_at', 'desc')
            ->simplePaginate(self::PER_PAGE);
        $programs = Program::orderBy('created_at', 'desc')
            ->simplePaginate(self::PER_PAGE);
        $projects = Project::orderBy('created_at', 'desc')
            ->simplePaginate(self::PER_PAGE);
        $products = Product::orderBy('created_at', 'desc')
            ->simplePaginate(self::PER_PAGE);
        $publications = Publication::orderBy('created_at', 'desc')
            ->simplePaginate(self::PER_PAGE);

        return view('user::pages.dashboard.index', [
            'counts' => $counts,
            'groups' => $groups,
            'members' => $members,
            'programs' => $programs,
            'projects' => $projects,
            'products' => $products,
            'publications' => $publications,
        ]);
    }

}
