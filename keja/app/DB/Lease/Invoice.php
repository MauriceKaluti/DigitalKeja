<?php

namespace App\DB\Lease;

use App\DB\Tenant;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Innox\Traits\IsUploadable;

class Invoice extends Model
{
    use IsUploadable;

    protected $guarded = [];

    protected $appends = [
        'invoice_no'
    ];

    protected $with = ['lease','invoiceItems','payments','tenant'];

    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function lease()
    {
        return $this->belongsTo(Lease::class)->where('is_active', true)->with('tenant');

    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);

    }


    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class , 'invoice_id','id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class , 'invoice_id','id');
    }
    public function save(array  $options = [])
    {
       if (is_null($this->user_id))
       {
           $this->user_id =  isset(auth()->user()->id) ? auth()->id() : User::first()->id;
       }
        parent::save();
    }



    public function scopeTenantId($query)
    {
        return $query->addSelect(['tenant_id' => Lease::select('tenant_id')
            ->whereColumn('invoices.lease_id', 'leases.id')
            ->latest('id')
            ->limit(1)
        ]);

    }


    /** Custom methos*/

    public function getColorAttribute()
    {
        $color = "label label-";

        if ($this->status == 'un paid'){
            $color .= 'danger';
        }
        if ($this->status == 'partially paid'){
            $color .= 'warning';
        }
        if ($this->status == 'paid'){
            $color .= 'success';
        }

        return $this->attributes['color'] = $color;

    }
    public function getInvoiceNoAttribute($value)
    {


        return $this->attributes['invoice_no'] = $value;

    }

    public function total()
    {
        return $this->invoiceItems->sum('amount');
    }

    public function balance()
    {
        return $this->invoiceItems->sum('amount') - $this->payments->sum('amount');

    }

}
