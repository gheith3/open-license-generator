<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Question;
use Illuminate\Support\Str;
use App\Services\LicenseDecisionService;

class LicenseGenerator extends Component
{
    public $projectName = '';
    public $author = '';
    public $answers = []; // [question_id => option_id]
    public $licenseText = null;
    public $license = null;

    public function mount()
    {
        foreach (Question::with('options')->get() as $question) {
            $this->answers[$question->id] = null;
        }
    }

    public function updated($propertyName)
    {
        // Only trigger generation if the project name is filled
        if ($this->projectName && filled($this->answers)) {
            $this->generate();
        } else {
            $this->licenseText = null;
        }
    }


    public function generate()
    {
        $selectedOptionIds = array_filter($this->answers);

        if (empty($selectedOptionIds)) {
            $this->licenseText = 'Please answer at least one question.';
            return;
        }

        // Use the service to get the best license
        $this->license = app(LicenseDecisionService::class)->decide($selectedOptionIds);

        // Format the license content
        $this->licenseText = str($this->license->content)
            ->replace('{{ year }}', now()->year)
            ->replace('{{ author }}', $this->author)
            ->replace('{{ project_name }}', $this->projectName)
            ->toString();

        // Save the license
        $this->license->generatedLicenses()->create([
            'project_name' => $this->projectName,
            'author' => $this->author,
            'content' => $this->licenseText,
        ]);
    }

    public function render()
    {
        return view('livewire.components.license-generator', [
            'questions' => Question::with('options')->get(),
        ]);
    }

    public function copyToClipboard()
    {
        $this->dispatch('clipboardCopy', text: $this->licenseText);
    }

    public function downloadReadme()
    {
        $filename = Str::slug($this->projectName) . '-README.md';
        $content = "# {$this->projectName}\n\n## License\n\n{$this->licenseText}";

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $filename);
    }
}
