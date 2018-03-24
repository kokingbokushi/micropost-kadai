<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'user_id', 'micropost_id')->withTimestamps();
    }
    
    public function favorite($micropostId) 
    {   // 既にお気に入りしているかの確認 
        $exist = $this->is_favorite($micropostId); 
        // 自分自身ではないかの確認 
        $its_me = $this->id == $micropostId;
        
        if ($exist || $its_me) 
        {   // 既にお気に入りしていれば何もしない
            return false;
        } else {
            // 未お気に入りであればお気に入りする
            $this->favorites()->attach($micropostId);
            return true;
        }
    }

    public function unfavorite($micropostId)
    {
        // 既にお気に入りしているかの確認
        $exist = $this->is_favorite($micropostId);
        // 自分自身ではないかの確認
        $its_me = $this->id == $micropostId;
    
        if ($exist && !$its_me) {
            // 既にお気に入りしていればお気に入りを外す
            $this->favorites()->detach($micropostId);
            return true;
        } else {
            // 未お気に入りであれば何もしない
            return false;
        }
    }
    
    public function is_favorite($micropostId) {
    return $this->favorites()->where('micropost_id', $micropostId)->exists();
    }
    
    public function feed_favorites()
    {
        $favorite_user_ids = $this->favorites()->lists('microposts.id')->toArray();
        return Micropost::whereIn('user_id', $favorite_user_ids);
    }
}
