<?php

namespace App\Observers;

use App\Models\StoreAddress as ModelsStoreAddress;

class StoreAddress
{
    public function creating(ModelsStoreAddress $storeAddress): void
    {
        $storeAddress->store_id = app('currentTenant')->id;
    }

}
