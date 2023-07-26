<?php

namespace App\Http\Controllers;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoogleDriveController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $folderId = $request->id;
        if($folderId == Null){
            if($user->courses[0]->folder_id){
                $folderId = $user->courses[0]->folder_id;
            }
        }
        $client = new \Google_Client();
        $client->setAuthConfig('../app/client_secret.json');
        $client->refreshToken(env('GOOGLE_DRIVE_TOKEN'));
        $client->setAccessType('offline');
        $client->setScopes([Drive::DRIVE_READONLY]);
        $drive = new Drive($client);
        $response = $drive->files->listFiles([
            'q' => "'{$folderId}' in parents",
        ]);
        $files = $response->getFiles();
        return view('admin.google-file-manager', ['files' => $files]);
    }

    public function getCourseByFolderId(Request $request){
        $user = Auth::user();
        $folderId = $request->id;
        if($folderId == Null){
            if($user->courses[0]->folder_id){
                $folderId = $user->courses[0]->folder_id;
            }
        }
        $client = new \Google_Client();
        $client->setAuthConfig('../app/client_secret.json');
        $client->refreshToken(env('GOOGLE_DRIVE_TOKEN'));
        $client->setAccessType('offline');
        $client->setScopes([Drive::DRIVE_READONLY]);
        $drive = new Drive($client);
        $response = $drive->files->listFiles([
            'q' => "'{$folderId}' in parents",
        ]);
        $files = $response->getFiles();
        return view('admin.google-file-manager', ['files' => $files]);
    }
}