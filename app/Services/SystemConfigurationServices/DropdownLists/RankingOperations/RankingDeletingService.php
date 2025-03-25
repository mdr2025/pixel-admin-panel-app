<?php

namespace App\Services\SystemConfigurationServices\DropdownLists\RankingOperations;

use CRUDServices\CRUDServiceTypes\DeletingServices\DeletingService;

class RankingDeletingService extends DeletingService
{
    protected function getModelDeletingSuccessMessage(): string
    {
        return "The Ranking Has Been Deleted Successfully !";
    }

}
