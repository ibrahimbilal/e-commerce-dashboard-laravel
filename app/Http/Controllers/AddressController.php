<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ManagesTrashedRecords;
use App\Models\Address;
use App\Support\ReferentialDeleteGuard;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use ManagesTrashedRecords;

    public function __construct()
    {
        $this->registerTrashedMiddleware('customers');
    }

    public function restore(Request $request, int $id)
    {
        $address = $this->findOnlyTrashed(Address::class, $id);
        $address->restore();

        return $this->trashedActionResponse($request, 'customers.index', 'Address restored.');
    }

    public function forceDelete(Request $request, int $id)
    {
        $address = $this->findOnlyTrashed(Address::class, $id);

        if ($blocked = ReferentialDeleteGuard::blockIfInUse(
            $request,
            $address,
            'Cannot permanently delete this address because it is used on orders.'
        )) {
            return $blocked;
        }

        $address->forceDelete();

        return $this->trashedActionResponse($request, 'customers.index', 'Address permanently deleted.');
    }
}
