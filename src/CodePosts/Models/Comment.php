<?php

namespace CodePress\CodePosts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use CodePress\CodeUser\Models\User;

/**
 * Description of Comment
 *
 * @author gabriel
 */
class Comment extends Model
{
    use SoftDeletes;
    
    protected $table = "codepress_comments";
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'content', 'post_id'
    ];
    
    private $validator;

    function getValidator()
    {
        return $this->validator;
    }
        
    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }
    
    public function isValid()
    {
        $validator = $this->validator;
        $validator->setRules([
            'content' => 'required'
            ]);
        $validator->setData($this->attributes);
        
        if($validator->fails())
        {
            $this->errors = $validator->errors();
            return false;
        }
        
        return true;
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

}
