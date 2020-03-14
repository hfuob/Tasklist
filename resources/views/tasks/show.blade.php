@extends('layouts.app')

@section('content')
@section('status')

<!-- ここにページ毎のコンテンツを書く -->
    <h1>id = {{ $task->id }} のタスク詳細ページ</h1>
    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>タスク</th>
            <th>ステータス</th>
        </tr>
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->content }}</td>
            <td>{{ $task->status }}</td>
        </tr>
    </table>
    
    {!! link_to_route('tasks.edit', 'このタスクを編集', ['id' => $task->id], ['class' => 'btn btn-light']) !!}

    {!! Form::model($task, ['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
        {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}  
@endsection