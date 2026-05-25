<x-layoutNav>
    @if(isset($error))
        <div class="alert alert-danger alert-dismissible fade show m-5" role="alert">
            <strong>Error!</strong> {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(isset($success))
        <div class="alert alert-success alert-dismissible fade show m-5" role="alert">
            <strong>Success!</strong> {{ $success }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="bg-blur-overlay d-none d-sm-block"></div>
    <!-- Offcanvas worksheet setting-->
    <div class="offcanvas offcanvas-start" id="settingsCanvas" aria-labelledby="settingsCanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title fw-bold" id="settingsCanvasLabel">Worksheet Settings</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form method="POST" action="{{ route('show.editor') }}" class="row g-3">
                @csrf
                <div class="col-12">
                    <label for="wsht-name" class="form-label fw-bold">Worksheet Name</label>
                    <input type="text" id="wsht-name" name="wsht-name" class="form-control rounded-pill"
                           placeholder="Worksheet name" value="{{ $data['wsht-name'] ?? '' }}">
                </div>

                <div class="col-12">
                    <label for="wsht-theme" class="form-label fw-bold">Worksheet Theme</label>
                    <input type="text" id="wsht-theme" name="wsht-theme" class="form-control rounded-pill"
                           placeholder="Worksheet topic" value="{{ $data['wsht-theme'] ?? '' }}">
                </div>

                <div class="col-12">
                    <label for="level" class="form-label fw-bold">Level</label>
                    <select id="level" name="wsht-level" class="form-select rounded-pill">
                        @php
                            $levels = ['Elementary', 'Beginner', 'Pre-intermediate', 'Intermediate', 'Advanced'];
                        @endphp

                        <option disabled>Value</option>
                        @for($i = 0; $i < sizeof($levels); $i++)
                            <option {{ $data['wsht-level'] == $levels[$i] ? 'selected' : '' }} value="{{ $levels[$i] }}">{{ $levels[$i] }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-12">
                    <p class="fw-bold mb-2">Question Types</p>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table">
                            <tr>
                                <th>Type</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Choices</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="form-check m-0">
                                        <input class="form-check-input task-check" type="checkbox" id="task1"
                                               name="multiple-choice"
                                               data-target="qty1|qty2" {{ isset($data['multiple-choice']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="task1">Multiple choice</label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <input type="number" class="form-control form-control-sm text-center" id="qty1"
                                           min="1" name="multiple-choice-questions"
                                           value="{{ $data['multiple-choice-questions'] ?? '1' }}" disabled
                                           style="width: 56px; margin: auto;">
                                </td>
                                <td class="text-center">
                                    <input type="number" class="form-control form-control-sm text-center" id="qty2"
                                           min="1" name="multiple-choice-choices"
                                           value="{{ $data['multiple-choice-choices'] ?? '3' }}" disabled
                                           style="width: 56px; margin: auto;">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check m-0">
                                        <input class="form-check-input task-check" name="fill-in-the-blanks"
                                               type="checkbox" id="task2"
                                               data-target="qty3" {{ isset($data['fill-in-the-blanks']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="task2">Fill in the blanks</label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <input type="number" class="form-control form-control-sm text-center"
                                           name="fill-in-the-blanks-questions" id="qty3"
                                           min="1" value="{{ $data['fill-in-the-blanks-questions'] ?? '1' }}" disabled
                                           style="width: 56px; margin: auto;">
                                </td>
                                <td class="text-center text-muted">—</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check m-0">
                                        <input class="form-check-input task-check" type="checkbox"
                                               name="match-the-pairs" id="task3"
                                               data-target="qty4" {{ isset($data['match-the-pairs']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="task3">Match the pairs</label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <input type="number" class="form-control form-control-sm text-center"
                                           name="match-the-pairs-questions" id="qty4"
                                           min="2" value="{{ $data['match-the-pairs-questions'] ?? '2' }}" disabled
                                           style="width: 56px; margin: auto;">
                                </td>
                                <td class="text-center text-muted">—</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-12 pt-2">
                    <input type="hidden" value="{{ $data['wsht-id'] ?? '' }}" name="wsht-id">
                    <button type="submit" class="btn btn-dark btn-lg w-100 rounded-pill">
                        Regenerate
                    </button>
                </div>
                <div class="col-12">
                <button class="btn btn-light gradient-rectangle rounded-pill text-light d-flex align-items-center justify-content-center gap-2 btn-lg w-100 rounded-pill"
                        type="submit"
                        formmethod="POST"
                        formaction="{{ route('editor.generateWorksheet') }}"
                        data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-stars" viewBox="0 0 16 16">
                        <path
                            d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/>
                    </svg>
                    AI generator
                </button>
                    </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Worksheet Generator</h1>
                </div>
                <div class="modal-body">
                    Please wait until your worksheet gets generated :)
                </div>
            </div>
        </div>
    </div>

    <div class="position-relative z-1 py-3">
        <div class="container px-3 px-md-5 py-md-5">
            <!-- Worksheet preview card -->
            <form class="p-0 m-0" method="GET" action="{{ route('editor.generatePDF') }}">
                @csrf
                <input type="hidden" value="{{ $data['multiple-choice'] ?? '' }}" name="multiple-choice">
                <input type="hidden" value="{{ $data['multiple-choice-questions'] ?? '' }}" name="multiple-choice-questions">
                <input type="hidden" value="{{ $data['multiple-choice-choices'] ?? '' }}" name="multiple-choice-choices">
                <input type="hidden" value="{{ $data['fill-in-the-blanks'] ?? '' }}" name="fill-in-the-blanks">
                <input type="hidden" value="{{ $data['fill-in-the-blanks-questions'] ?? '' }}" name="fill-in-the-blanks-questions">
                <input type="hidden" value="{{ $data['match-the-pairs'] ?? '' }}" name="match-the-pairs">
                <input type="hidden" value="{{ $data['match-the-pairs-questions'] ?? '' }}" name="match-the-pairs-questions">
                <input type="hidden" value="{{ $data['wsht-id'] ?? '' }}" name="wsht-id">
                <input type="hidden" value="{{ $data['wsht-theme'] ?? '' }}" name="wsht-theme">
                <input type="hidden" value="{{ $data['wsht-name'] ?? '' }}" name="wsht-name">
                <input type="hidden" value="{{ $data['wsht-level'] ?? '' }}" name="wsht-level">

                <div class="d-flex align-items-center gap-2 mb-4">
                    <button class="btn btn-light rounded-pill d-flex align-items-center gap-2"
                            type="button" data-bs-toggle="offcanvas" data-bs-target="#settingsCanvas"
                            aria-controls="settingsCanvas">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-sliders" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                  d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1z"/>
                        </svg>
                        Settings
                    </button>

                    <button class="btn btn-light rounded-pill d-flex align-items-center gap-2" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-printer" viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                            <path
                                d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/>
                        </svg>
                        Download PDF
                    </button>
                    <button class="btn btn-light rounded-pill d-flex align-items-center gap-2"
                            type="submit"
                            formmethod="GET"
                            formaction="{{ route('editor.generateKeyPDF') }}">
                        {{--Ak kliknem na toto tlacitko odoslem formular POST na route, inak ho odoslem tak, ako doteraz--}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                            <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0"/>
                        </svg>
                        Download answer sheet
                    </button>
                    <button class="btn btn-light rounded-pill d-flex align-items-center gap-2"
                            type="submit"
                            formmethod="POST"
                            formaction="{{ route('editor.save') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                            <path d="M11 2H9v3h2z"/>
                            <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                        </svg>
                        Save on my profile
                    </button>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <div class="editor-card shadow-sm rounded-4 p-4 p-md-5">
                            <!-- 1. MULTIPLE CHOICE -->
                            @php
                                $taskNum = 1;
                            @endphp
                            @if(isset($data['multiple-choice']))
                                @for($j = 1; $j <= $data['multiple-choice-questions']; $j++)
                                    <div class="mb-4">
                                        @if($j == 1)
                                            <div class="d-flex gap-2 mb-3 align-items-center justify-content-between">
                                                <div>
                                                    <span class="badge bg-primary-subtle text-primary text-uppercase fw-semibold px-3 py-2 ">Multiple Choice</span>
                                                    <span class="text-muted small">Task {{ $taskNum++ }}</span>
                                                </div>
                                                <button class="btn retakeBtn gradient-rectangle text-light rounded-pill d-flex align-items-center gap-2"
                                                        type="submit"
                                                        formmethod="POST"
                                                        formaction="{{ route('editor.generateExercise') }}"
                                                        value="mc"
                                                        name="exercise-type">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                                        <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                                                        <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
                                                        <g transform="translate(4.9 5.1) scale(0.4)">
                                                            <path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/>
                                                        </g>
                                                    </svg>
                                                    Retake
                                                </button>
                                            </div>
                                        @endif
                                        <div class="card border rounded-3 shadow-sm">
                                            <div class="card-body p-4">
                                                {{-- Question --}}
                                                <label class="form-label text-muted small mb-1">Question {{ $j }}</label>
                                                <input type="text"
                                                       name="mch_question_{{ $j }}"
                                                       value="{{ $data['mch_question_' . $j] ?? '' }}"
                                                       placeholder="Question {{ $j }}."
                                                       class="form-control form-control-lg bg-light text-secondary border-0 rounded-3 mb-4">
                                                {{-- Answer choices --}}
                                                <label class="form-label text-muted small mb-2">Answer choices</label>

                                                @for ($i = 0; $i < $data['multiple-choice-choices']; $i++)
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <span
                                                            class="d-flex align-items-center justify-content-center border rounded-2 fw-semibold bg-light text-secondary shrink-0"
                                                            style="width:32px;height:32px;">{{ chr($i + 97) }}</span>
                                                        <input type="text"
                                                               name="mch_choice_text_{{ $j }}_{{ $i }}"
                                                               value="{{ $data['mch_choice_text_' . $j . '_' . $i] ?? '' }}"
                                                               class="form-control bg-light text-secondary border-0 rounded-3"
                                                               placeholder="Enter choice {{ chr($i + 97) }}...">
                                                        <div class="d-flex align-items-center gap-1 shrink-0">
                                                            <input class="form-check-input mt-0"
                                                                   type="checkbox"
                                                                   name="mch_choice_checkbox_{{ $j }}_{{ $i }}"
                                                                   id="c{{ $j }}_{{ $i }}" {{ $data['mch_choice_checkbox_' . $j . '_' . $i] ?? '' }}>
                                                            <label class="form-check-label small text-muted"
                                                                   for="c{{ $j }}_{{ $i }}">Correct</label>
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @endif

                            <!-- 2. FILL IN THE BLANKS -->
                            @if(isset($data['fill-in-the-blanks']))
                                <div class="mb-4">
                                    <div class="d-flex align-items-center gap-2 mb-3 mt-5 justify-content-between">
                                        <div>
                                            <span class="badge bg-success-subtle text-success text-uppercase fw-semibold px-3 py-2">Fill In The Blanks</span>
                                            <span class="text-muted small">Task {{ $taskNum++ }}</span>
                                        </div>
                                        <button class="btn retakeBtn gradient-rectangle text-light rounded-pill d-flex align-items-center gap-2"
                                                type="submit"
                                                formmethod="POST"
                                                formaction="{{ route('editor.generateExercise') }}"
                                                value="fitb"
                                                name="exercise-type">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
                                                <g transform="translate(4.9 5.1) scale(0.4)">
                                                    <path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/>
                                                </g>
                                            </svg>
                                            Retake
                                        </button>
                                    </div>
                                    <div class="card border rounded-3 shadow-sm">
                                        <div class="card-body p-4">
                                            <label class="form-label text-muted small mb-1">Text with blanks</label>
                                            <div class="question-input-wrap">
                                                <textarea
                                                    id="fillInTheBlanksTextarea"
                                                    name="fintb-text"
                                                    placeholder="Type in the text..."
                                                    class="form-control bg-light border-0 mb-4">{{ $data['fintb-text'] ?? "" }}</textarea>
                                            </div>
                                            <span id="spanForOptions"></span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- 3. MATCH THE PAIRS -->
                            @if(isset($data['match-the-pairs']))
                                <div class="mb-4">
                                    <div class="d-flex align-items-center gap-2 mb-3 mt-5 justify-content-between">
                                        <div>
                                            <span class="badge bg-danger-subtle text-danger text-uppercase fw-semibold px-3 py-2">Match The Pairs</span>
                                            <span class="text-muted small">Task {{ $taskNum++ }}</span>
                                        </div>
                                        <button class="btn retakeBtn gradient-rectangle text-light rounded-pill d-flex align-items-center gap-2"
                                                type="submit"
                                                formmethod="POST"
                                                formaction="{{ route('editor.generateExercise') }}"
                                                value="mtp"
                                                name="exercise-type">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
                                                <g transform="translate(4.9 5.1) scale(0.4)">
                                                    <path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/>
                                                </g>
                                            </svg>
                                            Retake
                                        </button>
                                    </div>
                                    <div class="card border rounded-3 shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="row mb-2">
                                                <div class="col-5">
                                                    <span class="text-uppercase text-muted small fw-semibold">Left Column</span>
                                                </div>
                                                <div class="col-2"></div>
                                                <div class="col-5">
                                                    <span class="text-uppercase text-muted small fw-semibold">Right Column</span>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column gap-3">
                                                @for($i = 0; $i < $data['match-the-pairs-questions']; $i++)
                                                    <div class="row align-items-center">
                                                        <div class="col-5">
                                                            <input type="text"
                                                                   class="form-control bg-light text-secondary border-0 rounded-3 p-3"
                                                                   name="mtp_lp_{{ $i }}"
                                                                   value="{{ $data['mtp_lp_'.$i] ?? '' }}"
                                                                   placeholder="Term...">
                                                        </div>
                                                        <div class="col-2 text-center text-muted">→</div>
                                                        <div class="col-5">
                                                            <input type="text"
                                                                   class="form-control bg-light text-secondary border-0 rounded-3 p-3"
                                                                   name="mtp_rp_{{ $i }}"
                                                                   value="{{ $data['mtp_rp_'.$i] ?? '' }}"
                                                                   placeholder="Term...">
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-layoutNav>
