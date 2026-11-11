<?php

namespace Database\Seeders;

use App\Models\FilingStatusLog;
use App\Models\Member;
use App\Models\ServiceFiling;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LegalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberUser = User::where('email', 'member@brandsacademy.org')->first() ?? User::where('role', 'member')->first();
        $adminUser = User::where('email', 'admin@brandsacademy.org')->first() ?? User::where('role', 'admin')->first();
        $member = $memberUser ? Member::where('user_id', $memberUser->id)->first() : null;

        // 1. Approved CAC Business Name
        $filing1 = ServiceFiling::firstOrCreate(
            ['tracking_code' => 'BANF-CAC-2026-APEX01'],
            [
                'user_id' => $memberUser?->id,
                'member_id' => $member?->id,
                'filing_type' => ServiceFiling::TYPE_CAC_BUSINESS_NAME,
                'proposed_name_1' => 'Apex Brand Dynamics',
                'proposed_name_2' => 'Apex Brand Strategy Enterprise',
                'proposed_name_3' => 'Apex Brand Consulting',
                'business_nature' => 'Brand strategy consulting, marketing research, corporate identity advisory, and brand asset management services.',
                'industry_category' => 'Professional Services & Consulting',
                'business_address' => 'Plot 14, Victoria Island Commercial Corridor, Lagos State',
                'headquarters_state' => 'Lagos',
                'client_first_name' => $member?->first_name ?? 'Samuel',
                'client_last_name' => $member?->last_name ?? 'Okonkwo',
                'client_email' => $memberUser?->email ?? 'samuel@apexbrand.ng',
                'client_phone' => '+234 803 111 2233',
                'client_nin' => '28192019283',
                'status' => ServiceFiling::STATUS_APPROVED,
                'total_fee' => 26250.00,
                'member_discount' => 8750.00,
                'fee_paid' => 26250.00,
                'payment_gateway' => 'paystack',
                'payment_reference' => 'LEGAL-APEX-001',
                'government_filing_number' => 'BN 3928172',
                'submitted_at' => Carbon::now()->subDays(6),
                'approved_at' => Carbon::now()->subDay(),
            ]
        );

        FilingStatusLog::firstOrCreate(
            [
                'service_filing_id' => $filing1->id,
                'to_status' => ServiceFiling::STATUS_APPROVED,
            ],
            [
                'from_status' => ServiceFiling::STATUS_LODGED_AT_REGISTRY,
                'changed_by_user_id' => $adminUser?->id,
                'remarks' => 'CAC Business Name registered and official Certificate issued under BN 3928172.',
            ]
        );

        // 2. Queried Trademark Device Mark
        $filing2 = ServiceFiling::firstOrCreate(
            ['tracking_code' => 'BANF-TM-2026-PULSE2'],
            [
                'user_id' => $memberUser?->id,
                'member_id' => $member?->id,
                'filing_type' => ServiceFiling::TYPE_TRADEMARK,
                'proposed_name_1' => 'BrandPulse Device Mark',
                'proposed_name_2' => 'PulseBrand Mark',
                'business_nature' => 'Statutory brand identity protection in Class 35 (Advertising, Brand Management) and Class 42 (Scientific and Technological Services).',
                'industry_category' => 'Brand Technology & Intellectual Property',
                'business_address' => 'Central Business District, Abuja, FCT',
                'headquarters_state' => 'Abuja (FCT)',
                'client_first_name' => 'Chioma',
                'client_last_name' => 'Adeyemi',
                'client_email' => 'chioma@brandpulse.ng',
                'client_phone' => '+234 802 334 4556',
                'client_nin' => '98271625341',
                'filing_data' => ['trademark_class' => 'Class 35, Class 42'],
                'status' => ServiceFiling::STATUS_QUERIED,
                'total_fee' => 63750.00,
                'member_discount' => 21250.00,
                'fee_paid' => 63750.00,
                'payment_gateway' => 'paystack',
                'payment_reference' => 'LEGAL-TM-PULSE',
                'government_filing_number' => 'NG/TM/2026/88219',
                'client_query_message' => 'The Trademark examiner requested a higher resolution vector device mark and clarification of goods in Class 35.',
                'submitted_at' => Carbon::now()->subDays(12),
            ]
        );

        FilingStatusLog::firstOrCreate(
            [
                'service_filing_id' => $filing2->id,
                'to_status' => ServiceFiling::STATUS_QUERIED,
            ],
            [
                'from_status' => ServiceFiling::STATUS_LODGED_AT_REGISTRY,
                'changed_by_user_id' => $adminUser?->id,
                'remarks' => 'IPO Commercial Law Dept query issued. Examiner requested high-res vector file.',
            ]
        );
    }
}
