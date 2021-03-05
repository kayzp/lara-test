@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Date Checker') }}</div>
                <div class="card-body">
                    <form action="{{ route('check_holiday') }}" id="check_date_form" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="date">Select date</label>
                            <input type="date" class="form-control" id="date" name="date" placeholder="Enter date" required>
                        </div>
                      <button type="submit" class="btn btn-primary">Check date</button>
                    </form>
                </div>
            </div>

            @if (session('holiday_result'))
                <div class="card">
                    <div class="card-header">{{ __('Search Result') }}</div>
                    <div class="card-body">
                        <h3>{{ session('holiday_result') }}</h3>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
