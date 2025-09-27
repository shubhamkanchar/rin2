@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Users</div>
            <div class="card-body">
                <form method="POST" action="{{ route('notifications.send') }}" class="mb-5">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" name="type" required>
                                <option value="marketing">Marketing</option>
                                <option value="invoices">Invoices</option>
                                <option value="system">System</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="text" class="form-label">Message</label>
                            <input type="text" class="form-control" name="text" required>
                        </div>

                        <div class="col-md-3">
                            <label for="expires_at" class="form-label">Expires At</label>
                            <input type="datetime-local" class="form-control" name="expires_at">
                        </div>

                        <div class="col-md-6">
                            <label for="user_id" class="form-label">Send To</label>
                            <select class="form-select" name="user_id">
                                <option value="">All Users</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Send Notification</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
