@extends('layouts.vertical', ['title' => 'Dashboard'])

@section('content')

<div class="container-fluid">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
        </div>
    </div>

    <!-- start row -->
    <div class="row">
        <div class="col-md-12 col-xl-7">
            <div class="card">
                <div class="card-header">
                    <div class="row mb-4 align-items-center">
                        <h5 class="card-title text-black mb-3">Register a new domain</h5>

                        <div>
                            <input
                                type="text"
                                class="form-control mb-2"
                                name="domain"
                                id="domain"
                                aria-describedby="helpId"
                                placeholder="google.com" />
                        </div>

                        <div>
                            <form action="{{ route('domains') }}" method="GET"> <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->

    @endsection