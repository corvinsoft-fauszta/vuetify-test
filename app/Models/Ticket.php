<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string title
 * @property string description
 * @property \DateTime due
 * @property integer status
 */
class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'due', 'status'];
}
