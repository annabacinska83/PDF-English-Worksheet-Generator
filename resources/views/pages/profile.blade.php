<x-layoutNav body-class="body-blur">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-5" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="d-flex px-3 py-2">
        <div class="container">
            <div class="row justify-content-center align-items-center mt-5">
                <div class="col-12 col-sm-10 col-md-7 col-lg-6">
                    <div class="auth-card bg-white bg-md-transparent shadow-lg shadow-md-none rounded-5 p-4 p-md-5">
                        <div class="credentials d-flex align-items-center">
                            <!-- Circle Icon -->
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white me-3"
                                 style="width: 50px; height: 50px; flex-shrink: 0;">
                                <h3 class="m-0 text-uppercase">
                                    {{ Str::substr(Auth::user()->name, 0, 1) }}
                                </h3>
                            </div>

                            <!-- Text Group (Name + Subtext) -->
                            <div>
                                <h5 class="m-0 fw-bold text-uppercase">{{ Auth::user()->name }}</h5>
                                <small class="text-muted">User profile</small>
                            </div>
                        </div>

                        <form action="{{ route('profile.edit') }}" method="POST">
                        @csrf
                            <!--Name and surname-->
                            <div class="form-group mt-3">
                                <label for="name"  class="custom-muted-text text-uppercase fw-semibold">Name</label>
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
                                    <input type="text" class="form-control border-0 rounded-0 border-bottom shadow-none" name="name" id="name" value="{{ explode(' ', trim(Auth::user()->name))[0] ?? '' }}" placeholder="Name" required>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="surname"  class="custom-muted-text text-uppercase fw-semibold">Surname</label>
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
                                    <input type="text" class="form-control border-0 rounded-0 border-bottom shadow-none" name="surname" id="surname" value="{{ explode(' ', trim(Auth::user()->name))[1] ?? '' }}" placeholder="surname" required>
                                </div>
                            </div>

                            <!-- password -->
                            <div class="form-group mt-3">
                                <label for="password" class="custom-muted-text text-uppercase fw-semibold">Password</label>
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock me-2" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                                    </svg>
                                    <input type="password" class="form-control border-0 rounded-0 border-bottom shadow-none mb-2" name="password" id="password"
                                           placeholder="Password" required>
                                </div>
                            </div>

                            <!-- confirm p[assword-->
                            <div class="form-group mt-2 m">
                                <label for="password_confirmation" class="custom-muted-text text-uppercase fw-semibold">Confirm Password</label>
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock me-2" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/></svg>
                                    <input type="password" class="form-control border-0 rounded-0 border-bottom shadow-none mb-2" name="password_confirmation" id="password_confirmation"
                                           placeholder="Password" required>
                                </div>
                            </div>
                            <!--Register button-->
                            <div class="d-flex align-items-center justify-content-center mt-5">
                                <button type="submit" class="btn btn-auth  text-white fw-semibold p-3">Save changes</button>
                            </div>

                            <!-- Validation errors -->
                            @if ($errors->any())
                                <ul class="bg-error px-4 py-2 rounded-3 list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li class=" my-2 text-danger">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>

                    </div>

                </div>

            </div>
    </div>
    </div>
</x-layoutNav>
