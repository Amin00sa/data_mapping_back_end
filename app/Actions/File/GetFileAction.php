<?php

namespace App\Actions\File;

use App\Models\File;

class GetFileAction
{
    /**
     * @param File $file
     * @return File
     */
    public function execute(File $file): File
    {
        return $file;
    }
}
