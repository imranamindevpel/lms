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
        $client = new \Google_Client();
        $client->setAuthConfig('../app/client_secret.json');
        $client->refreshToken('1//047Se-3Lsa67CCgYIARAAGAQSNwF-L9IrX1lXz1B2C7tyU4fK2IYKOXidrdAOCFUkbYyiMu854Kd1_JRIFJhbLwSUv8vguHV9ZNE');
        $client->setScopes(\Google_Service_Drive::DRIVE);
        $client->setAccessType('offline');
        $service = new \Google_Service_Drive($client);
        $folderId = '15vUtgKnFEzNbgw0TIujqcc59RsfSNZll';
        $folder = $service->files->get($folderId);
        $folderName = $folder->getName();
        // Create a directory on your server to store the downloaded files
        $directoryPath = public_path('downloads/' . $folderName);
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }
        // Retrieve the files within the folder
        $files = $service->files->listFiles([
            'q' => "'{$folderId}' in parents",
            'fields' => 'files(id, name, mimeType)',
        ])->getFiles();
        
        // Download each file within the folder
        foreach ($files as $file) {
            $fileId = $file->getId();
            $fileName = $file->getName();
            $fileMimeType = $file->getMimeType();
            // Determine the file path on your server
            $filePath = $directoryPath . '/' . $fileName;
            $fileMimeType = $file->getMimeType();
            if(strpos($fileMimeType, 'application/vnd.google-apps.folder') !== 0){
                // Determine the file path on your server
                $filePath = $directoryPath . '/' . $fileName;
                // dd($filePath);
                // Download the file
                $response = $service->files->get($fileId, [
                    'alt' => 'media',
                ]);
                file_put_contents($filePath, $response->getBody());
                // dd(file_put_contents($filePath, $response->getBody()));
            }
        }        
        dd($files);



        $email = "haseeb.devp@gmail.com";
        $permission = new \Google_Service_Drive_Permission(array(
            'type' => 'user',
            'role' => 'reader',
            'emailAddress' => $email,
        ));
        $createdPermission = $service->permissions->create($folderId, $permission);
        $permissionId = $createdPermission->getId();
        dd($permissionId);
        $service->permissions->delete($folderId, '00919110220330500768');
        dd($service);


        
        $folderId = $request->id;
        if($folderId == Null){
            if(Auth::user()->role_id === 3){
                $folderId = env('GOOGLE_BEFRIENDER_FOLDER_ID');
            }
            if(Auth::user()->role_id === 5){
                $folderId = env('GOOGLE_PATIENT_FOLDER_ID');
            }
        }
        // Access Google Drive Files Through "OWNER EMAIL"
        $client = new \Google_Client();
        $client->setAuthConfig('../app/client_secret.json');
        $client->refreshToken('1//047Se-3Lsa67CCgYIARAAGAQSNwF-L9IrX1lXz1B2C7tyU4fK2IYKOXidrdAOCFUkbYyiMu854Kd1_JRIFJhbLwSUv8vguHV9ZNE');
        
        // Access Google Drive Files Through "SERVICE ACCOUNT"
        // $client = new Client();
        // $client->setAuthConfig('../app/service-account-key.json');
        $client->setScopes([Drive::DRIVE_READONLY]);
        $drive = new Drive($client);
        $response = $drive->files->listFiles([
            'q' => "'{$folderId}' in parents",
        ]);
        $files = $response->getFiles();
        
        return view('file-manager', ['files' => $files]);
    }
    private function isFileBinary($mimeType)
{
    // Define the MIME types for binary files
    $binaryMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'video/mp4',
        // Add more MIME types for binary files as needed
    ];

    return in_array($mimeType, $binaryMimeTypes);
}
}
// $client->addScope(['https://www.googleapis.com/auth/drive',
// 'https://www.googleapis.com/auth/drive.appdata',
// 'https://www.googleapis.com/auth/drive.file',
// 'https://www.googleapis.com/auth/drive.metadata',
// 'https://www.googleapis.com/auth/drive.metadata.readonly',
// 'https://www.googleapis.com/auth/drive.photos.readonly',
// 'https://www.googleapis.com/auth/drive.scripts']);