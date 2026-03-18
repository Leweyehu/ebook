<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    public function run()
    {
        $staff = [
            [
                'name' => 'Abrham Belete',
                'position' => 'Lecturer',
                'qualification' => 'MSc in Computer Science',
                'phone' => '+251-911-123456',
                'email' => 'abrham.belete@mau.edu.et',
                'specialization' => 'Computer Science',
                'bio' => 'Lecturer in Computer Science with expertise in various computing domains.',
                'sort_order' => 1
            ],
            [
                'name' => 'Mebitu Kefale',
                'position' => 'Lecturer',
                'qualification' => 'MSc in Computer Science',
                'phone' => '+251-922-234567',
                'email' => 'mebitu.kefale@mau.edu.et',
                'specialization' => 'Computer Science',
                'bio' => 'Experienced lecturer in Computer Science.',
                'sort_order' => 2
            ],
            [
                'name' => 'Melese Alemante',
                'position' => 'Lecturer',
                'qualification' => 'MSc in Computer Science',
                'phone' => '+251-933-345678',
                'email' => 'melese.alemante@mau.edu.et',
                'specialization' => 'Computer Science',
                'bio' => 'Dedicated educator in computer science.',
                'sort_order' => 3
            ],
            [
                'name' => 'Leweyehu Yirsaw',
                'position' => 'Lecturer',
                'qualification' => 'MSc in Computer Science',
                'phone' => '+251-944-456789',
                'email' => 'leweyehu.yirsaw@mau.edu.et',
                'specialization' => 'Computer Science',
                'bio' => 'Computer Science lecturer committed to excellence in teaching.',
                'sort_order' => 4
            ],
            [
                'name' => 'Agegnehu Teshome',
                'position' => 'Lecturer',
                'qualification' => 'MSc in AI and Data Science',
                'phone' => '+251-955-567890',
                'email' => 'agegnehu.teshome@mau.edu.et',
                'specialization' => 'Artificial Intelligence and Data Science',
                'bio' => 'Specializes in AI and Data Science with focus on machine learning applications.',
                'sort_order' => 5
            ],
            [
                'name' => 'Misge Desta',
                'position' => 'Lecturer',
                'qualification' => 'MSc in AI and Data Science',
                'phone' => '+251-966-678901',
                'email' => 'misge.desta@mau.edu.et',
                'specialization' => 'Artificial Intelligence and Data Science',
                'bio' => 'Expert in AI and data science with research interests in deep learning.',
                'sort_order' => 6
            ],
            [
                'name' => 'Shimelis Kasa',
                'position' => 'Lecturer',
                'qualification' => 'MSc in Computer Science',
                'phone' => '+251-977-789012',
                'email' => 'shimelis.kasa@mau.edu.et',
                'specialization' => 'Computer Science',
                'bio' => 'Computer Science lecturer with passion for software development.',
                'sort_order' => 7
            ],
            [
                'name' => 'Tahayu Gizachew',
                'position' => 'Lecturer',
                'qualification' => 'MSc in Computer Engineering',
                'phone' => '+251-988-890123',
                'email' => 'tahayu.gizachew@mau.edu.et',
                'specialization' => 'Computer Engineering',
                'bio' => 'Lecturer in computer engineering with focus on hardware and embedded systems.',
                'sort_order' => 8
            ],
            [
                'name' => 'Fuad Seid',
                'position' => 'Lecturer',
                'qualification' => 'MSc in Computer Engineering',
                'phone' => '+251-999-901234',
                'email' => 'fuad.seid@mau.edu.et',
                'specialization' => 'Computer Engineering',
                'bio' => 'Computer engineering educator specializing in digital systems.',
                'sort_order' => 9
            ],
            [
                'name' => 'Ahmed Siraj',
                'position' => 'Assistant Lecturer',
                'qualification' => 'BSc in Computer Engineering',
                'phone' => '+251-910-012345',
                'email' => 'ahmed.siraj@mau.edu.et',
                'specialization' => 'Computer Engineering',
                'bio' => 'Assistant lecturer in computer engineering.',
                'sort_order' => 10
            ],
            [
                'name' => 'Temesgen Tiritie',
                'position' => 'Senior Technical Assistant',
                'qualification' => 'BSc in Computer Science',
                'phone' => '+251-911-123457',
                'email' => 'temesgen.tiritie@mau.edu.et',
                'specialization' => 'Computer Science',
                'bio' => 'Senior technical assistant supporting labs and technical operations.',
                'sort_order' => 11
            ],
            [
                'name' => 'Endris Yesuf',
                'position' => 'Senior Technical Assistant',
                'qualification' => 'BSc in Computer Science',
                'phone' => '+251-922-234568',
                'email' => 'endris.yesuf@mau.edu.et',
                'specialization' => 'Computer Science',
                'bio' => 'Senior technical assistant providing technical support for the department.',
                'sort_order' => 12
            ]
        ];

        foreach ($staff as $member) {
            Staff::create($member);
        }
    }
}