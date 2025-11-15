<?php

namespace App\Models\UsersModule;

use PixelApp\Models\Interfaces\OptionalRelationsInterfaces\BelongsToBranch;
use PixelApp\Models\Interfaces\OptionalRelationsInterfaces\BelongsToDepartment;
use PixelApp\Models\Traits\OptionalRelationsTraits\BelongsToBranchMethods;
use PixelApp\Models\Traits\OptionalRelationsTraits\BelongsToDepartmentMethods;
use PixelApp\Models\UsersModule\PixelUser; 

class User extends PixelUser implements BelongsToDepartment , BelongsToBranch
{
    use BelongsToDepartmentMethods , BelongsToBranchMethods;
}
