@extends('layouts.vertical', ['title' => 'Domains'])

@section('content')

<div class="container-fluid">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Domains</h4>
        </div>
    </div>

    <!-- start row -->
    <div class="row">
        <div class="col-md-12 col-xl-7">
            <div class="card">
                <div class="card-header">
                    <div class="row mb-4 align-items-center">
                        <h1>Domain Check Results</h1>

                        @if (isset($error))
                        <div class="alert alert-danger">{{ $error }}</div>
                        @endif

                        <ul>
                            @foreach ($domains as $domain)
                            <li>{{ $domain['domain'] }}: {{ $domain['available'] ? 'Available' : 'Unavailable' }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->

    @endsection