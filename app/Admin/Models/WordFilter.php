<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9
 * Time: 11:30
 */
namespace App\Admin\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WordFilter extends Model{


    protected $table = "meeting_word_filter";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
}