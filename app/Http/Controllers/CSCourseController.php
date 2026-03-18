<?php

namespace App\Http\Controllers;

use App\Models\CSCourse;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CSCourseController extends Controller
{
    public function index()
    {
        $courses = CSCourse::where('is_active', true)
                          ->orderBy('year')
                          ->orderBy('semester')
                          ->orderBy('sort_order')
                          ->get()
                          ->groupBy(['year', 'semester']);

        // Calculate totals by category
        $totals = [
            'compulsory' => [
                'credit_hours' => CSCourse::where('category', 'compulsory')->sum('credit_hours'),
                'ects' => CSCourse::where('category', 'compulsory')->sum('ects')
            ],
            'elective' => [
                'credit_hours' => CSCourse::where('category', 'elective')->sum('credit_hours'),
                'ects' => CSCourse::where('category', 'elective')->sum('ects')
            ],
            'supportive' => [
                'credit_hours' => CSCourse::where('category', 'supportive')->sum('credit_hours'),
                'ects' => CSCourse::where('category', 'supportive')->sum('ects')
            ],
            'common' => [
                'credit_hours' => CSCourse::where('category', 'common')->sum('credit_hours'),
                'ects' => CSCourse::where('category', 'common')->sum('ects')
            ]
        ];

        $totals['all'] = [
            'credit_hours' => array_sum(array_column($totals, 'credit_hours')),
            'ects' => array_sum(array_column($totals, 'ects'))
        ];

        return view('cs-courses', compact('courses', 'totals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => 'required|unique:cs_courses',
            'course_title' => 'required',
            'ects' => 'required|integer',
            'credit_hours' => 'required|numeric',
            'lecture_hours' => 'nullable|integer',
            'lab_hours' => 'nullable|integer',
            'tutorial_hours' => 'nullable|integer',
            'category' => 'required|in:compulsory,elective,supportive,common',
            'year' => 'required|integer|between:1,4',
            'semester' => 'required|integer|between:1,2',
            'description' => 'nullable',
            'instructor' => 'nullable'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cs-courses/images', 'public');
            $validated['image_path'] = $imagePath;
        }

        // Handle syllabus upload
        if ($request->hasFile('syllabus')) {
            $syllabusPath = $request->file('syllabus')->store('cs-courses/syllabi', 'public');
            $validated['syllabus_path'] = $syllabusPath;
        }

        CSCourse::create($validated);

        return redirect()->route('cs-courses')
                        ->with('success', 'Course added successfully!');
    }

    public function uploadMaterials(Request $request, CSCourse $course)
    {
        $request->validate([
            'materials.*' => 'required|file|max:10240', // Max 10MB
            'material_titles.*' => 'required|string',
            'material_types.*' => 'required|in:syllabus,lecture_note,lab_manual,assignment,reference,image,other'
        ]);

        if ($request->hasFile('materials')) {
            foreach ($request->file('materials') as $index => $file) {
                $path = $file->store('cs-courses/materials/' . $course->id, 'public');
                
                CourseMaterial::create([
                    'cs_course_id' => $course->id,
                    'title' => $request->material_titles[$index],
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                    'material_type' => $request->material_types[$index]
                ]);
            }
        }

        return redirect()->route('cs-courses')
                        ->with('success', 'Materials uploaded successfully!');
    }

    public function destroy(CSCourse $course)
    {
        // Delete associated files
        if ($course->image_path) {
            Storage::disk('public')->delete($course->image_path);
        }
        if ($course->syllabus_path) {
            Storage::disk('public')->delete($course->syllabus_path);
        }

        // Delete materials
        foreach ($course->materials as $material) {
            Storage::disk('public')->delete($material->file_path);
            $material->delete();
        }

        $course->delete();

        return redirect()->route('cs-courses')
                        ->with('success', 'Course deleted successfully!');
    }

    public function seedCurriculum()
    {
        // This method will populate the database with the curriculum data
        $courses = $this->getCurriculumData();
        
        foreach ($courses as $course) {
            CSCourse::updateOrCreate(
                ['course_code' => $course['course_code']],
                $course
            );
        }

        return redirect()->route('cs-courses')
                        ->with('success', 'Curriculum loaded successfully!');
    }

    private function getCurriculumData()
    {
        return [
            // Year 1 Semester 1
            [
                'course_code' => 'Math1011',
                'course_title' => 'Mathematics for Natural Science',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 2,
                'category' => 'supportive',
                'year' => 1,
                'semester' => 1
            ],
            [
                'course_code' => 'FLEn1011',
                'course_title' => 'Communicative English Language Skills I',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'common',
                'year' => 1,
                'semester' => 1
            ],
            [
                'course_code' => 'Phys1011',
                'course_title' => 'General Physics',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 1,
                'tutorial_hours' => 2,
                'category' => 'supportive',
                'year' => 1,
                'semester' => 1
            ],
            [
                'course_code' => 'Psct1011',
                'course_title' => 'General Psychology',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'common',
                'year' => 1,
                'semester' => 1
            ],
            [
                'course_code' => 'LoCT1011',
                'course_title' => 'Critical Thinking',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'common',
                'year' => 1,
                'semester' => 1
            ],
            [
                'course_code' => 'SpSc1011',
                'course_title' => 'Physical Fitness',
                'ects' => 0,
                'credit_hours' => 0,
                'lecture_hours' => 2,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'common',
                'year' => 1,
                'semester' => 1
            ],
            [
                'course_code' => 'GeES1011',
                'course_title' => 'Geography of Ethiopia and the Horn',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'common',
                'year' => 1,
                'semester' => 1
            ],

            // Year 1 Semester 2
            [
                'course_code' => 'FLEn1012',
                'course_title' => 'Communicative English Language Skills II',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'common',
                'year' => 1,
                'semester' => 2
            ],
            [
                'course_code' => 'Anth1012',
                'course_title' => 'Social Anthropology',
                'ects' => 3,
                'credit_hours' => 2,
                'lecture_hours' => 2,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'common',
                'year' => 1,
                'semester' => 2
            ],
            [
                'course_code' => 'Math1041',
                'course_title' => 'Applied Mathematics I',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'supportive',
                'year' => 1,
                'semester' => 2
            ],
            [
                'course_code' => 'Econ-1011',
                'course_title' => 'Economics',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'common',
                'year' => 1,
                'semester' => 2
            ],
            [
                'course_code' => 'EmTe1012',
                'course_title' => 'Introduction to Emerging Technologies',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'compulsory',
                'year' => 1,
                'semester' => 2
            ],
            [
                'course_code' => 'MCiE1012',
                'course_title' => 'Moral and Civic Education',
                'ects' => 3,
                'credit_hours' => 2,
                'lecture_hours' => 2,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'common',
                'year' => 1,
                'semester' => 2
            ],
            [
                'course_code' => 'Chem1012',
                'course_title' => 'General Chemistry',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 1,
                'tutorial_hours' => 0,
                'category' => 'supportive',
                'year' => 1,
                'semester' => 2
            ],

            // Year 2 Semester 1
            [
                'course_code' => 'EENG2041',
                'course_title' => 'Digital Logic Design',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 0,
                'category' => 'supportive',
                'year' => 2,
                'semester' => 1
            ],
            [
                'course_code' => 'CoSc2051',
                'course_title' => 'Object Oriented Programming',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 2,
                'category' => 'compulsory',
                'year' => 2,
                'semester' => 1
            ],
            [
                'course_code' => 'MATH2011',
                'course_title' => 'Linear Algebra',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 1,
                'category' => 'supportive',
                'year' => 2,
                'semester' => 1
            ],
            [
                'course_code' => 'CoSc2041',
                'course_title' => 'Fundamentals of Database Systems',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 2,
                'category' => 'compulsory',
                'year' => 2,
                'semester' => 1
            ],
            [
                'course_code' => 'CoSc1012',
                'course_title' => 'Computer Programming',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 1,
                'category' => 'compulsory',
                'year' => 2,
                'semester' => 1
            ],
            [
                'course_code' => 'STAT2015',
                'course_title' => 'Probability and Statistics',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 1,
                'category' => 'supportive',
                'year' => 2,
                'semester' => 1
            ],
            [
                'course_code' => 'SINE2011',
                'course_title' => 'Inclusiveness',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'common',
                'year' => 2,
                'semester' => 1
            ],

            // Year 2 Semester 2
            [
                'course_code' => 'CoSc2032',
                'course_title' => 'Data Communication and Computer Networks',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 2,
                'category' => 'compulsory',
                'year' => 2,
                'semester' => 2
            ],
            [
                'course_code' => 'CoSc2042',
                'course_title' => 'Advanced Database Systems',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 2,
                'category' => 'compulsory',
                'year' => 2,
                'semester' => 2
            ],
            [
                'course_code' => 'MATH2082',
                'course_title' => 'Numerical Analysis',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 0,
                'category' => 'supportive',
                'year' => 2,
                'semester' => 2
            ],
            [
                'course_code' => 'MATH2052',
                'course_title' => 'Discrete Mathematics and Combinatorics',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'supportive',
                'year' => 2,
                'semester' => 2
            ],
            [
                'course_code' => 'CoSc2092',
                'course_title' => 'Data Structures and Algorithms',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 2,
                'category' => 'compulsory',
                'year' => 2,
                'semester' => 2
            ],
            [
                'course_code' => 'CoSc2022',
                'course_title' => 'Computer Organization and Architecture',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 1,
                'category' => 'compulsory',
                'year' => 2,
                'semester' => 2
            ],

            // Year 3 Semester 1
            [
                'course_code' => 'CoSc3023',
                'course_title' => 'Operating Systems',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 2,
                'category' => 'compulsory',
                'year' => 3,
                'semester' => 1
            ],
            [
                'course_code' => 'CoSc3081',
                'course_title' => 'Web Programming',
                'ects' => 7,
                'credit_hours' => 4,
                'lecture_hours' => 3,
                'lab_hours' => 3,
                'tutorial_hours' => 1,
                'category' => 'compulsory',
                'year' => 3,
                'semester' => 1
            ],
            [
                'course_code' => 'CoSc3053',
                'course_title' => 'Java Programming',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 2,
                'category' => 'compulsory',
                'year' => 3,
                'semester' => 1
            ],
            [
                'course_code' => 'CoSc3061',
                'course_title' => 'Software Engineering',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 2,
                'category' => 'compulsory',
                'year' => 3,
                'semester' => 1
            ],
            [
                'course_code' => 'CoSc3101',
                'course_title' => 'Automata and Complexity Theory',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 2,
                'category' => 'compulsory',
                'year' => 3,
                'semester' => 1
            ],
            [
                'course_code' => 'CoSc3025',
                'course_title' => 'Microprocessor and Assembly Language Programming',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 1,
                'category' => 'compulsory',
                'year' => 3,
                'semester' => 1
            ],
            [
                'course_code' => 'IRGI3021',
                'course_title' => 'Global Trends',
                'ects' => 4,
                'credit_hours' => 2,
                'lecture_hours' => 2,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'common',
                'year' => 3,
                'semester' => 1
            ],

            // Year 3 Semester 2
            [
                'course_code' => 'CoSc3034',
                'course_title' => 'Wireless Communication and Mobile Computing',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 1,
                'category' => 'compulsory',
                'year' => 3,
                'semester' => 2
            ],
            [
                'course_code' => 'CoSc3112',
                'course_title' => 'Introduction to Artificial Intelligence',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 2,
                'category' => 'compulsory',
                'year' => 3,
                'semester' => 2
            ],
            [
                'course_code' => 'CoSc3094',
                'course_title' => 'Design and Analysis of Algorithms',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'compulsory',
                'year' => 3,
                'semester' => 2
            ],
            [
                'course_code' => 'CoSc3026',
                'course_title' => 'Real Time and Embedded Systems',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 2,
                'category' => 'compulsory',
                'year' => 3,
                'semester' => 2
            ],
            [
                'course_code' => 'CoSc3072',
                'course_title' => 'Computer Graphics',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 1,
                'category' => 'compulsory',
                'year' => 3,
                'semester' => 2
            ],
            [
                'course_code' => 'CoSc3122',
                'course_title' => 'Industrial Practice',
                'ects' => 3,
                'credit_hours' => 2,
                'lecture_hours' => 0,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'compulsory',
                'year' => 3,
                'semester' => 2
            ],
            [
                'course_code' => 'MGMT4102',
                'course_title' => 'Entrepreneurship & Business Development',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'common',
                'year' => 3,
                'semester' => 2
            ],

            // Year 4 Semester 1
            [
                'course_code' => 'CoSc4035',
                'course_title' => 'Computer Security',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 1,
                'category' => 'compulsory',
                'year' => 4,
                'semester' => 1
            ],
            [
                'course_code' => 'CoSc4113',
                'course_title' => 'Computer Vision and Image Processing',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 2,
                'category' => 'compulsory',
                'year' => 4,
                'semester' => 1
            ],
            [
                'course_code' => 'CoSc4123',
                'course_title' => 'Research Methods in Computer Science',
                'ects' => 3,
                'credit_hours' => 2,
                'lecture_hours' => 2,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'compulsory',
                'year' => 4,
                'semester' => 1
            ],
            [
                'course_code' => 'CoSc4103',
                'course_title' => 'Compiler Design',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 2,
                'category' => 'compulsory',
                'year' => 4,
                'semester' => 1
            ],
            [
                'course_code' => 'CoSc4125',
                'course_title' => 'Final Year Project I',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 0,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'compulsory',
                'year' => 4,
                'semester' => 1
            ],

            // Year 4 Semester 2
            [
                'course_code' => 'CoSc4036',
                'course_title' => 'Network and System Administration',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 1,
                'category' => 'compulsory',
                'year' => 4,
                'semester' => 2
            ],
            [
                'course_code' => 'CoSc4038',
                'course_title' => 'Introduction to Distributed Systems',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 2,
                'lab_hours' => 3,
                'tutorial_hours' => 2,
                'category' => 'compulsory',
                'year' => 4,
                'semester' => 2
            ],
            [
                'course_code' => 'CoSc4132',
                'course_title' => 'Selected Topics in Computer Science',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 3,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'compulsory',
                'year' => 4,
                'semester' => 2
            ],
            [
                'course_code' => 'CoSc4126',
                'course_title' => 'Final Year Project II',
                'ects' => 5,
                'credit_hours' => 3,
                'lecture_hours' => 0,
                'lab_hours' => 0,
                'tutorial_hours' => 0,
                'category' => 'compulsory',
                'year' => 4,
                'semester' => 2
            ]
        ];
    }
}