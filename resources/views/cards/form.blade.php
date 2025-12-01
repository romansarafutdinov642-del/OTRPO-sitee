@extends('layouts.app')

@section('title', $isEdit ? 'Редактирование: ' . $card->title : 'Создание карточки')

@section('content')
    <div class="Form shadow-lg mx-auto" style="max-width: 800px;">
        <div class="card-header">
            <h4 class="mb-0">{{ $isEdit ? 'Редактирование карточки' : 'Новая карточка' }}</h4>
        </div>

        <div class="card-body">
            <form action="{{ $isEdit ? route('cards.update', $card) : route('cards.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="cardForm">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="title" class="form-label">Название *</label>
                        <input type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               id="title"
                               name="title"
                               value="{{ old('title', $card->title) }}"
                               required
                               minlength="2"
                               maxlength="255">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="category" class="form-label">Категория *</label>
                        <select class="form-select @error('category') is-invalid @enderror"
                                id="category"
                                name="category"
                                required>
                            <option value="">Выберите...</option>
                            <option value="Фильмы" {{ old('category', $card->category) == 'Фильмы' ? 'selected' : '' }}>Фильмы</option>
                            <option value="Награды" {{ old('category', $card->category) == 'Награды' ? 'selected' : '' }}>Награды</option>
                        </select>
                        @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Краткое описание *</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description"
                              name="description"
                              rows="3"
                              required
                              minlength="10"
                              maxlength="1000">{{ old('description', $card->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="details" class="form-label">Подробное описание *</label>
                    <textarea class="form-control @error('details') is-invalid @enderror"
                              id="details"
                              name="details"
                              rows="5"
                              required
                              minlength="10"
                              maxlength="2000">{{ old('details', $card->details) }}</textarea>
                    @error('details')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Изображение</label>
                    @if($isEdit && $card->image_path)
                        <div class="mb-2">
                            <img src="{{ $card->image_url }}" alt="Текущее изображение" class="img-thumbnail" style="max-height: 150px;">
                            <small class="d-block text-muted">Текущее изображение</small>
                        </div>
                    @endif
                    <input type="file"
                           class="form-control @error('image') is-invalid @enderror"
                           id="image"
                           name="image"
                           accept="image/jpeg,image/png,image/jpg,image/webp">
                    <small class="text-muted">Форматы: JPEG, PNG, WebP. Макс. размер: 5MB</small>
                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="fun_fact_content" class="form-label">Текст интересного факта</label>
                        <input type="text"
                               class="form-control @error('fun_fact_content') is-invalid @enderror"
                               id="fun_fact_content"
                               name="fun_fact_content"
                               value="{{ old('fun_fact_content', $card->fun_fact_content) }}"
                               maxlength="350">
                    </div>
                </div>

                <div id="movieFields" class="movie-fields" style="display: none;">
                    <h5 class="border-bottom pb-2 mb-3">Информация о фильме</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="director" class="form-label">Режиссёр</label>
                            <input type="text"
                                   class="form-control @error('director') is-invalid @enderror"
                                   id="director"
                                   name="director"
                                   value="{{ old('director', $card->director) }}"
                                   maxlength="255">
                        </div>
                        <div class="col-md-3">
                            <label for="release_year" class="form-label">Год выпуска</label>
                            <input type="number"
                                   class="form-control @error('release_year') is-invalid @enderror"
                                   id="release_year"
                                   name="release_year"
                                   value="{{ old('release_year', $card->release_year) }}"
                                   min="1900"
                                   max="{{ date('Y') + 5 }}">
                        </div>
                        <div class="col-md-3">
                            <label for="imdb_rating" class="form-label">Рейтинг IMDb</label>
                            <input type="number"
                                   class="form-control @error('imdb_rating') is-invalid @enderror"
                                   id="imdb_rating"
                                   name="imdb_rating"
                                   value="{{ old('imdb_rating', $card->imdb_rating) }}"
                                   min="0"
                                   max="10"
                                   step="0.1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="genre" class="form-label">Жанр</label>
                        <input type="text"
                               class="form-control @error('genre') is-invalid @enderror"
                               id="genre"
                               name="genre"
                               value="{{ old('genre', $card->genre) }}"
                               maxlength="255"
                               placeholder="Например: Хоррор, Драма">
                    </div>
                </div>

                <div id="awardFields" class="award-fields" style="display: none;">
                    <h5 class="border-bottom pb-2 mb-3">Информация о награде</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="award_category" class="form-label">Категория награды</label>
                            <input type="text"
                                   class="form-control @error('award_category') is-invalid @enderror"
                                   id="award_category"
                                   name="award_category"
                                   value="{{ old('award_category', $card->award_category) }}"
                                   maxlength="255"
                                   placeholder="Например: Лучшая мужская роль">
                        </div>
                        <div class="col-md-6">
                            <label for="ceremony_date" class="form-label">Дата церемонии</label>
                            <input type="date"
                                   class="form-control @error('ceremony_date') is-invalid @enderror"
                                   id="ceremony_date"
                                   name="ceremony_date"
                                   value="{{ old('ceremony_date', $card->ceremony_date?->format('Y-m-d')) }}">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('cards.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i> Отмена
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-save me-1"></i> {{ $isEdit ? 'Сохранить' : 'Создать' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category');
            const movieFields = document.getElementById('movieFields');
            const awardFields = document.getElementById('awardFields');

            function toggleFields() {
                const category = categorySelect.value;
                movieFields.style.display = category === 'Фильмы' ? 'block' : 'none';
                awardFields.style.display = category === 'Награды' ? 'block' : 'none';
            }

            categorySelect.addEventListener('change', toggleFields);
            toggleFields();

            const form = document.getElementById('cardForm');
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
    </script>
@endpush
