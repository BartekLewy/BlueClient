@extends('blue::layout')
@section('content')
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
            @if(count($items) > 0)
                @foreach($items as $item)
                    <tr>
                        <td>{{$item['id']}}</td>
                        <td>{{$item['name']}}</td>
                        <td class="text-right">{{$item['amount']}}</td>
                        <td class="text-right">
                            <a href="#" class="btn btn-sm btn-primary">Edit</a>
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