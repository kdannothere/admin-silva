@extends('layouts.vertical', ['title' => 'Register a Domain'])

@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-sm-center flex-sm-row flex-column py-3">
            <div class="flex-grow-1">
                <h1 class="fs-18 fw-semibold m-0">Register a Domain</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-xl-7">
                <div class="card">
                    <div class="card-header">

                        @if (session('error'))
                            {{-- Check for session error message --}}
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('domain.register') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="domain" class="form-label">Domain Name</label>
                                <input type="text" class="form-control" id="domain" name="domain"
                                    placeholder="example.com" value="{{ $domain }}" required>
                                @error('domain')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="years" class="form-label">Registration Years</label>
                                <input type="number" class="form-control" id="years" name="years"
                                    value="{{ old('years', '1') }}" min="1" required>
                                @error('years')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nameservers" class="form-label">Nameservers (comma-separated)</label>
                                <input type="text" class="form-control" id="nameservers" name="nameservers"
                                    placeholder="ns1.example.com,ns2.example.com (optional)"
                                    value="{{ old('nameservers') }}">
                                @error('nameservers')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label h5 my-3">Registrant Contact</label>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="RegistrantFirstName"
                                            placeholder="First Name" required value="{{ old('RegistrantFirstName') }}">
                                        @error('RegistrantFirstName')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="RegistrantLastName"
                                            placeholder="Last Name" required value="{{ old('RegistrantLastName') }}">
                                        @error('RegistrantLastName')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="RegistrantOrganizationName"
                                            placeholder="Organization (optional)"
                                            value="{{ old('RegistrantOrganizationName') }}">
                                        @error('RegistrantOrganizationName')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="RegistrantEmailAddress"
                                            placeholder="Email" required value="{{ old('RegistrantEmailAddress') }}">
                                        @error('RegistrantEmailAddress')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="RegistrantAddress1"
                                            placeholder="Address 1" required value="{{ old('RegistrantAddress1') }}">
                                        @error('RegistrantAddress1')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="RegistrantAddress2"
                                            placeholder="Address 2 (optional)" value="{{ old('RegistrantAddress2') }}">
                                        @error('RegistrantAddress2')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" class="form-control" name="RegistrantCity" placeholder="City"
                                            required value="{{ old('RegistrantCity') }}">
                                        @error('RegistrantCity')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" class="form-control" name="RegistrantStateProvince"
                                            placeholder="State/Province" required
                                            value="{{ old('RegistrantStateProvince') }}">
                                        @error('RegistrantStateProvince')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" class="form-control" name="RegistrantPostalCode"
                                            placeholder="Postal Code" required value="{{ old('RegistrantPostalCode') }}">
                                        @error('RegistrantPostalCode')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="RegistrantCountry"
                                            placeholder="Country (2-letter code)" required
                                            value="{{ old('RegistrantCountry') }}">
                                        @error('RegistrantCountry')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="RegistrantPhone"
                                            placeholder="Phone (+NNN.NNNNNNNNNN)" required
                                            value="{{ old('RegistrantPhone') }}">
                                        @error('RegistrantPhone')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <label class="form-label h5 my-3">Tech Contact</label>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="TechFirstName"
                                            placeholder="First Name" required value="{{ old('TechFirstName') }}">
                                        @error('TechFirstName')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="TechLastName"
                                            placeholder="Last Name" required value="{{ old('TechLastName') }}">
                                        @error('TechLastName')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="TechOrganizationName"
                                            placeholder="Organization (optional)"
                                            value="{{ old('TechOrganizationName') }}">
                                        @error('TechOrganizationName')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="TechEmailAddress"
                                            placeholder="Email" required value="{{ old('TechEmailAddress') }}">
                                        @error('TechEmailAddress')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="TechAddress1"
                                            placeholder="Address 1" required value="{{ old('TechAddress1') }}">
                                        @error('TechAddress1')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="TechAddress2"
                                            placeholder="Address 2 (optional)" value="{{ old('TechAddress2') }}">
                                        @error('TechAddress2')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" class="form-control" name="TechCity" placeholder="City"
                                            required value="{{ old('TechCity') }}">
                                        @error('TechCity')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" class="form-control" name="TechStateProvince"
                                            placeholder="State/Province" required value="{{ old('TechStateProvince') }}">
                                        @error('TechStateProvince')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" class="form-control" name="TechPostalCode"
                                            placeholder="Postal Code" required value="{{ old('TechPostalCode') }}">
                                        @error('TechPostalCode')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="TechCountry"
                                            placeholder="Country (2-letter code)" required
                                            value="{{ old('TechCountry') }}">
                                        @error('TechCountry')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="TechPhone"
                                            placeholder="Phone (+NNN.NNNNNNNNNN)" required
                                            value="{{ old('TechPhone') }}">
                                        @error('TechPhone')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <label class="form-label h5 my-3">Admin Contact</label>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="AdminFirstName"
                                            placeholder="First Name" required value="{{ old('AdminFirstName') }}">
                                        @error('AdminFirstName')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="AdminLastName"
                                            placeholder="Last Name" required value="{{ old('AdminLastName') }}">
                                        @error('AdminLastName')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="AdminOrganizationName"
                                            placeholder="Organization (optional)"
                                            value="{{ old('AdminOrganizationName') }}">
                                        @error('AdminOrganizationName')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="AdminEmailAddress"
                                            placeholder="Email" required value="{{ old('AdminEmailAddress') }}">
                                        @error('AdminEmailAddress')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="AdminAddress1"
                                            placeholder="Address 1" required value="{{ old('AdminAddress1') }}">
                                        @error('AdminAddress1')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="AdminAddress2"
                                            placeholder="Address 2 (optional)" value="{{ old('AdminAddress2') }}">
                                        @error('AdminAddress2')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" class="form-control" name="AdminCity" placeholder="City"
                                            required value="{{ old('AdminCity') }}">
                                        @error('AdminCity')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" class="form-control" name="AdminStateProvince"
                                            placeholder="State/Province" required
                                            value="{{ old('AdminStateProvince') }}">
                                        @error('AdminStateProvince')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" class="form-control" name="AdminPostalCode"
                                            placeholder="Postal Code" required value="{{ old('AdminPostalCode') }}">
                                        @error('AdminPostalCode')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="AdminCountry"
                                            placeholder="Country (2-letter code)" required
                                            value="{{ old('AdminCountry') }}">
                                        @error('AdminCountry')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="AdminPhone"
                                            placeholder="Phone (+NNN.NNNNNNNNNN)" required
                                            value="{{ old('AdminPhone') }}">
                                        @error('AdminPhone')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <label class="form-label h5 my-3">AuxBilling Contact</label>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="AuxBillingFirstName"
                                            placeholder="First Name" required value="{{ old('AuxBillingFirstName') }}">
                                        @error('AuxBillingFirstName')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="AuxBillingLastName"
                                            placeholder="Last Name" required value="{{ old('AuxBillingLastName') }}">
                                        @error('AuxBillingLastName')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="AuxBillingOrganizationName"
                                            placeholder="Organization (optional)"
                                            value="{{ old('AuxBillingOrganizationName') }}">
                                        @error('AuxBillingOrganizationName')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control" name="AuxBillingEmailAddress"
                                            placeholder="Email" required value="{{ old('AuxBillingEmailAddress') }}">
                                        @error('AuxBillingEmailAddress')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="AuxBillingAddress1"
                                            placeholder="Address 1" required value="{{ old('AuxBillingAddress1') }}">
                                        @error('AuxBillingAddress1')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="AuxBillingAddress2"
                                            placeholder="Address 2 (optional)" value="{{ old('AuxBillingAddress2') }}">
                                        @error('AuxBillingAddress2')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" class="form-control" name="AuxBillingCity"
                                            placeholder="City" required value="{{ old('AuxBillingCity') }}">
                                        @error('AuxBillingCity')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" class="form-control" name="AuxBillingStateProvince"
                                            placeholder="State/Province" required
                                            value="{{ old('AuxBillingStateProvince') }}">
                                        @error('AuxBillingStateProvince')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" class="form-control" name="AuxBillingPostalCode"
                                            placeholder="Postal Code" required value="{{ old('AuxBillingPostalCode') }}">
                                        @error('AuxBillingPostalCode')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="AuxBillingCountry"
                                            placeholder="Country (2-letter code)" required
                                            value="{{ old('AuxBillingCountry') }}">
                                        @error('AuxBillingCountry')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" name="AuxBillingPhone"
                                            placeholder="Phone (+NNN.NNNNNNNNNN)" required
                                            value="{{ old('AuxBillingPhone') }}">
                                        @error('AuxBillingPhone')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <label class="form-label h5 my-3">Options</label>
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">Add Free Whoisguard</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="AddFreeWhoisguard"
                                                    id="AddFreeWhoisguardYes" value="yes"
                                                    {{ old('AddFreeWhoisguard') === 'yes' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="AddFreeWhoisguardYes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="AddFreeWhoisguard"
                                                    id="AddFreeWhoisguardNo" value="no"
                                                    {{ old('AddFreeWhoisguard', 'no') === 'no' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="AddFreeWhoisguardNo">No</label>
                                            </div>
                                        </div>
                                        @error('AddFreeWhoisguard')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">WG Enabled</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="WGEnabled"
                                                    id="WGEnabledYes" value="yes"
                                                    {{ old('WGEnabled') === 'yes' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="WGEnabledYes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="WGEnabled"
                                                    id="WGEnabledNo" value="no"
                                                    {{ old('WGEnabled', 'no') === 'no' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="WGEnabledNo">No</label>
                                            </div>
                                        </div>
                                        @error('WGEnabled')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Is Premium Domain?</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="IsPremiumDomain"
                                                    id="IsPremiumDomainYes" value="true"
                                                    {{ old('IsPremiumDomain') === 'true' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="IsPremiumDomainYes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="IsPremiumDomain"
                                                    id="IsPremiumDomainNo" value="false"
                                                    {{ old('IsPremiumDomain', 'false') === 'false' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="IsPremiumDomainNo">No</label>
                                            </div>
                                        </div>
                                        @error('IsPremiumDomain')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Register Domain</button>
                                {{-- The button --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
