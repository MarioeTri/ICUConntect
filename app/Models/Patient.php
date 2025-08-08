<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name', 'access_key', 'condition', 'family_member_name', 'phone_number',
        'emergency_phone_number', 'id_card_number', 'address', 'room_responsible_nurse_id',
        'room_responsible_nurse_phone', 'doctor_name', 'doctor_phone', 'face_image'
    ];

    public function conditionHistories()
    {
        return $this->hasMany(ConditionHistory::class);
    }

    public function responsibleNurse()
    {
        return $this->belongsTo(Nurse::class, 'room_responsible_nurse_id');
    }
}