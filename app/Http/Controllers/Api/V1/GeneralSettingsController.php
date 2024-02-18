<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\GeneralSettingsRequest;
use App\Http\Resources\GeneralSettingsResource;
use App\Models\GeneralSettings;
use App\Traits\BaseApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class GeneralSettingsController extends Controller
{
    use BaseApiResponseTrait;

    public function index(GeneralSettings $settings): JsonResponse
    {
       return $this->respondWithJson(new GeneralSettingsResource($settings));
    }

    public function update(GeneralSettings $settings, GeneralSettingsRequest $request): JsonResponse
    {
        $settings->site_name = $request->string('site_name');
        $settings->save();

        return $this->respondWithJson($settings);
    }

    public function changeLanguage($locale)
    {
        $locale_array = ['en', 'ar'];
        if (in_array($locale, $locale_array)) {
            Cookie::queue(Cookie::make('locale', $locale, 14400));
            $after = Cookie::get('locale');
            if ($locale != $after) {
                Cookie::make('locale', $locale, 14400);
            }
            App::setLocale($locale);
        }
        return $locale;
    }
}
