<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Worksheet generator</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/bootstrap.js'])
</head>
<body class="login-page">
<div class="bg-blur-overlay d-none d-sm-block"></div>

<!-- Button to HOMEPAGE -->
<a class ="btn btn-link text-dark p-0 d-flex align-items-center gap-2 position-fixed top-0 start-0 m-4" href='/' style="z-index: 1050;">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
    </svg>
    <span class="text-uppercase fw-semibold">Home</span>
</a>

<div class="d-flex align-items-center justify-content-center px-3 py-2 position-relative z-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-7 col-lg-6">
                <!--Register card-->
                <div class="auth-card bg-white bg-md-transparent shadow-lg shadow-md-none rounded-5 p-4 p-md-5">
                    <!-- logo + text -->
                    <a href="#" class="d-flex justify-content-center">
                        <img src="{{ Vite::asset('resources/images/dark_logo.png') }}" alt="logo" width="60" height="60"></a>
                    <div class="text-center mb-5">
                        <h4 class="fw-bold">Create an Account</h4>
                        <small id="textRegister" >Join us and make learning more fun.</small>
                    </div>

                    <!-- form -->
                    <form class ="auth-form" action="{{ route('register') }}" method="POST">
                        @csrf
                        <!-- name -->
                        <div class="form-group">
                            <label for="inputName"  class="custom-muted-text text-uppercase fw-semibold">Name</label>
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
                                <input type="text" class="form-control border-0 rounded-0 border-bottom shadow-none" name="name" value="{{ old('name') }}" id="inputName"
                                       placeholder="Name" required>
                            </div>
                        </div>

                        <!-- surname -->
                        <div class="form-group">
                            <label for="inputSurname" class="custom-muted-text text-uppercase fw-semibold">Surname</label>
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                </svg>
                                <input type="text" class="form-control border-0 rounded-0 border-bottom shadow-none" name="surname"  value="{{ old('surname') }}" id="inputSurname"
                                       placeholder="Surname" required>
                            </div>
                        </div>

                        <!-- email -->
                        <div class="form-group mt-2">
                            <label for="inputEmail" class="custom-muted-text text-uppercase fw-semibold">Email address</label>
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
                                <input type="email" class="form-control border-0 rounded-0 border-bottom shadow-none" name="email" value="{{ old('email') }}" id="inputEmail" aria-describedby="emailHelp" placeholder="name@example.com" required>
                            </div>
                            <small id="emailHelp" class="custom-muted-text">We'll never share your email with anyone else.</small>
                        </div>

                        <!-- password -->
                        <div class="form-group mt-2">
                            <label for="inputPassword" class="custom-muted-text text-uppercase fw-semibold">Password</label>
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock me-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                                </svg>
                                <input type="password" class="form-control border-0 rounded-0 border-bottom shadow-none mb-2" name="password" id="inputPassword"
                                       placeholder="Password" required>
                            </div>
                        </div>

                        <!-- confirm p[assword-->
                        <div class="form-group mt-2">
                            <label for="inputConfirmPassword" class="custom-muted-text text-uppercase fw-semibold">Confirm Password</label>
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock me-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/></svg>
                                <input type="password" class="form-control border-0 rounded-0 border-bottom shadow-none mb-2" name="password_confirmation" id="inputConfirmPassword"
                                       placeholder="Password" required>
                            </div>
                        </div>

                        <!--Register button-->
                        <button type="submit" class="btn btn-auth text-white text-uppercase fw-semibold w-100 py-3 mt-2 mb-3">Register</button>

                        <!-- Validation errors -->
                        @if ($errors->any())
                            <ul class="bg-error px-4 py-2 rounded-3 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li class=" my-2 text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                    </form>

                    <!--Text log in-->
                    <div class="text-center">
                        <small>Already have an account? <a href="#" class="fw-bold">Log In</a></small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


