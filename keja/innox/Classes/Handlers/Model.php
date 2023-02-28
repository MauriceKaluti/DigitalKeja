<?php


namespace Innox\Classes\Handlers;


use App\DB\Business\AuditLog;
use App\User;
use Innox\Traits\IsMetable;
use Innox\Traits\IsUploadable;

class Model extends \Illuminate\Database\Eloquent\Model
{
    use IsUploadable, IsMetable;

    protected $guarded  = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAmountAttribute($amount)
    {
        return $this->attributes['amount'] =  floatval(str_replace(',','', $amount));
    }
    public function getNameAttribute($name)
    {
        return $this->attributes['name'] = ucwords(strtolower($name));
    }

    public function delete()
    {
        $this->createLog([
            'original' =>  $this->getOriginal(),
            'dirty'  => $this->getDirty(),
            'class'  =>  get_class($this),
            'user_id'  => request()->user()->id
        ]);
        parent::delete();

    }


    /**
     * Update the model in the database.
     *
     * @param  array  $attributes
     * @param  array  $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = [])
    {
        $this->createLog([
            'original' =>  $this->getOriginal(),
            'dirty'  => $this->getDirty(),
            'class'  =>  get_class($this),
            'user_id'  => request()->user()->id
        ]);

        parent::update();

    }
    private function createLog(array $log)
    {
        AuditLog::create([
            'original' =>  json_encode($log['original']),
            'dirty'  =>  json_encode($log['dirty']),
            'class'  => $log['class'],
            'user_id'  => $log['user_id']
        ]);

    }

}
