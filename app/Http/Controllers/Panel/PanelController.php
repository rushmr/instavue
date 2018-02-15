<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Vkservice;
use InstagramAPI\Instagram;
use InstagramAPI\Media\Photo\InstagramPhoto;

use App\Post;
use App\Project;
use App\Setting;
use Session;
use Auth;
use File;
use Storage;

class PanelController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
         return view('layouts.panel');
    }

}
