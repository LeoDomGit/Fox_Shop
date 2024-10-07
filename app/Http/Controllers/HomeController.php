<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends BaseCrudController
{
        public function __construct()
    {
        $this->model = Home::class;
    }
    public function index()
    {
        return Inertia::render('Home/Index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(Home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Home $home)
    {
        //
    }

    public function destroy(Home $home)
    {
        //
    }
}
