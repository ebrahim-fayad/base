<?php

namespace App\Services\CountryCities;

use App\Models\AllUsers\User;
use App\Services\Core\BaseService;
use App\Models\CountryCity\Country;
use Illuminate\Support\Facades\File;

class CountryService extends BaseService
{
    public function __construct()
    {
        $this->model = Country::class;
    }


    public function getFlags()
    {
        $flags = [];
        foreach (File::files(public_path('admin/assets/flags/png')) as $path) {
            $file = pathinfo($path);
            $flags[] =  $file['filename'] . '.' . $file['extension'];
        }
        return $flags;
    }

    /**
     * Get flag filename for a specific country
     *
     * @param string $countryName English name of the country
     * @return string|null Flag filename or null if not found
     */
    public function getFlagByCountryName(string $countryName): ?string
    {
        // Map country names to ISO country codes (flag file names)
        $countryToCode = [
            'Saudi Arabia' => 'sa',
            'Egypt' => 'eg',
            'UAE' => 'ae',
            'El-Bahrean' => 'bh',
            'Bahrain' => 'bh',
            'Qatar' => 'qa',
            'Libya' => 'ly',
            'Kuwait' => 'kw',
            'Oman' => 'om',
        ];

        $countryCode = $countryToCode[$countryName] ?? null;

        if (!$countryCode) {
            return null;
        }

        $flags = $this->getFlags();

        // Look for flag file matching the country code (case-insensitive)
        foreach ($flags as $flag) {
            $flagName = strtolower(pathinfo($flag, PATHINFO_FILENAME));
            if ($flagName === strtolower($countryCode)) {
                return $flag;
            }
        }

        return null;
    }

    public function delete(int $id, array $relationsToCheck = [], array $conditions = [],array $relationConditions = []): array
    {
        $country = $this->model::find($id);

        $users = User::where('country_code', 'LIKE', '%' . fixPhone($country->key) . '%')->exists();
        if ($users) {
            return ['key' => 'error', 'msg' => __('admin.country_related_with_users')];
        }

        $country->delete();

        return ['key' => 'success', 'msg' => __('admin.deleted_successfully')];
    }

    public function deleteAll($request, array $relationsToCheck = []): array
    {
        $requestIds = json_decode($request['data']);
        $has_users = false;

        foreach (array_column($requestIds, 'id') as $id) {
            $country = $this->model::find($id);
            $users = User::where('country_code', 'LIKE', '%' . fixPhone($country->key) . '%')->exists();
            if ($users) {
                $has_users = true;
                break;
            } else {
                $country->delete();
            }
        }
        return [
            'key' => $has_users ? 'error' : 'success',
            'msg' => !$has_users ?  __('admin.deleted_successfully') : __('admin.country_related_with_users_or_cities')
        ];
    }
}
