<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLessonRequest;
use App\Http\Requests\Admin\UpdateLessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonAttachment;
use App\Enums\VideoProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function create(Course $course)
    {
        $nextOrder = $course->lessons()->max('order') + 1;
        $providers = VideoProvider::cases();
        return view('admin.lessons.create', compact('course', 'nextOrder', 'providers'));
    }

    public function store(StoreLessonRequest $request, Course $course)
    {
        $data = $request->validated();

        // Remover attachment do data (será tratado separadamente)
        unset($data['attachment']);

        $lesson = $course->lessons()->create($data);

        // Processar múltiplos anexos
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $index => $file) {
                $filepath = $file->store('lessons/attachments', 'public');
                
                LessonAttachment::create([
                    'lesson_id' => $lesson->id,
                    'filename' => $file->getClientOriginalName(),
                    'filepath' => $filepath,
                    'filetype' => LessonAttachment::detectType($file->getClientOriginalName()),
                    'filesize' => $file->getSize(),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Aula criada com sucesso!');
    }

    public function edit(Lesson $lesson)
    {
        $lesson->load('attachments');
        $providers = VideoProvider::cases();
        return view('admin.lessons.edit', compact('lesson', 'providers'));
    }

    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $data = $request->validated();

        // Remover attachment do data
        unset($data['attachment']);

        $lesson->update($data);

        // Processar novos anexos
        if ($request->hasFile('attachments')) {
            $maxOrder = $lesson->attachments()->max('order') ?? -1;
            
            foreach ($request->file('attachments') as $index => $file) {
                $filepath = $file->store('lessons/attachments', 'public');
                
                LessonAttachment::create([
                    'lesson_id' => $lesson->id,
                    'filename' => $file->getClientOriginalName(),
                    'filepath' => $filepath,
                    'filetype' => LessonAttachment::detectType($file->getClientOriginalName()),
                    'filesize' => $file->getSize(),
                    'order' => $maxOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.courses.edit', $lesson->course_id)
            ->with('success', 'Aula atualizada com sucesso!');
    }

    public function destroy(Lesson $lesson)
    {
        $courseId = $lesson->course_id;
        
        // Deletar arquivos físicos dos anexos
        foreach ($lesson->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->filepath);
        }
        
        $lesson->delete();

        return redirect()->route('admin.courses.edit', $courseId)
            ->with('success', 'Aula excluída com sucesso!');
    }

    public function destroyAttachment(LessonAttachment $attachment)
    {
        $lessonId = $attachment->lesson_id;
        $lesson = Lesson::find($lessonId);
        
        // Deletar arquivo físico
        Storage::disk('public')->delete($attachment->filepath);
        
        $attachment->delete();

        return redirect()->route('admin.lessons.edit', $lesson)
            ->with('success', 'Anexo excluído com sucesso!');
    }

    public function toggleActive(Lesson $lesson)
    {
        $lesson->update(['is_active' => !$lesson->is_active]);

        $status = $lesson->is_active ? 'ativada' : 'desativada';

        return redirect()->back()->with('success', "Aula {$status} com sucesso!");
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'lessons' => 'required|array',
            'lessons.*.id' => 'required|exists:lessons,id',
            'lessons.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->lessons as $item) {
            Lesson::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
