<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            "title"             =>  "Managing Director",
            "grade_id"          =>  1,
            "approvalStages"    =>  null,
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "Executive Assistant",
            "grade_id"          =>  4,
            "approvalStages"    =>  null,
            "state"             =>  "Permanent",
        ]);

        //Finance Positions
        Position::create([
            "title"             =>  "Finance and Compliance Executive",
            "grade_id"          =>  3,
            "approvalStages"    =>  null,
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "Accounts and Stores Officer",
            "grade_id"          =>  4,
            "approvalStages"    =>  null,
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "Human Capital Specialist",
            "grade_id"          =>  3,
            "approvalStages"    =>  null,
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "Security Team",
            "grade_id"          =>  5,
            "approvalStages"    =>  null,
            "state"             =>  "Permanent",
        ]);

        //Projects related positions
        Position::create([
            "title"             =>  "Contracts Manager",
            "grade_id"          =>  2,
            "approvalStages"    =>  null,
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "Technical Specialist",
            "grade_id"          =>  3,
            "approvalStages"    =>  null,
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "Projects Specialist",
            "grade_id"          =>  3,
            "approvalStages"    =>  null,
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "Operations and Business Development Specialist",
            "grade_id"          =>  3,
            "approvalStages"    =>  null,
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "Drilling Supervisor",
            "grade_id"          =>  6,
            "approvalStages"    =>  json_encode([
                [
                    "stage"     =>  1,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ]
            ]),
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "Drilling Team",
            "grade_id"          =>  7,
            "approvalStages"    =>  json_encode([
                [
                    "stage"     =>  1,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ],
                [
                    "stage"     =>  2,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ],
            ]),
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "Drilling Team",
            "grade_id"          =>  8,
            "approvalStages"    =>  json_encode([
                [
                    "stage"     =>  1,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ],
                [
                    "stage"     =>  2,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ],
            ]),
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "I & P Site Supervisors",
            "grade_id"          =>  4,
            "approvalStages"    =>  json_encode([
                [
                    "stage"     =>  1,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ]
            ]),
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "Temporary Artisan",
            "grade_id"          =>  5,
            "approvalStages"    =>  json_encode([
                [
                    "stage"     =>  1,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ],
                [
                    "stage"     =>  2,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ],
            ]),
            "state"             =>  "Temporary",
        ]);

        Position::create([
            "title"             =>  "Projects Supervisors",
            "grade_id"          =>  4,
            "approvalStages"    =>  json_encode([
                [
                    "stage"     =>  1,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ],
            ]),
            "state"             =>  "Temporary",
        ]);

        Position::create([
            "title"             =>  "Project Site Teams",
            "grade_id"          =>  5,
            "approvalStages"    =>  json_encode([
                [
                    "stage"     =>  1,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ],
                [
                    "stage"     =>  2,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ],
            ]),
            "state"             =>  "Temporary",
        ]);

        Position::create([
            "title"             =>  "Workshop Supervisor",
            "grade_id"          =>  3,
            "approvalStages"    =>  json_encode([
                [
                    "stage"     =>  1,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ],
            ]),
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "Permanent Artisans",
            "grade_id"          =>  5,
            "approvalStages"    =>  json_encode([
                [
                    "stage"     =>  1,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ],
                [
                    "stage"     =>  2,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ],
            ]),
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "Drivers and Mechanics",
            "grade_id"          =>  5,
            "approvalStages"    =>  json_encode([
                [
                    "stage"     =>  1,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ],
            ]),
            "state"             =>  "Permanent",
        ]);

        Position::create([
            "title"             =>  "Procurement Officer",
            "grade_id"          =>  5,
            "approvalStages"    =>  json_encode([
                [
                    "stage"     =>  1,
                    "position"  =>  0,
                    "name"      =>  null,
                    "date"      =>  null,
                    "status"    =>  null
                ],
            ]),
            "state"             =>  "Permanent",
        ]);
    }
}
