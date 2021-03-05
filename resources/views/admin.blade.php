@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Add Holiday Card -->
            <div class="card">
                <div class="card-header">{{ __('Add new Holiday') }}</div>
                <div class="card-body">
                    <form action="{{ route('add_holiday') }}" id="add_holiday" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="date">Select Date</label>
                            <input type="date" class="form-control" id="date" name="date" placeholder="Enter date" required>
                        </div>
                        <div class="form-group">
                            <label for="text">Holiday Name</label>
                            <input type="text" class="form-control" id="text" name="text" placeholder="Enter holiday name" required>
                        </div>
                      <button type="submit" class="btn btn-primary">Add Holiday</button>
                    </form>
                </div>
            </div>
            <!-- End Add Holiday Card -->
            <!-- Holidays List Card -->
            <div class="card">
                <div class="card-header">{{ __('Holidays List') }}</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                              <th scope="col">Date</th>
                              <th scope="col">Name</th>
                              <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->text }}</td>
                                <td>
                                    <a href="{{ route('remove_holiday', $item->id) }}" class="close" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </a>
                                </td> 
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Holidays List Card -->
        </div>
    </div>
</div>
@endsection
