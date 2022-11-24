<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentsScanning extends Model
{
    use HasFactory;
    protected $table = 'comments_scanning_log';
    protected $fillable = ['status', 'last', 'difference', 'requestorIp'];
}
