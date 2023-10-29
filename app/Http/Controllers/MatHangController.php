<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MatHang;

class MatHangController extends Controller
{
    //
    public function index()
    {
        $matHangs = MatHang::with("dev_team")->paginate(2);
        return view("products.shop", compact("matHangs"));
    }
}
