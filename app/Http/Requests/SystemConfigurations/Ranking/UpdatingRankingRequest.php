<?php

namespace App\Http\Requests\SystemConfigurations\Ranking;

use App\Models\SystemConfigurationModels\Ranking;
use AuthorizationManagement\PolicyManagement\Policies\BasePolicy;
use CRUDServices\Interfaces\ValidationManagerInterfaces\NeedsModelKeyAdvancedValidation;
use Illuminate\Validation\Rule;
use ValidatorLib\CustomFormRequest\BaseFormRequest;

class UpdatingRankingRequest extends BaseFormRequest implements NeedsModelKeyAdvancedValidation
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return BasePolicy::check("edit", Ranking::class);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function getModelKeyAdvancedValidationRules(array $data = []): array
    {
        return [
            "name" => ["nullable", Rule::unique("ranking", "name")->ignore($data["id"])],
        ];
    }

    public function rules(): array
    {
        return [
            "name" => ["nullable", "string"],
            "status" => ["nullable", "boolean"],
        ];
    }
}
