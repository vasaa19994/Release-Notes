<!-- resources/views/release_form.blade.php -->
<form action="{{ isset($release) ? route('releases.update', $release->id) : route('releases.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($release))
        @method('PUT')
    @endif

    <div>
        <label for="name">Назва релізу:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $release->name ?? '') }}" required>
    </div>

    <div>
        <label for="description">Опис:</label>
        <textarea id="description" name="description" required>{{ old('description', $release->description ?? '') }}</textarea>
    </div>

    <div>
        <label for="main_text">Основний текст:</label>
        <textarea id="main_text" name="main_text" required>{{ old('main_text', $release->main_text ?? '') }}</textarea>
    </div>

    <div>
        <label for="version">Версія релізу:</label>
        <input type="text" id="version" name="version" value="{{ old('version', $release->version ?? '') }}" pattern="\d{1,2}\.\d{1,2}" title="Формат від 1.01 до 100.00" required>
    </div>

    <div>
        <label for="release_date">Дата релізу:</label>
        <input type="date" id="release_date" name="release_date" value="{{ old('release_date', $release->release_date ?? '') }}" required>
    </div>

    <div>
        <label for="media">Відео або зображення:</label>
        <input type="file" id="media" name="media">
        @if(isset($release) && $release->media)
            <p>Завантажений файл: {{ $release->media }}</p>
        @endif
    </div>

    <div>
        <label for="link">Посилання на реліз:</label>
        <input type="url" id="link" name="link" value="{{ old('link', $release->link ?? '') }}">
    </div>

    <div>
        <label for="is_protected">Приватний реліз:</label>
        <input type="checkbox" id="is_protected" name="is_protected" {{ old('is_protected', $release->is_protected ?? false) ? 'checked' : '' }}>
    </div>

    <div>
        <label for="project_id">Прив’язка до проекту:</label>
        <select id="project_id" name="project_id" required>
            @foreach($projects as $project)
                <option value="{{ $project->id }}" {{ (old('project_id') == $project->id || (isset($release) && $release->project_id == $project->id)) ? 'selected' : '' }}>
                    {{ $project->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="users">Відповідальні особи:</label>
        <select id="users" name="users[]" multiple required>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ (old('users') && in_array($user->id, old('users', []))) || (isset($release) && $release->users->contains($user->id)) ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <button type="submit">{{ isset($release) ? 'Оновити реліз' : 'Додати реліз' }}</button>
    </div>
</form>
