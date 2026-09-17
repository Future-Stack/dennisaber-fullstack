<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Lesson;

class ProbenContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $basePath = base_path('Proben');
        if (!File::exists($basePath)) {
            $this->command->info('Proben folder not found. Skipping import.');
            return;
        }

        // Get top‑level directories that represent courses
        $courseDirs = File::directories($basePath);
        foreach ($courseDirs as $courseDir) {
            $courseName = basename($courseDir);
            // Skip zip files or backup folders that are not actual courses
            if (Str::contains($courseName, ['Backup', '.zip'])) {
                continue;
            }

            // Create or retrieve the course
            $course = Course::firstOrCreate(
                ['slug' => Str::slug($courseName)],
                [
                    'title'       => $courseName,
                    'description' => "Imported from Proben folder",
                    'order'       => 0,
                ]
            );

            // Scan files inside the course directory (recursively)
            $files = File::allFiles($courseDir);
            $lessonOrder = 1;
            foreach ($files as $file) {
                $relativePath = $file->getRelativePathname();
                $extension = $file->getExtension();
                $filename   = $file->getFilenameWithoutExtension();
                $storagePath = 'proben/' . $courseName . '/' . $relativePath;

                // Ensure the file exists in the public disk
                $contents = File::get($file->getRealPath());
                Storage::disk('public')->put($storagePath, $contents);

                $lessonSlug = Str::slug($filename);
                if (empty($lessonSlug)) {
                    $lessonSlug = 'lesson-' . $lessonOrder;
                }

                if (in_array(strtolower($extension), ['pdf'])) {
                    Lesson::updateOrCreate(
                        [
                            'course_id' => $course->id,
                            'slug'      => $lessonSlug,
                        ],
                        [
                            'title'               => $filename,
                            'order'               => $lessonOrder++,
                            'pdf_attachment_path' => $storagePath,
                            'pdf_attachment_name' => $file->getFilename(),
                        ]
                    );
                } elseif (in_array(strtolower($extension), ['mp3', 'wav', 'm4a'])) {
                    Lesson::updateOrCreate(
                        [
                            'course_id' => $course->id,
                            'slug'      => $lessonSlug,
                        ],
                        [
                            'title'      => $filename,
                            'order'      => $lessonOrder++,
                            'audio_path' => $storagePath,
                        ]
                    );
                }
            }
        }
    }
}
?>
