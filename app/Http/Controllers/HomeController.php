<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\Category\CategoryContract;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategoryContract $categoryContract)
    {
        $this->categoryRepo = $categoryContract;

    }

    public function index()
    {
        $categories = $this->categoryRepo->getAll();
        return view('welcome', compact('categories'));
    }
}
