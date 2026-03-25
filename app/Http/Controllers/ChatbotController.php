<?php

namespace App\Http\Controllers;

use App\Models\ChatbotConversation;
use App\Models\Course;
use App\Models\Staff;
use App\Models\News;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    /**
     * Display chatbot interface
     */
    public function index()
    {
        return view('chatbot.index');
    }

    /**
     * Process user message and return response
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $userMessage = trim($request->message);
        $sessionId = $request->session()->getId();
        
        $response = $this->getBotResponse($userMessage);
        
        ChatbotConversation::create([
            'session_id' => $sessionId,
            'user_ip' => $request->ip(),
            'user_message' => $userMessage,
            'bot_response' => $response,
            'intent' => $this->detectIntent($userMessage)
        ]);
        
        return response()->json([
            'success' => true,
            'response' => $response
        ]);
    }
    
    private function getBotResponse($message)
    {
        $message = strtolower($message);
        $intent = $this->detectIntent($message);
        
        switch ($intent) {
            case 'greeting':
                return $this->getGreetingResponse();
            case 'benefits':
                return $this->getBenefitsInfo();
            case 'why_cs':
                return $this->getWhyCSInfo();
            case 'career_opportunities':
                return $this->getCareerOpportunitiesInfo();
            case 'future_prospects':
                return $this->getFutureProspectsInfo();
            case 'skills_learned':
                return $this->getSkillsLearnedInfo();
            case 'job_market':
                return $this->getJobMarketInfo();
            case 'salary':
                return $this->getSalaryInfo();
            case 'programs':
                return $this->getProgramsInfo();
            case 'courses':
                return $this->getCoursesInfo($message);
            case 'admission':
                return $this->getAdmissionInfo();
            case 'staff':
                return $this->getStaffInfo();
            case 'alumni':
                return $this->getAlumniInfo();
            case 'news':
                return $this->getNewsInfo();
            case 'contact':
                return $this->getContactInfo();
            case 'schedule':
                return $this->getScheduleInfo();
            case 'research':
                return $this->getResearchInfo();
            case 'internship':
                return $this->getInternshipInfo();
            case 'certification':
                return $this->getCertificationInfo();
            case 'comparison':
                return $this->getComparisonInfo();
            case 'study_tips':
                return $this->getStudyTipsInfo();
            case 'help':
                return $this->getHelpInfo();
            default:
                return $this->getDefaultResponse();
        }
    }
    
    private function detectIntent($message)
    {
        $intents = [
            'greeting' => ['hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening', 'greetings', 'howdy'],
            'benefits' => ['benefit', 'advantage', 'why choose', 'why study', 'value', 'importance', 'what makes'],
            'why_cs' => ['why computer science', 'why cs', 'why should i study', 'reasons to study', 'motivation'],
            'career_opportunities' => ['career', 'job', 'work', 'profession', 'opportunity', 'placement', 'employ'],
            'future_prospects' => ['future', 'prospect', 'trend', 'growing', 'demand', 'scope', 'opportunity'],
            'skills_learned' => ['skill', 'learn', 'what will i learn', 'knowledge', 'competency', 'ability'],
            'job_market' => ['market', 'industry', 'sector', 'demand', 'hiring', 'companies'],
            'salary' => ['salary', 'income', 'pay', 'earning', 'compensation', 'remuneration'],
            'programs' => ['program', 'degree', 'bachelor', 'master', 'bsc', 'msc', 'study', 'offer', 'available'],
            'courses' => ['course', 'class', 'subject', 'curriculum', 'syllabus', 'what courses'],
            'admission' => ['admission', 'apply', 'application', 'enroll', 'registration', 'join', 'how to join', 'requirements', 'entry', 'eligible'],
            'staff' => ['staff', 'faculty', 'teacher', 'professor', 'instructor', 'lecturer', 'who teaches'],
            'alumni' => ['alumni', 'graduate', 'success story', 'where are they now', 'graduate success'],
            'news' => ['news', 'event', 'announcement', 'happening', 'recent', 'upcoming'],
            'contact' => ['contact', 'email', 'phone', 'address', 'location', 'reach', 'call', 'office'],
            'schedule' => ['schedule', 'timetable', 'class time', 'academic calendar', 'semester', 'when'],
            'research' => ['research', 'project', 'lab', 'facility', 'equipment', 'innovation'],
            'internship' => ['internship', 'practical', 'training', 'work experience', 'attachment'],
            'certification' => ['certificate', 'certification', 'course', 'short course', 'training'],
            'comparison' => ['compare', 'vs', 'difference', 'which one', 'better'],
            'study_tips' => ['tip', 'advice', 'how to succeed', 'study', 'prepare', 'recommendation'],
            'help' => ['help', 'support', 'assist', 'guide', 'what can you do']
        ];
        
        foreach ($intents as $intent => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    return $intent;
                }
            }
        }
        
        return 'unknown';
    }
    
    private function getGreetingResponse()
    {
        $greetings = [
            "👋 Hello! Welcome to the Computer Science Department at Mekdela Amba University! I'm here to help you explore the exciting world of computer science. What would you like to know?",
            "Hi there! 😊 I'm your virtual assistant. Ask me about our programs, career opportunities, benefits of studying CS, or anything about our department!",
            "Greetings! 🎓 Ready to learn about computer science? I can tell you about our programs, career prospects, skills you'll gain, and why CS is a great choice for your future!",
            "Hello! 🤖 Welcome to the CS Department. Whether you're considering joining us or just exploring, I'm here to answer all your questions about computer science education!"
        ];
        return $greetings[array_rand($greetings)];
    }
    
    private function getBenefitsInfo()
    {
        return "🌟 **Why Choose Computer Science at Mekdela Amba University?**\n\n" .
               "**Top Benefits:**\n" .
               "1️⃣ **High Demand Career** - Computer Science graduates are among the most sought-after professionals globally\n" .
               "2️⃣ **Excellent Salary Potential** - CS careers offer competitive compensation packages\n" .
               "3️⃣ **Global Opportunities** - Work anywhere in the world, remote or on-site\n" .
               "4️⃣ **Innovation & Creativity** - Build solutions that change how people live and work\n" .
               "5️⃣ **Continuous Learning** - Technology evolves, keeping your career exciting and dynamic\n" .
               "6️⃣ **Problem-Solving Skills** - Develop critical thinking that applies to any field\n" .
               "7️⃣ **Entrepreneurship** - Many CS graduates start their own successful companies\n" .
               "8️⃣ **Job Security** - Technology is everywhere, creating stable career paths\n\n" .
               "At Mekdela Amba University, we combine theoretical knowledge with practical skills to prepare you for success!";
    }
    
    private function getWhyCSInfo()
    {
        return "💡 **Why Study Computer Science?**\n\n" .
               "**Here's why CS is an excellent choice:**\n\n" .
               "🎯 **Shape the Future** - CS professionals are at the forefront of technological innovation. You'll help create AI, apps, systems, and solutions that impact millions of lives.\n\n" .
               "🎯 **Endless Creativity** - Computer science is about creation. You can build anything from games to medical software, from social platforms to space exploration tools.\n\n" .
               "🎯 **High Impact** - Your work can solve real-world problems in healthcare, education, agriculture, finance, and more.\n\n" .
               "🎯 **Flexible Work Environment** - Work from anywhere, set your own hours, choose projects that interest you.\n\n" .
               "🎯 **Continuous Innovation** - Technology never stops evolving, so your career will always have new challenges and learning opportunities.\n\n" .
               "🎯 **Make Ethiopia Proud** - Be part of Ethiopia's digital transformation and contribute to your country's technological advancement.\n\n" .
               "🎯 **Skills for Life** - CS teaches you how to think logically, solve complex problems, and adapt to new situations - skills valuable in any career!\n\n" .
               "Ready to join the next generation of tech leaders? The Computer Science Department at Mekdela Amba University is your gateway to an exciting future!";
    }
    
    private function getCareerOpportunitiesInfo()
    {
        return "💼 **Career Opportunities for CS Graduates**\n\n" .
               "Our graduates work in diverse roles across industries:\n\n" .
               "**Top Job Roles:**\n" .
               "• Software Developer / Engineer\n" .
               "• Data Scientist / Analyst\n" .
               "• Artificial Intelligence / Machine Learning Engineer\n" .
               "• Cybersecurity Specialist\n" .
               "• Cloud Architect\n" .
               "• Systems Administrator\n" .
               "• Network Engineer\n" .
               "• Web Developer (Frontend/Backend/Full Stack)\n" .
               "• Mobile App Developer\n" .
               "• Database Administrator\n" .
               "• IT Consultant\n" .
               "• UX/UI Designer\n" .
               "• DevOps Engineer\n" .
               "• Quality Assurance Engineer\n\n" .
               "**Where Our Graduates Work:**\n" .
               "• Global Tech Giants (Google, Microsoft, Amazon)\n" .
               "• Ethiopian Banks and Financial Institutions\n" .
               "• Telecommunication Companies (Ethio Telecom, Safaricom)\n" .
               "• Government Ministries and Agencies\n" .
               "• International NGOs\n" .
               "• Startups and Tech Companies\n" .
               "• Academic and Research Institutions\n" .
               "• Self-Employment / Freelance / Entrepreneurship\n\n" .
               "**95% of our graduates find employment within 6 months of graduation!**";
    }
    
    private function getFutureProspectsInfo()
    {
        return "🚀 **Future Prospects in Computer Science**\n\n" .
               "**Exciting Future Trends:**\n\n" .
               "🤖 **Artificial Intelligence & Machine Learning** - AI is transforming every industry. Demand for AI specialists is growing exponentially.\n\n" .
               "🔒 **Cybersecurity** - With increasing digital threats, cybersecurity experts are more critical than ever.\n\n" .
               "☁️ **Cloud Computing** - Companies are moving to the cloud, creating huge demand for cloud architects and engineers.\n\n" .
               "📊 **Data Science & Big Data** - Organizations need experts to extract insights from massive datasets.\n\n" .
               "📱 **Mobile & Web Development** - The digital economy continues to expand, requiring skilled developers.\n\n" .
               "🏥 **HealthTech** - Technology is revolutionizing healthcare delivery in Ethiopia and globally.\n\n" .
               "🌾 **AgriTech** - Technology solutions for Ethiopian agriculture create exciting opportunities.\n\n" .
               "💰 **FinTech** - Digital payments, mobile money, and financial technology are booming in Ethiopia.\n\n" .
               "🌍 **Remote Work** - Ethiopian CS graduates can work for international companies without leaving home!\n\n" .
               "🎓 **Further Education** - Pursue M.Sc., Ph.D., or specialized certifications to advance your career.\n\n" .
               "**The future is digital, and computer science graduates will lead the way!**";
    }
    
    private function getSkillsLearnedInfo()
    {
        return "📚 **Skills You'll Gain in Our Program**\n\n" .
               "**Technical Skills:**\n" .
               "• Programming Languages (Python, Java, C++, JavaScript)\n" .
               "• Web Development (HTML, CSS, React, Node.js)\n" .
               "• Database Management (SQL, MongoDB)\n" .
               "• Data Structures & Algorithms\n" .
               "• Software Engineering Principles\n" .
               "• Operating Systems & Networks\n" .
               "• Cybersecurity Fundamentals\n" .
               "• Artificial Intelligence & Machine Learning\n" .
               "• Mobile App Development\n" .
               "• Cloud Computing (AWS, Azure)\n\n" .
               "**Soft Skills:**\n" .
               "• Problem-Solving & Critical Thinking\n" .
               "• Team Collaboration\n" .
               "• Project Management\n" .
               "• Communication & Presentation\n" .
               "• Analytical Thinking\n" .
               "• Adaptability & Continuous Learning\n" .
               "• Leadership Skills\n" .
               "• Research & Innovation\n\n" .
               "These skills are valuable not just in tech, but in any career path you choose!";
    }
    
    private function getJobMarketInfo()
    {
        return "📈 **Job Market for CS Graduates in Ethiopia**\n\n" .
               "**Current Market Situation:**\n\n" .
               "✅ **High Demand** - Tech companies, banks, telecom, and government agencies actively recruit CS graduates\n" .
               "✅ **Growing Industry** - Ethiopia's digital transformation is creating thousands of tech jobs\n" .
               "✅ **Competitive Salaries** - CS graduates earn above-average starting salaries\n" .
               "✅ **International Opportunities** - Work remotely for global companies\n" .
               "✅ **Startup Ecosystem** - Addis Ababa has a growing tech startup scene\n\n" .
               "**Key Employers in Ethiopia:**\n" .
               "• Ethio Telecom\n" .
               "• Safaricom Ethiopia\n" .
               "• Commercial Bank of Ethiopia\n" .
               "• Dashen Bank\n" .
               "• Ethiopian Airlines\n" .
               "• Ministry of Innovation and Technology\n" .
               "• Various tech startups and software companies\n" .
               "• International organizations (UN, WHO, etc.)\n\n" .
               "**95% employment rate within 6 months of graduation!**";
    }
    
    private function getSalaryInfo()
    {
        return "💰 **Salary Expectations for CS Graduates**\n\n" .
               "**Entry Level (0-2 years):**\n" .
               "• Junior Software Developer: 8,000 - 15,000 ETB/month\n" .
               "• IT Support: 6,000 - 10,000 ETB/month\n\n" .
               "**Mid Level (2-5 years):**\n" .
               "• Software Developer: 15,000 - 30,000 ETB/month\n" .
               "• Database Administrator: 12,000 - 25,000 ETB/month\n" .
               "• Network Engineer: 12,000 - 25,000 ETB/month\n\n" .
               "**Senior Level (5+ years):**\n" .
               "• Senior Developer: 30,000 - 60,000 ETB/month\n" .
               "• Team Lead: 40,000 - 80,000 ETB/month\n" .
               "• IT Manager: 50,000 - 100,000+ ETB/month\n\n" .
               "**International/Remote Work:**\n" .
               "• $1,000 - $5,000+ USD/month depending on experience and company\n\n" .
               "📌 *Salaries vary based on skills, experience, company, and location*";
    }
    
    private function getProgramsInfo()
    {
        return "🎓 **Our Academic Programs**\n\n" .
               "**Undergraduate Programs (4 years):**\n" .
               "• B.Sc. in Computer Science\n" .
               "• B.Sc. in Information Technology\n" .
               "• B.Sc. in Software Engineering\n\n" .
               "**Graduate Programs (2 years):**\n" .
               "• M.Sc. in Computer Science\n" .
               "• M.Sc. in Information Technology\n" .
               "• M.Sc. in Software Engineering\n\n" .
               "**Program Highlights:**\n" .
               "✓ Modern curriculum aligned with industry needs\n" .
               "✓ Hands-on practical training in our labs\n" .
               "✓ Internship opportunities with partner companies\n" .
               "✓ Capstone projects solving real-world problems\n" .
               "✓ Industry guest lectures and workshops\n\n" .
               "Would you like more details about a specific program?";
    }
    
    private function getCoursesInfo($message)
    {
        if (strpos($message, 'year 1') !== false || strpos($message, 'first year') !== false) {
            return "📚 **First Year Courses:**\n\n" .
                   "**Semester 1:**\n" .
                   "• Introduction to Computing\n" .
                   "• Programming Fundamentals I (Python)\n" .
                   "• Discrete Mathematics\n" .
                   "• English Communication Skills I\n" .
                   "• General Psychology\n\n" .
                   "**Semester 2:**\n" .
                   "• Object-Oriented Programming (Java)\n" .
                   "• Data Structures and Algorithms\n" .
                   "• Digital Logic Design\n" .
                   "• English Communication Skills II\n" .
                   "• Introduction to Databases";
        } elseif (strpos($message, 'year 2') !== false || strpos($message, 'second year') !== false) {
            return "📚 **Second Year Courses:**\n\n" .
                   "**Semester 1:**\n" .
                   "• Database Management Systems\n" .
                   "• Operating Systems\n" .
                   "• Computer Networks\n" .
                   "• Web Development (HTML, CSS, JavaScript)\n" .
                   "• Probability and Statistics\n\n" .
                   "**Semester 2:**\n" .
                   "• Software Engineering Principles\n" .
                   "• System Analysis and Design\n" .
                   "• Advanced Programming\n" .
                   "• Computer Architecture\n" .
                   "• Linear Algebra";
        } elseif (strpos($message, 'year 3') !== false || strpos($message, 'third year') !== false) {
            return "📚 **Third Year Courses:**\n\n" .
                   "**Semester 1:**\n" .
                   "• Artificial Intelligence\n" .
                   "• Algorithms Analysis and Design\n" .
                   "• Mobile Application Development\n" .
                   "• Network Security\n" .
                   "• Elective I\n\n" .
                   "**Semester 2:**\n" .
                   "• Machine Learning\n" .
                   "• Distributed Systems\n" .
                   "• Cloud Computing\n" .
                   "• Research Methods\n" .
                   "• Elective II";
        } elseif (strpos($message, 'year 4') !== false || strpos($message, 'fourth year') !== false) {
            return "📚 **Fourth Year Courses:**\n\n" .
                   "**Semester 1:**\n" .
                   "• Data Science and Big Data Analytics\n" .
                   "• Cybersecurity\n" .
                   "• Entrepreneurship\n" .
                   "• Elective III\n" .
                   "• Capstone Project I\n\n" .
                   "**Semester 2:**\n" .
                   "• Professional Ethics\n" .
                   "• Advanced Topics in CS\n" .
                   "• Elective IV\n" .
                   "• Capstone Project II (Final Year Project)\n" .
                   "• Internship/Industrial Attachment";
        } elseif (strpos($message, 'elective') !== false) {
            return "🎯 **Elective Courses (Choose from):**\n\n" .
                   "• Machine Learning\n" .
                   "• Deep Learning\n" .
                   "• Natural Language Processing\n" .
                   "• Computer Vision\n" .
                   "• Advanced Cybersecurity\n" .
                   "• Blockchain Technology\n" .
                   "• Internet of Things (IoT)\n" .
                   "• Game Development\n" .
                   "• Advanced Web Development\n" .
                   "• DevOps and Cloud Computing\n" .
                   "• Big Data Analytics\n" .
                   "• Bioinformatics\n" .
                   "• Robotics\n\n" .
                   "Electives are offered from Year 3 onward.";
        } else {
            return "📖 **Our Curriculum Structure:**\n\n" .
                   "**Core Areas:**\n" .
                   "• Programming & Software Development\n" .
                   "• Data Structures & Algorithms\n" .
                   "• Database Systems\n" .
                   "• Computer Networks\n" .
                   "• Operating Systems\n" .
                   "• Software Engineering\n\n" .
                   "**Advanced Areas:**\n" .
                   "• Artificial Intelligence & Machine Learning\n" .
                   "• Cybersecurity\n" .
                   "• Cloud Computing\n" .
                   "• Data Science\n" .
                   "• Mobile & Web Development\n\n" .
                   "**Want to know about a specific year?** Ask about 'Year 1', 'Year 2', 'Year 3', 'Year 4', or 'Electives'!";
        }
    }
    
    private function getAdmissionInfo()
    {
        return "📝 **Admission Requirements**\n\n" .
               "**For Undergraduate Programs:**\n" .
               "• Ethiopian University Entrance Examination (EUEE) with minimum 50%\n" .
               "• Strong background in Mathematics\n" .
               "• English proficiency\n" .
               "• Completed application form\n\n" .
               "**For Graduate Programs:**\n" .
               "• Bachelor's degree in Computer Science or related field\n" .
               "• Minimum GPA of 2.75\n" .
               "• Pass entrance exam and interview\n" .
               "• Statement of purpose\n" .
               "• Two letters of recommendation\n\n" .
               "**Application Deadlines:**\n" .
               "• Fall Semester: July 30th\n" .
               "• Spring Semester: December 15th\n\n" .
               "**Ready to apply?** Visit our admissions office or contact us for assistance!";
    }
    
    private function getStaffInfo()
    {
        $staffCount = Staff::where('is_active', true)->count();
        $academicStaff = Staff::where('is_active', true)->where('staff_type', 'academic')->count();
        
        return "👨‍🏫 **Our Faculty & Staff**\n\n" .
               "We have **{$staffCount} dedicated staff members** including:\n" .
               "• {$academicStaff} academic faculty members\n" .
               "• PhD holders from international universities\n" .
               "• Industry-experienced instructors\n" .
               "• Research experts in AI, Cybersecurity, Data Science, and more\n\n" .
               "**Our faculty expertise includes:**\n" .
               "• Artificial Intelligence & Machine Learning\n" .
               "• Cybersecurity & Cryptography\n" .
               "• Data Science & Big Data Analytics\n" .
               "• Software Engineering\n" .
               "• Network Systems & Cloud Computing\n" .
               "• Mobile & Web Development\n\n" .
               "Our instructors are committed to your success and provide personalized mentorship throughout your studies!";
    }
    
    private function getAlumniInfo()
    {
        $alumniCount = Alumni::where('status', 'approved')->count();
        
        return "🌟 **Alumni Success Stories**\n\n" .
               "Our alumni community has **{$alumniCount}+ successful graduates** making an impact worldwide!\n\n" .
               "**Where They Work:**\n" .
               "• Google, Microsoft, Amazon (International)\n" .
               "• Ethio Telecom, Safaricom Ethiopia\n" .
               "• Commercial Bank of Ethiopia, Dashen Bank\n" .
               "• Ethiopian Airlines\n" .
               "• Leading tech startups in Addis Ababa\n" .
               "• International organizations (UN, WHO)\n" .
               "• Universities and research institutions\n\n" .
               "**Notable Achievements:**\n" .
               "• 95% employment rate within 6 months\n" .
               "• 15+ research publications annually\n" .
               "• Multiple national hackathon winners\n" .
               "• Successful tech entrepreneurs\n\n" .
               "**Want to join our alumni network?** [Register here](/alumni/register)!";
    }
    
    private function getNewsInfo()
    {
        $recentNews = News::where('is_published', true)->latest()->take(3)->get();
        
        $response = "📰 **Latest News & Events**\n\n";
        
        if ($recentNews->count() > 0) {
            foreach ($recentNews as $news) {
                $response .= "• **" . $news->title . "**\n";
                if ($news->created_at) {
                    $response .= "  " . $news->created_at->format('M d, Y') . "\n";
                }
                $response .= "\n";
            }
            $response .= "Visit our [News Page](/news) for more updates!";
        } else {
            $response .= "No recent news available. Check back soon!\n\n" .
                         "Subscribe to our newsletter to stay updated!";
        }
        
        return $response;
    }
    
    private function getContactInfo()
    {
        return "📞 **Contact Information**\n\n" .
               "**Department of Computer Science**\n" .
               "Mekdela Amba University\n" .
               "South Wollo, Ethiopia\n\n" .
               "📧 **Email:** cs@mau.edu.et\n" .
               "📞 **Phone:** +251-988-322-475\n" .
               "🕐 **Office Hours:** Monday-Friday 8:00 AM - 5:00 PM\n" .
               "📍 **Location:** Main Campus, Science Building, 3rd Floor\n\n" .
               "**You can also:**\n" .
               "• Visit our [Contact Form](/contact) for inquiries\n" .
               "• Follow us on social media for updates\n" .
               "• Visit our department office for in-person assistance\n\n" .
               "We're here to help!";
    }
    
    private function getScheduleInfo()
    {
        return "📅 **Academic Calendar 2024-2025**\n\n" .
               "**Fall Semester:**\n" .
               "• Registration: August 15 - September 10\n" .
               "• Classes Start: September 15\n" .
               "• Mid-term Exams: November 10-20\n" .
               "• Final Exams: January 15-30\n\n" .
               "**Spring Semester:**\n" .
               "• Registration: February 1-15\n" .
               "• Classes Start: February 20\n" .
               "• Mid-term Exams: April 10-20\n" .
               "• Final Exams: June 10-25\n\n" .
               "**Class Hours:** Monday - Friday, 8:00 AM - 5:00 PM\n\n" .
               "**Breaks:**\n" .
               "• Winter Break: January 31 - February 15\n" .
               "• Summer Break: June 26 - August 14";
    }
    
    private function getResearchInfo()
    {
        return "🔬 **Research & Innovation**\n\n" .
               "**Research Areas:**\n" .
               "• Artificial Intelligence & Machine Learning\n" .
               "• Natural Language Processing (Amharic & Ethiopian languages)\n" .
               "• Cybersecurity & Cryptography\n" .
               "• Data Science & Big Data Analytics\n" .
               "• Software Engineering\n" .
               "• Internet of Things (IoT)\n" .
               "• Blockchain Technology\n" .
               "• Health Informatics\n" .
               "• Agricultural Technology (AgriTech)\n\n" .
               "**Facilities:**\n" .
               "• 4 Modern Computer Labs (200+ workstations)\n" .
               "• High-Performance Computing Cluster\n" .
               "• 24/7 Lab Access\n" .
               "• Cloud Computing Resources (AWS, Azure)\n" .
               "• High-Speed Internet (1 Gbps)\n" .
               "• Research Collaboration Spaces\n\n" .
               "**Research Opportunities:**\n" .
               "• Undergraduate research projects\n" .
               "• Graduate thesis research\n" .
               "• Faculty-led research groups\n" .
               "• Industry-sponsored projects\n" .
               "• National and international collaborations\n\n" .
               "Our research addresses real-world challenges in Ethiopia and beyond!";
    }
    
    private function getInternshipInfo()
    {
        return "💼 **Internship & Practical Training**\n\n" .
               "**Internship Program:**\n" .
               "• 3-month industrial attachment in Year 4\n" .
               "• Work with real companies and organizations\n" .
               "• Gain hands-on experience before graduation\n\n" .
               "**Partner Organizations:**\n" .
               "• Ethio Telecom\n" .
               "• Safaricom Ethiopia\n" .
               "• Commercial Bank of Ethiopia\n" .
               "• Dashen Bank\n" .
               "• Information Network Security Agency (INSA)\n" .
               "• Various tech startups and software companies\n" .
               "• Government ministries\n" .
               "• International NGOs\n\n" .
               "**Benefits:**\n" .
               "• Practical experience for your resume\n" .
               "• Professional networking opportunities\n" .
               "• Potential job offers before graduation\n" .
               "• Industry mentorship\n\n" .
               "95% of our students secure internships, and many receive job offers from their internship companies!";
    }
    
    private function getCertificationInfo()
    {
        return "🎓 **Certification Opportunities**\n\n" .
               "**While studying, you can earn valuable certifications:**\n\n" .
               "**Technical Certifications:**\n" .
               "• AWS Certified Cloud Practitioner\n" .
               "• Microsoft Azure Fundamentals\n" .
               "• Cisco CCNA\n" .
               "• CompTIA Security+\n" .
               "• Python Institute Certifications\n" .
               "• Oracle Java Certifications\n\n" .
               "**Soft Skills Certifications:**\n" .
               "• Project Management (PMP)\n" .
               "• Agile/Scrum Master\n" .
               "• IT Service Management (ITIL)\n\n" .
               "**How We Support You:**\n" .
               "• Exam fee discounts for students\n" .
               "• Preparation workshops\n" .
               "• Study groups and materials\n" .
               "• Industry partnerships\n\n" .
               "These certifications boost your employability and earning potential!";
    }
    
    private function getComparisonInfo()
    {
        return "🔄 **CS vs Other Programs**\n\n" .
               "**Computer Science** vs **Information Technology:**\n" .
               "• CS focuses on algorithms, programming, and theory\n" .
               "• IT focuses on systems, networks, and applications\n\n" .
               "**Computer Science** vs **Software Engineering:**\n" .
               "• CS covers broader computing concepts and theory\n" .
               "• SE focuses more on development processes and lifecycle\n\n" .
               "**Why Choose CS at Mekdela Amba University:**\n" .
               "✓ Strong theoretical foundation\n" .
               "✓ Hands-on practical experience\n" .
               "✓ Industry-aligned curriculum\n" .
               "✓ Research opportunities\n" .
               "✓ Excellent career prospects\n\n" .
               "All three programs lead to great careers! Choose based on your interests.";
    }
    
    private function getStudyTipsInfo()
    {
        return "📖 **Tips for Success in Computer Science**\n\n" .
               "**For Current and Prospective Students:**\n\n" .
               "1️⃣ **Code Daily** - Practice programming every day, even for 30 minutes\n" .
               "2️⃣ **Build Projects** - Create your own projects to apply what you learn\n" .
               "3️⃣ **Join Communities** - Connect with fellow students, join coding clubs\n" .
               "4️⃣ **Participate in Competitions** - Join hackathons and coding competitions\n" .
               "5️⃣ **Use Online Resources** - YouTube, Coursera, and coding platforms\n" .
               "6️⃣ **Master Fundamentals** - Strong foundation in math and algorithms is key\n" .
               "7️⃣ **Collaborate** - Work with classmates, learn from each other\n" .
               "8️⃣ **Stay Updated** - Follow tech news and emerging technologies\n" .
               "9️⃣ **Ask Questions** - Don't hesitate to ask professors and peers for help\n" .
               "🔟 **Balance** - Take care of your health, exercise, and rest\n\n" .
               "**Remember:** Everyone starts as a beginner. With consistent effort, you'll succeed!";
    }
    
    private function getHelpInfo()
    {
        return "🤖 **What I Can Help You With**\n\n" .
               "You can ask me about:\n\n" .
               "• 📚 **Benefits of CS** - Why study computer science?\n" .
               "• 💼 **Career Opportunities** - Jobs and career paths\n" .
               "• 🚀 **Future Prospects** - Emerging technologies and trends\n" .
               "• 📖 **Skills You'll Learn** - What you'll gain from our program\n" .
               "• 💰 **Salary Expectations** - Earning potential\n" .
               "• 🎓 **Programs** - Our degrees and specializations\n" .
               "• 📝 **Admission** - How to join us\n" .
               "• 👨‍🏫 **Staff** - Our faculty members\n" .
               "• 🌟 **Alumni** - Success stories\n" .
               "• 💼 **Internship** - Practical training opportunities\n" .
               "• 🎓 **Certification** - Additional credentials you can earn\n" .
               "• 📅 **Schedule** - Academic calendar\n" .
               "• 🔬 **Research** - Labs and research areas\n" .
               "• 📖 **Study Tips** - How to succeed in CS\n\n" .
               "Just type your question and I'll do my best to help! 😊";
    }
    
    private function getDefaultResponse()
    {
        $responses = [
            "I'm here to help! 😊 You can ask me about the benefits of studying CS, career opportunities, future prospects, skills you'll learn, or our programs. What would you like to know?",
            "Great question! I can tell you about our programs, career opportunities, why choose CS, what skills you'll gain, and much more. What specific information are you looking for?",
            "Let me help you explore computer science! Ask me about: benefits of CS, career paths, future trends, admission requirements, or our programs. What interests you?",
            "I'd love to help! 😊 Try asking: 'Why study CS?', 'Career opportunities', 'What will I learn?', 'Benefits of computer science', or 'Future prospects'. What would you like to know?"
        ];
        return $responses[array_rand($responses)];
    }
}