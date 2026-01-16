<?php

namespace App\Listeners;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Models\User;
use App\Traits\NotifyTrait;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Session;
use Txn;

class GiveSignupBonus
{
    use NotifyTrait;

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $user = $event->user;

        // 1. Signup Bonus for the User
        if (setting('referral_signup_bonus', 'permission') && (float) setting('signup_bonus', 'fee') > 0) {
            // Check if already given to avoid duplicates
            $hasBonus = $user->transaction()->where('type', TxnType::SignupBonus)->exists();
            
            if (!$hasBonus) {
                $signupBonus = (float) setting('signup_bonus', 'fee');
                $user->increment('balance', $signupBonus);
                Txn::new($signupBonus, 0, $signupBonus, 'system', 'Signup Bonus', TxnType::SignupBonus, TxnStatus::Success, null, null, $user->id);
            }
        }

        // 2. Referral Bonus for the Referrer
        if ($user->ref_id && setting('sign_up_referral', 'permission')) {
            $referrer = User::find($user->ref_id);
            
            // Check if referrer is verified (if required)
            $isReferrerVerified = setting('email_verification', 'permission') ? $referrer->email_verified_at !== null : true;

            if ($referrer && $isReferrerVerified) {
                // Ideally check if bonus already given for this specific referral to avoid duplicates
                // Since we don't have a direct link in Txn table for "related user", we assume this event handles it once.
                
                $referralBonus = (float) setting('referral_bonus', 'fee');
                $referrer->increment('balance', $referralBonus);
                Txn::new($referralBonus, 0, $referralBonus, 'System', 'Referral Bonus via ' . $user->full_name, TxnType::Referral, TxnStatus::Success, null, null, $referrer->id);

                $shortcodes = [
                    '[[full_name]]' => $user->full_name,
                    '[[bonus_amount]]' => $referralBonus,
                    '[[currency]]' => setting('site_currency', 'global'),
                ];
                $this->pushNotify('referral_bonus', $shortcodes, route('user.transactions'), $referrer->id);
            }
        }
    }
}
