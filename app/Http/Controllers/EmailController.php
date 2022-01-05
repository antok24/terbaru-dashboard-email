<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TesEmail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index(){

        $details = [
        'title' => 'Mail from App Umroh Tour',
        'body' => 'Ini adalah pesan yang dikirim untuk testing App Umroh tour dari Developer'
        ];
        
        Mail::to('utbdg2021@gmail.com')->send(new TesEmail($details));
        
        dd("Email sudah terkirim.");
    }
}
