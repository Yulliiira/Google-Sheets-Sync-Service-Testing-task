<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Создать запись</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container py-4">
    <h1>Создать новую запись</h1>

    <form action="{{ route('records.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title') }}"
                required
            >
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Контент</label>
            <textarea
                id="content"
                name="content"
                class="form-control @error('content') is-invalid @enderror"
                rows="4"
                required
            >{{ old('content') }}</textarea>
            @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Статус</label>
            <select
                id="status"
                name="status"
                class="form-select @error('status') is-invalid @enderror"
                required
            >
                <option value="">-- Выберите статус --</option>
                <option value="Allowed" {{ old('status') === 'Allowed' ? 'selected' : '' }}>Allowed</option>
                <option value="Prohibited" {{ old('status') === 'Prohibited' ? 'selected' : '' }}>Prohibited</option>
            </select>
            @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Создать запись</button>
        <a href="{{ route('records.index') }}" class="btn btn-secondary">Отмена</a>
    </form>

</div>
</body>
</html>
