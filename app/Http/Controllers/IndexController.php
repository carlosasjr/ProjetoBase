<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateCompanyFormRequest;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Session;


class IndexController extends Controller
{
    private $repository;


    public function __construct(CompanyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        if (request()->getHost() != config('tenant.domain_main')) {
            return redirect()->route('home');
        }

        return view('welcome');
    }

    public function register(StoreUpdateCompanyFormRequest $request)
    {
        $company = $this->repository->create($request->all());


        if (!$company) {
            return redirect()->route('/');
        }

        return view('congratulations', compact('company'));
    }


   }
