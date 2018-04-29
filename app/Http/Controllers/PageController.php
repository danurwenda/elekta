<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Twitter;

/**
 * 
 */
class PageController extends Controller {

    public function getWilayah() {
        return view('pages.wilayah');
    }

    public function getWifi() {
        return view('pages.wifi');
    }

    public function getAgenda() {
        return view('pages.agenda');
    }

    public function getSurvey() {
        return view('pages.survey');
    }

    public function getRekomendasi() {
        return view('pages.rekomendasi');
    }

    public function getAbout() {
        $name = 'Macbeth DeSade';
        return view('pages.about', ['name' => $name]);
    }

    public function getContact() {
        return view('pages.contact');
    }

    public function getCharts() {
        return view('ews.charts');
    }

}
