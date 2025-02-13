@extends('layouts.vertical', ['title' => 'Domains'])

@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-sm-center flex-sm-row flex-column py-3">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Domains</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-xl-7">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center mb-4">
                            <h1>Domain Check Results</h1>

                            <ul>
                                @foreach ($domains as $domain)
                                    <li style="padding-bottom: 0.3rem; margin-left: 1rem;">
                                        {{ $domain['domain'] }}: {{ $domain['available'] ? 'Available' : 'Unavailable' }}
                                        @if ($domain['available'])
                                            <a href="{{ route('domain.register.show', ['domain' => $domain['domain']]) }}"
                                                class="btn btn-sm btn-success" style="padding-left: 0.3rem;">Register</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
