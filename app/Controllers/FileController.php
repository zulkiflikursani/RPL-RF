<?php

namespace App\Controllers;


class FileController extends BaseController
{
    public function index()
    {
        return "success";
    }
    public function getFile($fileName)
    {
        $filePath = '/mnt/Files-Silaju/uploads/berkas/' . $fileName;
        echo $filePath;
        die;
        if (file_exists($filePath)) {
            return $this->response->download($filePath, null);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($fileName . ' not found');
        }
    }

    //testing
    // https://silaju.unifa.ac.id/berkas/20241-0305/1727059737_d5acd265a2f2bfd7e7d7.pdf
}