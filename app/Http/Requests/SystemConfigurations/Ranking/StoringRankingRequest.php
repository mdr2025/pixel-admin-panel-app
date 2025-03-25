<?php

namespace App\Http\Requests\SystemConfigurations\Ranking;

use App\Models\SystemConfigurationModels\Ranking;
use AuthorizationManagement\PolicyManagement\Policies\BasePolicy;
use CRUDServices\Interfaces\ValidationManagerInterfaces\NeedsModelKeyAdvancedValidation;
use ValidatorLib\CustomFormRequest\BaseFormRequest;


class StoringRankingRequest extends BaseFormRequest implements NeedsModelKeyAdvancedValidation
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return BasePolicy::check("create", Ranking::class);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function getModelKeyAdvancedValidationRules(array $data = []): array
    {
        return [
            "name" => ["unique:ranking,name"],
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            "items" => ["required", "array"],
            "items.*.name" => ["required", "string"],
            "items.*.status" => ["required", "boolean"],
        ];
    }
}
