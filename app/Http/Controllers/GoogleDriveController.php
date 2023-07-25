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
        $folderId = $request->id;
        $folderId = '15vUtgKnFEzNbgw0TIujqcc59RsfSNZll';
        if($folderId == Null){
            if(Auth::user()->role_id === 3){
                $folderId = env('GOOGLE_BEFRIENDER_FOLDER_ID');
            }
            if(Auth::user()->role_id === 5){
                $folderId = env('GOOGLE_PATIENT_FOLDER_ID');
            }
        }
        $client = new \Google_Client();
        $client->setAuthConfig('../app/client_secret.json');
        $client->refreshToken('1//04d7IcOxa8iRxCgYIARAAGAQSNwF-L9Ir3Yd2c-vuBtA-TKAbmLtaVoQizQYZmYndp-IkBwK9rKseeMH7RtJ9wb7lNGounsjq7oE');
        $client->setScopes(\Google_Service_Drive::DRIVE);
        $client->setAccessType('offline');
        $service = new \Google_Service_Drive($client);
        $email = "muhammadimran4884@gmail.com";
        $permission = new \Google_Service_Drive_Permission(array(
            'type' => 'user',
            'role' => 'reader',
            'emailAddress' => $email,
        ));
        // $createdPermission = $service->permissions->create($folderId, $permission);
        // $permissionId = $createdPermission->getId();
        // dd($permissionId);
        // $service->permissions->delete($folderId, '00919110220330500768');
        // dd($service);
        // dd($folderId);
        $client->setScopes([Drive::DRIVE_READONLY]);
        $drive = new Drive($client);
        $response = $drive->files->listFiles([
            'q' => "'{$folderId}' in parents",
        ]);
        $files = $response->getFiles();
        // dd($files);
        return view('admin.google-file-manager', ['files' => $files]);
    }
}