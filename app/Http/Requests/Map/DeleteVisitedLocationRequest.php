<?php

namespace App\Http\Requests\Map;

use App\Http\Requests\MainFormRequest;
use App\Services\Map\VisitedLocationsDataService;

class DeleteVisitedLocationRequest extends MainFormRequest
{
    public function __construct(public VisitedLocationsDataService $locationService)
    {
        parent::__construct();
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->locationService->isLocationVisitedByUser(
            locationId: $this->input('location_id'),
            userId: $this->currentUser->id
        );
    }

    public function rules(): array
    {
        return [
            'location_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'location_id.required' => 'Select location.',
        ];
    }
}
