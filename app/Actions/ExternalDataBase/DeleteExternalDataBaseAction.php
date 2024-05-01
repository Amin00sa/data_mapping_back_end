<?php

namespace App\Actions\ExternalDataBase;

use App\Models\ExternalDataBase;

class DeleteExternalDataBaseAction
{
    /**
     * @param ExternalDataBase $externalDataBase
     * @return bool
     */
    public function execute(ExternalDataBase $externalDataBase): bool
    {
        return $externalDataBase->delete();
    }
}
