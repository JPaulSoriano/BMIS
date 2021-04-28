<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseController extends Controller
{
    //
    public function index()
    {
        $database = app('firebase.database');

        $reference = $database->getReference('Test');
        $snapshot = $reference->getSnapshot();

        $reference->set([
            'name' => 'Test',
            'emails' => [
                'email1' => 'test@test.com'
            ],
        ]);
    }
}
