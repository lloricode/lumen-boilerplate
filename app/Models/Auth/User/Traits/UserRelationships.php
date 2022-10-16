<?php

declare(strict_types=1);

namespace App\Models\Auth\Traits;

namespace App\Models\Auth\User\Traits;

use App\Models\Auth\User\SocialAccount;

trait UserRelationships
{
    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }
}
