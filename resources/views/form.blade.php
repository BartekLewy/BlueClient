@extends('blue::layout')

@section('content')
    <form class="form" action="{{route('panel-item-save')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="item-name">Name</label>
            <input id="item-name" type="text" class="form-control" placeholder="Name" required>
        </div>
        <div class="form-group">
            <label for="item-amount">Amount</label>
            <input id="item-amount" type="number" class="form-control" placeholder="Amount" required>
        </div>
        <div class="form-group">
            <button class="btn btn-success">Create</button>
        </div>
    </form>
@endsection