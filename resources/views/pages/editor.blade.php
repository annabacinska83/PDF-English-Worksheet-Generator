<x-layoutNav>
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
                    <label for="grade" class="form-label fw-bold">Grade</label>
                    <select id="grade" name="grade" class="form-select rounded-pill">
                        @php
                            $grades = ['1st', '2nd', '3rd', '4th', '5th'];
                        @endphp

                        <option
                            {{ !($data['grade'] >= 1 && $data['grade'] <= sizeof($grades)) ? 'selected' : '' }} disabled>
                            Value
                        </option>
                        @for($i = 0; $i < sizeof($grades); $i++)
                            <option
                                {{ $data['grade'] == $i + 1 ? 'selected' : '' }} value="{{ $i + 1 }}">{{ $grades[$i] }}
                                grade
                            </option>
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
                                           min="1" value="{{ $data['match-the-pairs-questions'] ?? '1' }}" disabled
                                           style="width: 56px; margin: auto;">
                                </td>
                                <td class="text-center text-muted">—</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-12 pt-2">
                    <button type="submit" class="btn btn-dark btn-lg w-100 rounded-pill">
                        Regenerate
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="position-relative z-1 py-3">
        <div class="container px-3 px-md-5 py-md-5">
            <!-- Worksheet preview card -->
            <form class="p-0 m-0" method="GET" action="{{ route('editor.generate') }}">
                @csrf
                <input type="hidden" value="{{ $data['wsht-theme'] }}" name="wsht-theme">
                <input type="hidden" value="{{ $data['wsht-name'] }}" name="wsht-name">
                <input type="hidden" value="{{ $data['grade'] }}" name="wsht-grade">

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
                    <button class="btn btn-light rounded-pill d-flex align-items-center gap-2" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-stars" viewBox="0 0 16 16">
                            <path
                                d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/>
                        </svg>
                        AI generator
                    </button>
                    <button class="btn btn-light rounded-pill d-flex align-items-center gap-2" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                            <path d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z"/>
                            <path d="M13.5 9a.5.5 0 0 1 .5.5V11h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V12h-1.5a.5.5 0 0 1 0-1H13V9.5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                        Save on my profile
                    </button>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <div class="editor-card shadow-sm rounded-4 p-4 p-md-5">

                            <!-- 1. MULTIPLE CHOICE -->
                            @if(isset($data['multiple-choice']))
                                @for($j = 1; $j <= $data['multiple-choice-questions']; $j++)
                                    <div class="mb-4">
                                        @if($j == 1)
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <span
                                                    class="badge bg-primary-subtle text-primary text-uppercase fw-semibold px-3 py-2">Multiple Choice</span>
                                                <span class="text-muted small">Task {{ $j }}</span>
                                            </div>
                                        @endif
                                        <div class="card border rounded-3 shadow-sm">
                                            <div class="card-body p-4">
                                                {{-- Question --}}
                                                <label
                                                    class="form-label text-muted small mb-1">Question {{ $j }}</label>
                                                <input type="text"
                                                       name="mch_question_{{ $j }}"
                                                       class="form-control form-control-lg bg-light text-secondary border-0 rounded-3 mb-4"
                                                       value="e.g. She ___ to school every day.">
                                                {{-- Answer choices --}}
                                                <label class="form-label text-muted small mb-2">Answer choices</label>

                                                @for ($i = 0; $i < $data['multiple-choice-choices']; $i++)
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <span
                                                            class="d-flex align-items-center justify-content-center border rounded-2 fw-semibold bg-light text-secondary shrink-0"
                                                            style="width:32px;height:32px;">{{ chr($i + 97) }}</span>
                                                        <input type="text"
                                                               name="mch_choice_text_{{ $j }}_{{ $i }}"
                                                               class="form-control bg-light text-secondary border-0 rounded-3"
                                                               value = "choice {{ chr($i + 97) }}..."
                                                               placeholder="Enter choice {{ chr($i + 97) }}...">
                                                        <div class="d-flex align-items-center gap-1 shrink-0">
                                                            <input class="form-check-input mt-0"
                                                                   type="checkbox"
                                                                   name="mch_choice_checkbox_{{ $j }}_{{ $i }}"
                                                                   id="c{{ $j }}_{{ $i }}">
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
                                    <div class="d-flex align-items-center gap-2 mb-3 mt-5">
                                        <span
                                            class="badge bg-success-subtle text-success text-uppercase fw-semibold px-3 py-2">
                                            Fill In The Blanks</span>
                                        <span class="text-muted small">Task</span>
                                    </div>
                                    <div class="card border rounded-3 shadow-sm">
                                        <div class="card-body p-4">
                                            <label class="form-label text-muted small mb-1">Text with blanks</label>
                                            <div class="question-input-wrap">
                                                <textarea
                                                    id="fillInTheBlanksTextarea"
                                                    name="fintb_text"
                                                    class="form-control bg-light border-0 mb-4"></textarea>
                                            </div>
                                            <span id="spanForOptions"></span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- 3. MATCH THE PAIRS -->
                            @if(isset($data['match-the-pairs']))
                                <div class="mb-4">
                                    <div class="d-flex align-items-center gap-2 mb-3 mt-5">
                                        <span
                                            class="badge bg-danger-subtle text-danger text-uppercase fw-semibold px-3 py-2">
                                            Match The Pairs</span>
                                        <span class="text-muted small">Task</span>
                                    </div>
                                    <div class="card border rounded-3 shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="row mb-2">
                                                <div class="col-5">
                                                    <span
                                                        class="text-uppercase text-muted small fw-semibold">Left Column</span>
                                                </div>
                                                <div class="col-2"></div>
                                                <div class="col-5">
                                                    <span
                                                        class="text-uppercase text-muted small fw-semibold">Right Column</span>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column gap-3">
                                                @for($i = 0; $i < $data['match-the-pairs-questions']; $i++)
                                                    <div class="row align-items-center">
                                                        <div class="col-5">
                                                            <input type="text"
                                                                   class="form-control bg-light text-secondary border-0 rounded-3 p-3"
                                                                   name="mtp_lp_{{ $i }}"
                                                                   placeholder="Term...">
                                                        </div>
                                                        <div class="col-2 text-center text-muted">→</div>
                                                        <div class="col-5">
                                                            <input type="text"
                                                                   class="form-control bg-light text-secondary border-0 rounded-3 p-3"
                                                                   name="mtp_rp_{{ $i }}"
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
