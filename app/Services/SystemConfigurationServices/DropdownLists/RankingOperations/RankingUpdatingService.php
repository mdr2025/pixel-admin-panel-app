<?php

namespace App\Services\SystemConfigurationServices\DropdownLists\RankingOperations;

use App\Http\Requests\SystemConfigurations\Ranking\UpdatingRankingRequest;
use CRUDServices\CRUDServiceTypes\DataWriterCRUDServices\UpdatingServices\UpdatingService;


class RankingUpdatingService extends UpdatingService
{

    protected function getModelUpdatingFailingErrorMessage(): string
    {
        return "Failed To Update The Given Ranking !";
    }

    protected function getModelUpdatingSuccessMessage(): string
    {
        return "The Ranking Has Been Updated Successfully !";
    }

    protected function getRequestClass(): string
    {
        return UpdatingRankingRequest::class;
    }

}
