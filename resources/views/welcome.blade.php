<x-layoutNavFooter>
    <main class="d-flex flex-column min-vh-100 grow">

        <!-- ROW 1 / HERO -->
        <section class="home-bg row-hero py-5 d-flex align-items-center">
            <div class="container py-5">
                <div class="row g-0 align-items-end">
                    <div class="col-12 col-lg-6 d-flex justify-content-center justify-content-lg-end pe-lg-4">
                        <h1 class="hero-title fw-bold text-uppercase mb-0 text-center text-lg-end">
                            Generator
                        </h1>
                    </div>

                    <div class="col-12 col-lg-6 d-flex flex-column justify-content-center ps-lg-4 mt-3 mt-lg-0">
                        <h1 id="textGenerator" class="hero-title fw-bold text-uppercase mb-2 text-center text-lg-start">
                            Worksheet
                        </h1>
                        <p class="text-secondary mb-0 text-center text-lg-start mx-auto mx-lg-0" style="max-width: 450px;">
                            Create a worksheet using AI in just a few minutes. All you need to do is choose a category,
                            set the difficulty level, and write what exactly you want to practice.
                        </p>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-12 d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">
                        @auth
                        <button type="button" class="btn scroll-btn btn-dark rounded-pill px-5 py-3 fw-bold shadow-sm">
                            Start Building
                        </button>
                        @endauth
                            @guest
                                <a href="{{ route('login') }}" id="guestButton" class="btn btn-dark rounded-pill px-5 py-3 fw-bold shadow-sm">Start building</a>
                            @endguest

                        <small class="text-muted text-center text-sm-start">
                            No credit card required.<br>
                            Cancel anytime.
                        </small>
                    </div>
                </div>
            </div>
        </section>

        <!-- ROW 2 / PREVIEW -->
        <section class="row-preview py-5">
            <div class="container">
                <div class="bg-light generator-row row g-0 rounded-5 overflow-hidden shadow-sm">
                    <div class="col-12 col-lg-5 p-4 px-lg-5 d-flex flex-column justify-content-center align-items-center text-center text-lg-start">
                        <h2 class="fw-bold mb-3">Your worksheet, generated fast.</h2>
                        <p>
                            Choose a category, set the difficulty level, and describe
                            what you want to practice.
                        </p>
                        @guest
                        <a href="{{ route('login') }}" id="guestButton" class="btn btn-dark rounded-pill px-5 py-3 fw-bold shadow-sm">Start building</a>
                        @endguest
                        @auth
                            <button type="button" class="btn scroll-btn btn-dark rounded-pill px-5 py-3 fw-bold shadow-sm">
                                Start Building
                            </button>
                        @endauth


                    </div>

                    <div class="gradient-block col-12 col-lg-7 d-none d-lg-flex p-5 align-items-center justify-content-center">
                        <div class="bg-light p-4 rounded-4 shadow-sm d-flex flex-column w-100" style="max-width: 720px;">
                            <p class="text-typewriter text-secondary mb-4">
                                Create a worksheet for A2 English learners practicing past simple vs present perfect.
                            </p>

                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3 fw-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                         class="bi bi-plus-circle-dotted" viewBox="0 0 16 16">
                                        <path d="M8 0q-.264 0-.523.017l.064.998a7 7 0 0 1 .918 0l.064-.998A8 8 0 0 0 8 0M6.44.152q-.52.104-1.012.27l.321.948q.43-.147.884-.237L6.44.153zm4.132.271a8 8 0 0 0-1.011-.27l-.194.98q.453.09.884.237zm1.873.925a8 8 0 0 0-.906-.524l-.443.896q.413.205.793.459zM4.46.824q-.471.233-.905.524l.556.83a7 7 0 0 1 .793-.458zM2.725 1.985q-.394.346-.74.74l.752.66q.303-.345.648-.648zm11.29.74a8 8 0 0 0-.74-.74l-.66.752q.346.303.648.648zm1.161 1.735a8 8 0 0 0-.524-.905l-.83.556q.254.38.458.793l.896-.443zM1.348 3.555q-.292.433-.524.906l.896.443q.205-.413.459-.793zM.423 5.428a8 8 0 0 0-.27 1.011l.98.194q.09-.453.237-.884zM15.848 6.44a8 8 0 0 0-.27-1.012l-.948.321q.147.43.237.884zM.017 7.477a8 8 0 0 0 0 1.046l.998-.064a7 7 0 0 1 0-.918zM16 8a8 8 0 0 0-.017-.523l-.998.064a7 7 0 0 1 0 .918l.998.064A8 8 0 0 0 16 8M.152 9.56q.104.52.27 1.012l.948-.321a7 7 0 0 1-.237-.884l-.98.194zm15.425 1.012q.168-.493.27-1.011l-.98-.194q-.09.453-.237.884zM.824 11.54a8 8 0 0 0 .524.905l.83-.556a7 7 0 0 1-.458-.793zm13.828.905q.292-.434.524-.906l-.896-.443q-.205.413-.459.793zm-12.667.83q.346.394.74.74l.66-.752a7 7 0 0 1-.648-.648zm11.29.74q.394-.346.74-.74l-.752-.66q-.302.346-.648.648zm-1.735 1.161q.471-.233.905-.524l-.556-.83a7 7 0 0 1-.793.458zm-7.985-.524q.434.292.906.524l.443-.896a7 7 0 0 1-.793-.459zm1.873.925q.493.168 1.011.27l.194-.98a7 7 0 0 1-.884-.237zm4.132.271a8 8 0 0 0 1.012-.27l-.321-.948a7 7 0 0 1-.884.237l.194.98zm-2.083.135a8 8 0 0 0 1.046 0l-.064-.998a7 7 0 0 1-.918 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                                    </svg>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                         class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                    </svg>

                                    <span>Add level</span>
                                </div>

                                @guest
                                    <a href="{{ route('login') }}" id="guestButton" class="btn btn-dark d-flex align-items-center justify-content-center rounded-3 p-0"
                                    style="width: 44px; height: 44px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                             class="bi bi-arrow-up" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                  d="M8 12a.5.5 0 0 0 .5-.5V3.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 3.707V11.5A.5.5 0 0 0 8 12"/>
                                        </svg>
                                    </a>
                                @endguest
                                @auth
                                    <button type="button" class="btn scroll-btn btn-dark d-flex align-items-center justify-content-center rounded-3 p-0"
                                            style="width: 44px; height: 44px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                             class="bi bi-arrow-up" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                  d="M8 12a.5.5 0 0 0 .5-.5V3.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 3.707V11.5A.5.5 0 0 0 8 12"/>
                                        </svg>
                                    </button>
                                @endauth

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @auth
        <!-- ROW 3 / QUESTION -->
        <section class="container-question row-question py-5 d-flex align-items-center justify-content-center">
            <div class="container text-center">
                <h1 class="h1-question mb-0">
                    So, what are you <br> building?
                </h1>
            </div>
        </section>

        <!-- ROW 4 / FORM -->
        <section class="home-bottom-bg py-5">
            <div class="container py-5">
                <div class="form-shell rounded-5 shadow-sm p-4 p-lg-5 mx-auto">
                    <div class="bg-circle">
                    <form id="welcome-form" method="POST" action="{{ route('show.editor') }}" class="row g-4 g-lg-5 align-items-stretch">
                        @csrf
                        <div class="col-12 col-lg-6">
                            <div class="row g-4  py-4">
                                <div class="col-12">
                                    <label for="wsht-name" class="form-label text-light">Name of the worksheet</label>
                                    <input
                                        id="wsht-name"
                                        name="wsht-name"
                                        value="{{ old("wsht-name") }}"
                                        class="form-control form-dark"
                                        placeholder="Write a message"
                                        autocomplete="off"
                                    >
                                </div>

                                <div class="col-12">
                                    <label for="wsht-theme" class="form-label text-light">Topic of the worksheet</label>
                                    <input
                                        id="wsht-theme"
                                        name="wsht-theme"
                                        value="{{ old("wsht-theme") }}"
                                        class="form-control form-dark"
                                        placeholder="Write a message"
                                        autocomplete="off"
                                    >
                                </div>

                                <div class="col-12">
                                    <div class="row g-3">
                                        <div class="col-12 col-sm-4">
                                            <label for="level" class="form-label text-light">Level</label>
                                            <select id=level" name="wsht-level" class="form-select form-dark">
                                                @php
                                                    $levels = ['Elementary', 'Beginner', 'Pre-intermediate', 'Intermediate', 'Advanced'];
                                                @endphp
                                                <option {{ old('wsht-level') === null ? 'selected' : '' }} disabled>Level</option>
                                                @for($i = 0; $i < sizeof($levels); $i++)
                                                    <option {{ old('wsht-level') == $levels[$i] ? 'selected' : '' }} value="{{ $levels[$i] }}">{{ $levels[$i] }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="col-12 d-flex gap-3 mt-4">
                                <p class="text-start text-light" style="min-width: 180px;">Question type</p>
                                <p class="text-start text-light" style="min-width: 60px;">Questions</p>
                                <p class="text-start text-light" style="min-width: 60px;">Choices</p>
                            </div>
                            <div class="col-12 ">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="form-check m-0" style="min-width: 180px;">
                                        <input class="form-check-input form-check-input-dark  task-check" name="multiple-choice" type="checkbox" id="task1"
                                               data-target="qty1|qty2">
                                        <label class="form-check-label text-light" for="task1">Multiple choice</label>
                                    </div>
                                    <input type="number" class="form-control form-control-dark" name="multiple-choice-questions" id="qty1" min="1" max="15" value="1" disabled
                                           style="max-width: 60px;">
                                    <input type="number" class="form-control form-control-dark" name="multiple-choice-choices" id="qty2" min="1" max="4" value="3"  disabled
                                           style="max-width: 60px;">
                                </div>

                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="form-check m-0" style="min-width: 180px;">
                                        <input class="form-check-input form-check-input-dark task-check" name="fill-in-the-blanks" type="checkbox" id="task2"
                                               data-target="qty3">
                                        <label class="form-check-label text-light" for="task2">Fill in the blanks</label>
                                    </div>

                                    <input type="number" class="form-control form-control-dark" name="fill-in-the-blanks-questions" id="qty3" min="1" max="15" value="1" disabled
                                           style="max-width: 60px;">
                                </div>

                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="form-check m-0" style="min-width: 180px;">
                                        <input class="form-check-input form-check-input-dark task-check" type="checkbox" name="match-the-pairs" id="task3"
                                               data-target="qty4">
                                        <label class="form-check-label text-light" for="task3">Match the pairs</label>
                                    </div>

                                    <input type="number" class="form-control form-control-dark" name="match-the-pairs-questions" id="qty4" min="2" max="15" value="2" disabled
                                           style="max-width: 60px;">
                                </div>
                            </div>
                        </div>
                        <div class="circle-side d-flex justify-content-center align-items-center">
                            <button type="submit" id="submitWorksheetBtn" class="btn build-btn rounded-pill px-4 px-lg-5 py-3">
                                Generate a worksheet
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671"/>
                                </svg>
                            </button>
                        </div>
                        @if ($errors->any())
                            <ul class="bg-error px-4 py-2 rounded-3 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li class=" my-2 text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                            <script>
                                window.scrollTo(0, 1850);
                            </script>
                        @endif
                    </form>
                    </div>
                </div>
            </div>
        </section>
        @endauth
    </main>
</x-layoutNavFooter>
