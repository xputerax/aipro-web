@extends('layout')

@section('title', 'Login')

@php
    $parse_body_tag = false;
@endphp

@section('content')
<body class="login">
    <div>
        {{-- <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a> --}}

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    
                    <form role="form" action="{{ route('login') }}" method="post">
                        
                        <h1>{{ config('app.name') }} Login</h1>
                        
                        <div>
                            <input type="text" class="form-control" placeholder="Username" name="username" required>
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                        </div>
                        
                        {{ csrf_field() }}

                        @if($errors->any())
                            @foreach($errors->all() as $error)

                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {{ $error }}
                            </div>

                            @endforeach
                        @endif

                        <div>
                            <button type="submit" class="btn btn-primary submit">Login</button>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">
                                <a href="#signup" class="to_register"></a>
                            </p>

                            <div class="clearfix"></div><br />

                            {{-- <div>
                                <p>&copy;2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template.
                                    Privacy and Terms</p>
                            </div> --}}
                        </div> <!-- ./separator -->
                    </form>

                </section> <!-- ./login_content -->
            </div> <!-- ./animate form login-form -->
        </div> <!-- ./login_wrapper -->
    </div>

    <script src="{{ mix('/js/login.js') }}"></script>

</body>
@endsection