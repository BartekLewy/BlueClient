@extends('blue::layout')

@section('content')


    <form class="form" action="{{route('panel-item-save')}}" method="post">
        @csrf

        @if(isset($item))
            <input type="hidden" name="id" value="{{$item['id']}}">
        @endif
        <div class="form-group">
            <label for="item-name">Name</label>
            <input
                    id="item-name"
                    name="name"
                    type="text"
                    class="form-control"
                    placeholder="Name"
                    @if(isset($item)) value="{{$item['name']}}" @endif
                    required>
        </div>
        <div class="form-group">
            <label for="item-amount">Amount</label>
            <input
                    id="item-amount"
                    name="amount"
                    type="number"
                    class="form-control"
                    placeholder="Amount"
                    @if(isset($item)) value="{{$item['amount']}}" @endif
                    required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Create</button>
        </div>
    </form>
@endsection