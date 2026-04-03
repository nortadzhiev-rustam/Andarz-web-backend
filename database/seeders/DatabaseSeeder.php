<?php
namespace Database\Seeders;
use App\Models\BlogPost;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\CourseModule;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        // ── Users ──────────────────────────────────────────────────────────────
        User::factory()->create(['name'=>'Admin','email'=>'admin@andarz.test','password'=>Hash::make('password'),'role'=>'admin']);
        User::factory()->create(['name'=>'Demo Student','email'=>'student@andarz.test','password'=>Hash::make('password'),'role'=>'student']);

        // ── Instructors ────────────────────────────────────────────────────────
        $instructors = [
            ['name'=>'Sarah Johnson','avatar'=>'','bio'=>'Full-stack developer with 10+ years of experience in web technologies.'],
            ['name'=>'David Kim','avatar'=>'','bio'=>'React specialist and open-source contributor with a passion for teaching.'],
            ['name'=>'Priya Patel','avatar'=>'','bio'=>'Data scientist with expertise in Python, machine learning, and deep learning.'],
            ['name'=>'Maria Gonzalez','avatar'=>'','bio'=>'Senior UX designer with a passion for creating beautiful, user-friendly interfaces.'],
        ];
        $instructorModels = collect($instructors)->map(fn($i) => Instructor::create($i));

        // ── Courses ────────────────────────────────────────────────────────────
        $courseData = [
            [
                'title'=>'Introduction to Web Development','slug'=>'intro-web-development',
                'description'=>'Learn the fundamentals of web development including HTML, CSS, and JavaScript. This comprehensive course covers everything you need to get started building websites from scratch.',
                'short_description'=>'Master HTML, CSS, and JavaScript to build modern websites.',
                'price'=>49.99,'discount_price'=>29.99,'level'=>'beginner','category'=>'Web Development',
                'tags'=>['HTML','CSS','JavaScript','Frontend'],
                'instructor_id'=>$instructorModels[0]->id,'duration'=>'12 hours',
                'students_count'=>4820,'rating'=>4.8,'reviews_count'=>312,'language'=>'English',
                'last_updated'=>'2024-03-01','is_published'=>true,'is_featured'=>true,
                'modules'=>[
                    ['title'=>'Getting Started with HTML','lessons'=>[['title'=>'What is HTML?','duration'=>'10:00','is_free'=>true],['title'=>'HTML Document Structure','duration'=>'15:00','is_free'=>true],['title'=>'HTML Tags and Attributes','duration'=>'20:00','is_free'=>false]]],
                    ['title'=>'Styling with CSS','lessons'=>[['title'=>'Introduction to CSS','duration'=>'12:00','is_free'=>false],['title'=>'CSS Selectors','duration'=>'18:00','is_free'=>false],['title'=>'Flexbox and Grid','duration'=>'25:00','is_free'=>false]]],
                ],
            ],
            [
                'title'=>'React.js for Beginners','slug'=>'react-js-beginners',
                'description'=>'A complete guide to building modern user interfaces with React.js. Learn components, state management, hooks, and more.',
                'short_description'=>'Build dynamic UIs with React.js from the ground up.',
                'price'=>59.99,'discount_price'=>39.99,'level'=>'intermediate','category'=>'Web Development',
                'tags'=>['React','JavaScript','Frontend','UI'],
                'instructor_id'=>$instructorModels[1]->id,'duration'=>'18 hours',
                'students_count'=>6210,'rating'=>4.9,'reviews_count'=>540,'language'=>'English',
                'last_updated'=>'2024-04-10','is_published'=>true,'is_featured'=>true,
                'modules'=>[['title'=>'React Fundamentals','lessons'=>[['title'=>'What is React?','duration'=>'10:00','is_free'=>true],['title'=>'Creating Components','duration'=>'20:00','is_free'=>false]]]],
            ],
            [
                'title'=>'Python Data Science','slug'=>'python-data-science',
                'description'=>'Dive into data science using Python. Covers NumPy, Pandas, Matplotlib, and machine learning fundamentals.',
                'short_description'=>'Analyze and visualize data with Python.',
                'price'=>69.99,'discount_price'=>null,'level'=>'intermediate','category'=>'Data Science',
                'tags'=>['Python','Data Science','Machine Learning'],
                'instructor_id'=>$instructorModels[2]->id,'duration'=>'22 hours',
                'students_count'=>3890,'rating'=>4.7,'reviews_count'=>278,'language'=>'English',
                'last_updated'=>'2024-02-20','is_published'=>true,'is_featured'=>false,'modules'=>[],
            ],
            [
                'title'=>'UI/UX Design Principles','slug'=>'ui-ux-design-principles',
                'description'=>'Learn the foundations of user interface and user experience design. Covers wireframing, prototyping, and Figma.',
                'short_description'=>'Design beautiful, user-friendly interfaces.',
                'price'=>44.99,'discount_price'=>24.99,'level'=>'beginner','category'=>'Design',
                'tags'=>['UI','UX','Figma','Design'],
                'instructor_id'=>$instructorModels[3]->id,'duration'=>'14 hours',
                'students_count'=>2750,'rating'=>4.6,'reviews_count'=>195,'language'=>'English',
                'last_updated'=>'2024-01-15','is_published'=>true,'is_featured'=>true,'modules'=>[],
            ],
            [
                'title'=>'Node.js & Express Backend Development','slug'=>'nodejs-express-backend',
                'description'=>'Build robust server-side applications with Node.js and Express. Covers REST APIs, authentication, and databases.',
                'short_description'=>'Create scalable backends with Node.js and Express.',
                'price'=>54.99,'discount_price'=>null,'level'=>'intermediate','category'=>'Backend Development',
                'tags'=>['Node.js','Express','Backend','API'],
                'instructor_id'=>$instructorModels[1]->id,'duration'=>'16 hours',
                'students_count'=>3120,'rating'=>4.8,'reviews_count'=>230,'language'=>'English',
                'last_updated'=>'2024-03-25','is_published'=>true,'is_featured'=>false,'modules'=>[],
            ],
            [
                'title'=>'Advanced TypeScript','slug'=>'advanced-typescript',
                'description'=>'Take your TypeScript skills to the next level. Covers advanced types, generics, decorators, and real-world patterns.',
                'short_description'=>'Master advanced TypeScript patterns and techniques.',
                'price'=>64.99,'discount_price'=>null,'level'=>'advanced','category'=>'Web Development',
                'tags'=>['TypeScript','JavaScript','Advanced'],
                'instructor_id'=>$instructorModels[0]->id,'duration'=>'20 hours',
                'students_count'=>1980,'rating'=>4.9,'reviews_count'=>165,'language'=>'English',
                'last_updated'=>'2024-04-01','is_published'=>true,'is_featured'=>false,'modules'=>[],
            ],
        ];
        foreach ($courseData as $data) {
            $modules = $data['modules'] ?? [];
            unset($data['modules']);
            $course = Course::create($data);
            foreach ($modules as $mOrder => $moduleData) {
                $module = CourseModule::create(['course_id'=>$course->id,'title'=>$moduleData['title'],'order'=>$mOrder]);
                foreach (($moduleData['lessons'] ?? []) as $lOrder => $lessonData) {
                    CourseLesson::create(array_merge($lessonData,['course_module_id'=>$module->id,'order'=>$lOrder]));
                }
            }
        }

        // ── Blog posts ─────────────────────────────────────────────────────────
        $blogData = [
            ['title'=>'10 Tips for Learning Web Development Faster','slug'=>'10-tips-learning-web-development','excerpt'=>'Accelerate your web development journey with these practical tips from industry professionals.','content'=>'Learning web development can feel overwhelming at first, but with the right approach you can make rapid progress. Focus on building projects, read documentation, and never stop practicing.','author_id'=>$instructorModels[0]->id,'tags'=>['Learning','Web Development','Tips'],'category'=>'Learning','published_at'=>'2024-03-15','reading_time'=>'5 min read','is_published'=>true],
            ['title'=>'Why Every Developer Should Learn TypeScript','slug'=>'why-learn-typescript','excerpt'=>'TypeScript is transforming how developers write JavaScript. Here\'s why you should make the switch.','content'=>'TypeScript has taken the JavaScript ecosystem by storm, and for good reason. Static typing catches bugs before they reach production and makes code more maintainable and readable.','author_id'=>$instructorModels[1]->id,'tags'=>['TypeScript','JavaScript','Development'],'category'=>'Technology','published_at'=>'2024-03-22','reading_time'=>'7 min read','is_published'=>true],
            ['title'=>'The Future of Online Education','slug'=>'future-of-online-education','excerpt'=>'How technology is reshaping the way we learn and what it means for students and educators.','content'=>'Online education has seen explosive growth over the past few years. With advances in AI and interactive learning tools, the gap between in-person and online education continues to narrow.','author_id'=>$instructorModels[2]->id,'tags'=>['Education','Technology','eLearning'],'category'=>'Education','published_at'=>'2024-04-01','reading_time'=>'6 min read','is_published'=>true],
        ];
        foreach ($blogData as $post) { BlogPost::create($post); }
    }
}
