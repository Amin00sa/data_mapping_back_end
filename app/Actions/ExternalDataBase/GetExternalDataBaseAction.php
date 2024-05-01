<?php

namespace App\Actions\ExternalDataBase;

use App\Models\ExternalDataBase;
use Illuminate\Database\Eloquent\Builder;

class GetExternalDataBaseAction
{
    /**
     * @param ExternalDataBase $externalDataBase
     * @return Builder|ExternalDataBase
     */
    public function execute(ExternalDataBase $externalDataBase): Builder|ExternalDataBase
    {
        return ExternalDataBase::with('entries')->withCount('dataEntries')->find($externalDataBase->id);
    }
}
