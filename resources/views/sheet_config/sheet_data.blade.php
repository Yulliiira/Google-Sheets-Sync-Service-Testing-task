<!DOCTYPE html>
<html>
<head>
    <title>Данные из Google Sheets</title>
</head>
<body>
<h1>Данные из таблицы</h1>
<table border="1" cellpadding="5">
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Comment</th>
    </tr>
    </thead>
    <tbody>
    @forelse($rows as $row)
        <tr>
            @foreach($row as $cell)
                <td>{{ $cell }}</td>
            @endforeach
        </tr>
    @empty
        <tr>
            <td colspan="6">Нет данных</td>
        </tr>
    @endforelse
    </tbody>
</table>
</body>
</html>