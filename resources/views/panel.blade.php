@extends('blue::layout')
@section('content')
    <div style="margin-bottom: 10px;">
        <form class="form form-inline row" action="{{route('panel')}}" method="GET">
            @csrf
            <div class="col-3">
                <label for="out-of-stock">
                    Out of stock
                    <input name="out_of_stock" id="out-of-stock" type="checkbox" class="form-control" @if(isset($outOfStockCheck) && $outOfStockCheck == true) checked @endif>
                </label>
            </div>
            <div class="col-3">
                <label for="in-stock">
                    In stock
                    <input name="in_stock" id="in-stock" type="checkbox" class="form-control" @if(isset($inStockCheck) && $inStockCheck == true) checked @endif>
                </label>
            </div>
            <div class="col-3">
                <label for="more-than-five">
                    More than five
                    <input name="more_than_five" id="more-than-five" type="checkbox" class="form-control" @if(isset($moreThanFiveCheck) && $moreThanFiveCheck == true) checked @endif>
                </label>
            </div>
            <div class="col-1">
                <button class="btn btn-sm btn-success" type="submit">Filter it!</button>
            </div>
        </form>
    </div>

    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Amount</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @if(count($result) > 0)
            @foreach($result as $item)
                <tr>
                    <td>{{$item['id']}}</td>
                    <td>{{$item['name']}}</td>
                    <td class="text-right">{{$item['amount']}}</td>
                    <td class="text-right">
                        <a href="{{route('panel-item-edit', ['id' => $item['id']])}}"
                           class="btn btn-sm btn-primary">Edit</a>
                        <a href="{{route('panel-item-remove', ['id' => $item['id']])}}"
                           class="btn btn-sm btn-danger">Remove
                        </a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4" class="text-center">
                    List of items is empty
                </td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection