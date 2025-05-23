<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
use App\Enums\QuestionType;
use App\Models\LicenseTemplate;
use Illuminate\Database\Seeder;
use App\Models\OptionLicenseScore;

class LicenseTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $licenses = [
            [
                'name' => 'MIT License',
                'identifier' => 'mit',
                'content' => <<<EOT
MIT License

Copyright (c) {{ year }} {{ author }}

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
EOT
            ],
            [
                'name' => 'GPL License',
                'identifier' => 'gpl',
                'content' => <<<EOT
GNU GENERAL PUBLIC LICENSE
Version 3, 29 June 2007

Copyright (C) {{ year }} {{ author }}

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <https://www.gnu.org/licenses/>.
EOT
            ],
            [
                'name' => 'Apache License 2.0',
                'identifier' => 'apache',
                'content' => <<<EOT
Apache License
Version 2.0, January 2004
http://www.apache.org/licenses/

Copyright (c) {{ year }} {{ author }}

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
EOT
            ]
        ];

        foreach ($licenses as $license) {
            LicenseTemplate::updateOrCreate(
                ['identifier' => $license['identifier']],
                ['name' => $license['name'], 'content' => $license['content']]
            );
        }

        // Create all questions
        $questions = [
            [
                'text' => 'Do you require your software to be used freely with minimal restrictions?',
                'options' => [
                    ['text' => 'Yes', 'scores' => ['mit' => 3, 'gpl' => 1, 'apache' => 2]],
                    ['text' => 'No',  'scores' => ['mit' => 1, 'gpl' => 3, 'apache' => 2]],
                ]
            ],
            [
                'text' => 'Do you want derivative works to be open source?',
                'options' => [
                    ['text' => 'Yes', 'scores' => ['mit' => 1, 'gpl' => 3, 'apache' => 2]],
                    ['text' => 'No',  'scores' => ['mit' => 3, 'gpl' => 1, 'apache' => 2]],
                ]
            ],
            [
                'text' => 'Do you require explicit attribution in reused software?',
                'options' => [
                    ['text' => 'Yes', 'scores' => ['mit' => 2, 'gpl' => 3, 'apache' => 3]],
                    ['text' => 'No',  'scores' => ['mit' => 3, 'gpl' => 1, 'apache' => 1]],
                ]
            ],
            [
                'text' => 'Do you want to allow commercial use of your project?',
                'options' => [
                    ['text' => 'Yes', 'scores' => ['mit' => 2, 'gpl' => 1, 'apache' => 2]],
                    ['text' => 'No',  'scores' => ['mit' => 1, 'gpl' => 3, 'apache' => 1]],
                ]
            ]
        ];


        $licenses = LicenseTemplate::all()->keyBy('identifier');

        foreach ($questions as $questionData) {
            $question = Question::updateOrCreate(
                ['key' => strtolower(str_replace(' ', '_', $questionData['text']))],
                [
                    'text' => $questionData['text'],
                    'type' => QuestionType::BOOLEAN,
                ]
            );

            foreach ($questionData['options'] as $optionData) {
                $option = $question->options()->updateOrCreate(
                    [
                        'value' => strtolower(str_replace(' ', '_', $optionData['text']))
                    ],
                    [
                        'label' => $optionData['text']
                    ]
                );

                foreach ($optionData['scores'] as $licenseIdentifier => $scoreValue) {
                    if (isset($licenses[$licenseIdentifier])) {
                        OptionLicenseScore::updateOrCreate(
                            [
                                'option_id' => $option->id,
                                'license_template_id' => $licenses[$licenseIdentifier]->id,
                            ],
                            [
                                'score' => $scoreValue,
                            ]
                        );
                    }
                }
            }
        }
    }
}
