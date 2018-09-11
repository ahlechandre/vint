<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Group\Repositories\GroupRepository;
use Modules\Member\Repositories\MemberRepository;
use Modules\Project\Repositories\ProgramRepository;
use Modules\Project\Repositories\ProjectRepository;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Repositories\PublicationRepository;

class SearchController extends Controller
{
    /**
     * @var int
     */
    protected static $perPage = 15; 

    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $term = $request->query('q');

        // Caso nenhum termo tenha sido indicado, redireciona para
        // página inicial.
        if (!$term || empty($term)) {
            return redirect('/')
                ->with('snackbar', __('messages.search.empty_term'));
        }
        $resources = [
            [
                'name' => 'members',
                'items' => (new MemberRepository)
                    ->index(self::$perPage, $term)
                    ->data['members'],
            ],
            [
                'name' => 'groups',
                'items' => (new GroupRepository)
                    ->index(self::$perPage, $term)
                    ->data['groups']                
            ],
            [
                'name' => 'programs',
                'items' => (new ProgramRepository)
                    ->index(self::$perPage, $term)
                    ->data['programs']
            ],
            [
                'name' => 'projects',
                'items' => (new ProjectRepository)
                    ->index(self::$perPage, $term)
                    ->data['projects']
            ],
            [
                'name' => 'products',
                'items' => (new ProductRepository)
                    ->index(self::$perPage, $term)
                    ->data['products']
            ],
            [
                'name' => 'publications',
                'items' => (new PublicationRepository)
                    ->index(self::$perPage, $term)
                    ->data['publications']
            ]
        ];
        // Quantidade de recursos sem resultados.
        $countEmpty = array_reduce($resources, function ($initial, $resource) {
            return $resource['items']->isEmpty() ?
                $initial + 1 : $initial;
        }, 0);
        // Quantidade de recursos com resultados.
        $countResult = count($resources) - $countEmpty;
        // Quantidade de recursos com resultados é par?
        $isEvenResult = $countResult % 2 === 0;
        // Primeiro recurso (na ordem de precedência) com resultados.
        $firstWithResult = null;

        if ($countResult) {
            foreach ($resources as $resource) {
                if (!$resource['items']->isEmpty()) {
                    $firstWithResult = $resource['name'];
                    break;
                }
            }
        }

        return view('system::pages.search.index', [
            'term' => $term,
            'resources' => $resources,
            'firstWithResult' => $firstWithResult,
            'isEvenResult' => $isEvenResult
        ]);
    }
    
    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function members(Request $request)
    {
        $term = $request->query('q');

        // Caso nenhum termo tenha sido indicado, redireciona para
        // página inicial.
        if (!$term || empty($term)) {
            return redirect('/')
                ->with('snackbar', __('messages.search.empty_term'));
        }
        $index = (new MemberRepository)->index(self::$perPage, $term);

        return view('system::pages.search.members', [
            'term' => $term,
            'members' => $index->data['members']
        ]);
    }

    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function groups(Request $request)
    {
        $term = $request->query('q');

        // Caso nenhum termo tenha sido indicado, redireciona para
        // página inicial.
        if (!$term || empty($term)) {
            return redirect('/')
                ->with('snackbar', __('messages.search.empty_term'));
        }
        $index = (new GroupRepository)->index(self::$perPage, $term);

        return view('system::pages.search.groups', [
            'term' => $term,
            'groups' => $index->data['groups']
        ]);
    }

    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function programs(Request $request)
    {
        $term = $request->query('q');

        // Caso nenhum termo tenha sido indicado, redireciona para
        // página inicial.
        if (!$term || empty($term)) {
            return redirect('/')
                ->with('snackbar', __('messages.search.empty_term'));
        }
        $index = (new ProgramRepository)->index(self::$perPage, $term);

        return view('system::pages.search.programs', [
            'term' => $term,
            'programs' => $index->data['programs']
        ]);
    }

    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function projects(Request $request)
    {
        $term = $request->query('q');

        // Caso nenhum termo tenha sido indicado, redireciona para
        // página inicial.
        if (!$term || empty($term)) {
            return redirect('/')
                ->with('snackbar', __('messages.search.empty_term'));
        }
        $index = (new ProjectRepository)->index(self::$perPage, $term);

        return view('system::pages.search.projects', [
            'term' => $term,
            'projects' => $index->data['projects']
        ]);
    }

    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function products(Request $request)
    {
        $term = $request->query('q');

        // Caso nenhum termo tenha sido indicado, redireciona para
        // página inicial.
        if (!$term || empty($term)) {
            return redirect('/')
                ->with('snackbar', __('messages.search.empty_term'));
        }
        $index = (new ProductRepository)->index(self::$perPage, $term);

        return view('system::pages.search.products', [
            'term' => $term,
            'products' => $index->data['products']
        ]);
    }

    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function publications(Request $request)
    {
        $term = $request->query('q');

        // Caso nenhum termo tenha sido indicado, redireciona para
        // página inicial.
        if (!$term || empty($term)) {
            return redirect('/')
                ->with('snackbar', __('messages.search.empty_term'));
        }
        $index = (new PublicationRepository)->index(self::$perPage, $term);

        return view('system::pages.search.publications', [
            'term' => $term,
            'publications' => $index->data['publications']
        ]);
    }    
}
