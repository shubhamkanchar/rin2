@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Setting') }}</div>

                    <div class="card-body">
                        <form id="notificationForm" method="POST" action="{{ route('update.setting') }}">
                            @csrf
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="onScreen" name="is_notification" {{auth()->user()->is_notification ? 'checked': ''}}>
                                <label class="form-check-label" for="onScreen">Enable Notifications</label>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required
                                    placeholder="you@example.com" value="{{auth()->user()->email}}">
                                @error('email')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    placeholder="+1234567890" value="{{auth()->user()->phone ?? ''}}">
                                @error('phone')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Update Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
