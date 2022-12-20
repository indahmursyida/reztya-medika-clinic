<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home() {
        $service = DB::table('services')->where('service_id', '=', 2)->first();
        /*
        $url = "https://www.nuskin.com/en_US/topnav-skin-and-beauty/popular.html";
        $html = file_get_contents($url);

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_use_internal_errors(false);
        $path = new \DOMXPath($dom);
        $div = $path->query('//div[data-v-3480b6f6]');
        $div = $div->item(0);
        echo $dom->saveXML($div);
        */
        return view('home.home_page')->with(compact('service'));
    }
}
