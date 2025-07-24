<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <h1 class="mb-4">Records</h1>

    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('records.create') }}" class="btn btn-primary">Добавить запись</a>

        <form action="{{ route('records.generate') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success">Сгенерировать 1000 строк</button>
        </form>

        <form action="{{ route('records.clear') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Вы уверены, что хотите очистить всю таблицу?');">
                Очистить таблицу
            </button>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @forelse($records as $record)
            <tr>
                <td>{{ $record->id }}</td>
                <td>{{ $record->title }}</td>
                <td>{{ $record->content }}</td>
                <td>
                    @if($record->status === 'Allowed')
                        <span class="badge bg-success">Allowed</span>
                    @else
                        <span class="badge bg-secondary">Prohibited</span>
                    @endif
                </td>
                <td>{{ $record->created_at->format('Y-m-d H:i') }}</td>
                <td class="d-flex gap-2">
                    <a href="{{ route('records.edit', $record) }}" class="btn btn-sm btn-warning">Редактировать</a>

                    <form action="{{ route('records.destroy', $record) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Удалить эту запись?');">
                            Удалить
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">Нет записей</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
