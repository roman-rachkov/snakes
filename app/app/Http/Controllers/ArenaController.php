<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class ArenaController extends Controller
{
    public function index() {
        return Room::open();
    }
}
