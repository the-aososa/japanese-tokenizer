<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VocabWords extends Model
{
    use HasFactory;

    protected $table = 'vocab_words';

    protected $fillable = ['id', 'word', 'meaning'];

    public $timestamps = false;

    public $incrementing = false;
}
