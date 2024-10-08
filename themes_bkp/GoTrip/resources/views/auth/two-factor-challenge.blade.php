@extends('layouts.app')
@section('content')
    <div class="layout-pt-lg layout-pb-lg bg-blue-2 header-margin">
        <div class="container">
        <div class="row justify-content-center bravo-login-form-page bravo-login-page">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-green-1 text-white rounded">{{ __('Two Factor Authentication') }}</div>
                    <div class="card-body">

                        @include('Layout::admin.message')

                        <form method="POST" action="{{ url('two-factor-challenge') }}">
                        @csrf
                        @switch(request('type'))
                            @case("recovery_code")
                                <div class="mb-4 text-sm text-gray-600">
                                    {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                                </div>
                                <!-- Password -->
                                <div class="form-group row mb-15 mt-10">
                                    <label for="recovery_code" class="col-md-4 col-form-label text-md-right">{{ __('Recovery Code') }}</label>
                                    <div class="col-md-6">
                                        <input id="recovery_code" type="text" class="form-control border-light {{ $errors->has('recovery_code') ? ' is-invalid' : '' }}" name="recovery_code"  required>
                                        @if ($errors->has('recovery_code'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('recovery_code') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @break
                            @default
                                <div class="mb-4 text-sm text-gray-600">
                                    {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                                </div>
                                <!-- Password -->
                                <div class="form-group row mb-15 mt-10">
                                    <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Code') }}</label>
                                    <div class="col-md-6">
                                        <input id="code" type="text" class="form-control border-light {{ $errors->has('code') ? ' is-invalid' : '' }}" name="code"  required>
                                        @if ($errors->has('code'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('code') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @break
                        @endswitch
                            <div class="flex justify-end mt-4">
                                <div class="form-group row mb-0">
                                    <div class="offset-md-4">
                                        @if(request('type') == 'recovery_code')
                                            <a href="{{route('two-factor.login')}}" class="button px-10 py-10 -dark-1 bg-light-1 text-white d-inline-flex form-submit mr-10">{{__('Use an authentication code')}}</a>
                                        @else
                                            <a href="{{route('two-factor.login',['type'=>'recovery_code'])}}" class="button px-10 py-10 -dark-1 bg-light-1 text-white d-inline-flex form-submit mr-10">{{__('Use a recovery code')}}</a>
                                        @endif
                                        <button type="submit" class="button px-10 py-10 -dark-1 bg-blue-1 text-white d-inline-flex form-submit mr-10">
                                            {{ __('Submit') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
