@extends('layouts.dashforge')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    {{ Auth::user()->email }}

                    {{ Former::horizontal_open()
                          ->id('MyForm')
                          ->rules(['name' => 'required'])
                          ->method('POST');
                    !!}

                    {{
                         Former::textarea('comments')
                            ->rows(10)
                            ->columns(20)
                            ->autofocus();
                    !!}
                    {{
                         Former::actions()
                            ->large_primary_submit('Submit') # Combine Bootstrap directives like "lg and btn-primary"
                            ->large_inverse_reset('Reset');
                     !!}
                    {{
                     Former::close();
                     !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
