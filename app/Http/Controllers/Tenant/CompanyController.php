<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCompanyFormRequest;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Http\Request;
use View;

class CompanyController extends Controller
{
    private $repository;


    public function __construct(CompanyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            return $this->repository->dataTables('action', 'tenants.companies.partials.acoes');
        }

        return view('tenants.companies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenants.companies.create');
    }

    /**
     * @param StoreUpdateCompanyFormRequest $request
     * @return array|\Illuminate\Http\RedirectResponse|null
     */
    public function store(StoreUpdateCompanyFormRequest $request)
    {
        $company = $this->repository->create($request->all());


        if (!$company) {
            return redirect()->route('companies.create');
        }

        return redirect()->route('companies.index')
                         ->with('success', 'Cadastro realizado com sucesso!');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$company = $this->repository->find($id)) {
            return redirect()->back();
        }

        return view('tenants.companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$company = $this->repository->find($id)) {
            return redirect()->back();
        }

        return view('tenants.companies.create', compact('company'));
    }

    /**
     * @param StoreUpdateCompanyFormRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreUpdateCompanyFormRequest $request, $id)
    {
        if (!$company = $this->repository->find($id)) {
            return redirect()->back()
                             ->withInput();
        }

        $company->update($request->all());

        return redirect()->route('companies.index')
                         ->with('success', 'Cadastro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$company = $this->repository->find($id)) {
            return redirect()->back();
        }

        $company->delete();

        return redirect()->route('companies.index')
                         ->with('success', 'Deletado com sucesso');
    }

    public function register(StoreUpdateCompanyFormRequest $request)
    {
        $company = $this->repository->create($request->all());


        if (!$company) {
            return redirect()->route('/');
        }

        return view('congratulations', compact('company'));
    }

    public function verifyDomain(Request $request)
    {
        if (request()->ajax()) {
            return response()->json($this->repository->subDomainExists($request->get('subdomain')));
        }
    }

}
