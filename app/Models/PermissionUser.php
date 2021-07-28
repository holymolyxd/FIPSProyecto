<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class PermissionUser extends Pivot implements AuditableContract
{
    use HasFactory;
    use Auditable;

    public $incrementing = true;

    public function getKey()
    {
        return $this->getAttribute($this->getForeignKey()) ?? 0;
    }
}
