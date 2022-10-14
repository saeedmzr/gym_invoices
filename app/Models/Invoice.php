<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = ['invoice_lines' => 'array'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function calculateTotalAmount()
    {
        $total_amount = 0;
        if(!empty($this->invoice_lines)) foreach ($this->invoice_lines as $invoice_line) $total_amount += $invoice_line['amount'];
        return $total_amount;
    }

    public function calculateMembershipCount()
    {
        $count = 0;
        if(!empty($this->invoice_lines)) foreach ($this->invoice_lines as $invoice_line) if ($invoice_line['type'] == 'membership') $count++;
        return $count;
    }

    public function calculateGuestCount()
    {
        $count = 0;
        if(!empty($this->invoice_lines)) foreach ($this->invoice_lines as $invoice_line) if ($invoice_line['type'] == 'guest') $count++;
        return $count;
    }
}
