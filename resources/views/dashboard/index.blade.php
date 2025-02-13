@extends('layouts.vertical', ['title' => 'Dashboard'])

@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-sm-center flex-sm-row flex-column py-3">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
            </div>
        </div>

        <!-- start row -->
        <div class="row">
            <div class="col-md-12 col-xl-7">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center mb-4">
                            <h5 class="card-title mb-3 text-black">Register a new domain</h5>

                            @if (session('error'))
                                {{-- Check for session error message --}}
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            @if (session('success'))
                                {{-- Check for session success message --}}
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <div>
                                <form action="{{ route('domains') }}" method="GET">
                                    <input type="text" class="form-control mb-2" name="domain" id="domain"
                                        aria-describedby="helpId" placeholder="google.com,google.org,google.page"
                                        value="{{ $domainInput ?? '' }}" />
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    @endsection
