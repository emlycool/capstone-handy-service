<?php
namespace App\Actions\Provider\ServiceCategory;

use App\Exceptions\ApiException;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class DeleteServiceCategoryAction
{
    public function handle(Service $serviceCategory): int
    {
        $count =  DB::table($serviceCategory->getTable())->where("id", $serviceCategory->id)->delete();
        throw_if($count == 0, new ApiException(msg: "Failed to deleted serivce category"));
        return $count;
    }
}