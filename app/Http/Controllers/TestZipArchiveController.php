<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class TestZipArchiveController extends Controller
{
    public string $createdFolderBasePath;

    /**
     * Undocumented function
     *
     * @param array(
     * "folder_name": "test",
     * "child_folder":[
     *      {
     *          "folder_name": "test",
     *          "child_folder": [
     *                  "folder_name": "test",
     *                  "child_folder": []
     *          ],
     *      },
     *      {
     *          "folder_name": "test",
     *          "child_folder": [],
     *      },
     *   ]
     * )
     * @param string $path
     * @return void
     */
    public function createFolder(array $category, string $path): void
    {
        if (array_key_exists("folder_name", $category)) {
            $path1 = $path . "/" . $category["folder_name"];
            Storage::disk('public')->makeDirectory($path1);
            $this->addFileFromDbToFolder($category["id"], $path1);
            Log::info("-" . $path1);
        }

        if (count($category) == 0) return;

        foreach ($category["child_folders"] as $child) {
            $path2 = $path1 . "/" . $child["folder_name"];
            Storage::disk('public')->makeDirectory($path);
            $this->addFileFromDbToFolder($child["id"], $path2);
            Log::info("--" . $path2);
            if (count($child["child_folders"]) > 0) {
                foreach ($child["child_folders"] as $child2) {
                    $this->createFolder($child2, $path2);
                }
            }
        }
    }

    public function addFileFromDbToFolder(int $id, string $path): void
    {
        $files = FileModel::where("id", $id)->get();

        foreach ($files as $file) {
            Storage::disk('public')->copy($file->file_path, $path . "/" . $file->file_name);
        }
    }

    public function test1($id)
    {
        /**
         * make folder sequence with recursive folder list
         * add file to the specific folder
         */

        $folder = Model_Name::with("child_folders")->where("id", $dealerResourceId)->first();

        if (!$folder) {
            return response()->json([
                'status' => 404,
                'message' => "There are no folder exists."
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $downloadFolderPath = microtime(true);
            $this->createdFolderBasePath = $downloadFolderPath;
            $this->createFolder($folder->toArray(), "down");

            return "yes";

            $folderPath = storage_path("app/public/{$downloadFolderPath}");
            $zipFileName = "download-zip-file-" . microtime(true) . ".zip";
            $zipFilePath = public_path("{$zipFileName}");

            $zip = new ZipArchive();

            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($folderPath));

                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($folderPath) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
                $zip->close();

                /**
                 * remove created for for prepared zip file
                 *
                 */
                Storage::disk('public')->deleteDirectory($downloadFolderPath);
                return response()->download($zipFilePath)->deleteFileAfterSend(true);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Unable to retrieve the file: ' . $e->getMessage()
            ], 500);
        }
    }
}
