<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio', 'user_id', 'branch_office_id', 'status', 'type', 'ticket_details', 'acknowledgments_message', 'total_price', 'qr_code'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function branchOffice() {
        return $this->belongsTo(BranchOffice::class);
    }
}
