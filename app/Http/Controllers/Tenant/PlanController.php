<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePlanFormRequest;
use App\Repositories\Contracts\PlanRepositoryInterface;


class PlanController extends Controller
{
    private $repository;

    public function __construct(PlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return $this->repository->dataTables('action', 'tenants.plans.partials.acoes');
        }

        return view('tenants.plans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenants.plans.create');
    }

    /**
     * @param StoreUpdatePlanFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUpdatePlanFormRequest $request)
    {
        $return = $this->repository->create($request->all());

        if (!$return['status']) {
            return redirect()->back()
                ->withInput()
                ->withErrors($return['message']);
        }

        return redirect()->route('plans.index')
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
        if (!$plan = $this->repository->find($id)) {
            return redirect()->back();
        }

        return view('tenants.plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$plan = $this->repository->relationships('plan_details')->find($id)) {
            return redirect()->back();
        }

        return view('tenants.plans.create', compact('plan'));
    }

    /**
     * @param StoreUpdatePlanFormRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreUpdatePlanFormRequest $request, $id)
    {
        $return = $this->repository->update($id, $request->all());

        if (!$return['status']) {
            return redirect()->back()
                             ->withInput()
                             ->withErrors($return['message']);
        }

        return redirect()->route('plans.index')
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
        if (!$plan = $this->repository->find($id)) {
            return redirect()->back();
        }

        $plan->delete();

        return redirect()->route('plans.index')
                         ->with('success', 'Deletado com sucesso');
    }

    public function destroyDetail()
    {
        if (request()->ajax()) {
            $id = request()->get('id');

            return $this->deleteDetail($id);
        }
    }

    public function choosePlan()
    {
        $plans = $this->repository
                      ->relationships('plan_details')
                      ->where('state_paypal', '=', 'active');

        return view('plans', compact('plans'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    private function deleteDetail($id): \Illuminate\Http\JsonResponse
    {
        if ($delete = $this->repository->destroyDetail($id)) {
            return response()->json(['result' => 'true']);
        }
    }
}
