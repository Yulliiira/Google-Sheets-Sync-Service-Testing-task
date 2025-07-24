<!DOCTYPE html>
<html>
<head>
    <title>Настройка Google Sheet</title>
</head>
<body>
<h2>Указать ссылку на Google Sheet</h2>

@if ($errors->any())
    <div style="color:red">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('sheet_config.store') }}">
    @csrf
    <label for="sheet_url">Google Sheet URL:</label>
    <input type="url" name="sheet_url" id="sheet_url" value="{{ old('sheet_url', $config->sheet_url ?? '') }}" required>
    <button type="submit">Сохранить</button>
</form>
</body>
</html>
