<?php

namespace App\Imports;

use App\Models\User;
use App\Models\UserKyc;
use App\Models\Comission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $user = new User;
        $user->name = $row['name'];
        $user->phone = $row['phone'];
        $user->email = $row['email'];
        $user->password = Hash::make(123456);
        $user->address = $row['address'];
        $user->referral_by = $row['referral_by'];
        $user->referral_code = $row['referral_code'];
        $user->save();


        $user_bank = new UserKyc;
        $user_bank->user_id =  $user->id ;
        $user_bank ->save();

        if (!empty($user->referral_by)) {

            $commission_data = commissions();

            $level = 18;
            $referral_code = $user->referral_by;
            for ($i = 1; $i <= $level; $i++) {
                $refferal_customer = User::where('referral_code', $referral_code)->first();

                if (!empty($refferal_customer->id)) {
                    $commission = new Comission;
                    $commission->user_id = $refferal_customer->id;
                    $commission->referral_user_id = $user->id;
                    $commission->commission = $commission_data[$i - 1];
                    $commission->level = $i;
                    $commission->status = 0;
                    $commission->save();

                    $referral_code = $refferal_customer->referral_by;
                }
            }
        }


    }
}
