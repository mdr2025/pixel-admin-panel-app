<?php

namespace App\Models\UsersModule;

use PixelApp\Models\Interfaces\BelongsToBranch;
use PixelApp\Models\Interfaces\BelongsToDepartment;
use PixelApp\Models\Traits\BelongsToBranchMethods;
use PixelApp\Models\Traits\BelongsToDepartmentMethods;
use PixelApp\Models\UsersModule\PixelUser; 

class User extends PixelUser implements BelongsToDepartment , BelongsToBranch
{
    use BelongsToDepartmentMethods , BelongsToBranchMethods;
}
