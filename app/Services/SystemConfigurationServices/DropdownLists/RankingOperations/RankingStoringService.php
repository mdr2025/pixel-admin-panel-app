<?php

namespace App\Services\SystemConfigurationServices\DropdownLists\RankingOperations;

use App\Http\Requests\SystemConfigurations\Ranking\StoringRankingRequest;
use App\Models\SystemConfigurationModels\Ranking;
use CRUDServices\CRUDServiceTypes\DataWriterCRUDServices\StoringServices\MultiRowStoringService;

class RankingStoringService extends MultiRowStoringService
{

    protected function getModelCreatingFailingErrorMessage(): string
    {
        return "Failed To Create The Given Ranking !";
    }

    protected function getModelCreatingSuccessMessage(): string
    {
        return "The Ranking Has Been Created Successfully !";
    }

    protected function getModelClass(): string
    {
        return Ranking::class;
    }

    protected function getRequestClass(): string
    {
        return StoringRankingRequest::class;
    }

}
