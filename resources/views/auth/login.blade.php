@extends('layout')

@section('title', 'Login')

@section('content')
<body class="login">
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">

                <form role="form" action="{{ route('login') }}" method="post">

                    {{ csrf_field() }}

                    <h1>{{ config('app.name') }} Login</h1>

                    <div>
                        <input type="text" class="form-control" placeholder="Username" name="username" required>
                    </div>
                    <div>
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary submit btn-block">Login</button>
                    </div>

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
                </form>

            </section> <!-- ./login_content -->
        </div> <!-- ./animate form login-form -->
    </div> <!-- ./login_wrapper -->
    <script src="{{ mix('/js/login.js') }}"></script>
</body>
@endsection