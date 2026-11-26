<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['page', 'key', 'locale', 'label', 'value'])]
class ContentBlock extends Model {}
