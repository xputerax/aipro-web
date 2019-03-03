@extends('backend-layout')

@section('title', 'Branch List')

@section('content-1')
<div class="x_panel">
    <table class="table table-bordered table-striped" id="branches_table">
        <thead>
            <tr>
                <th>Name</th>
            </tr>
        </thead>

        <tbody>
        @if($branches->count())
            @foreach($branches as $branch)
            <tr>
                <td>
                    <a href="{{ route('branches.show', compact('branch')) }}">
                        {{ $branch->name }}
                    </a>
                </td>
            </tr>
            @endforeach
        @else
            <tr>
                <td>No Data</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
@endsection