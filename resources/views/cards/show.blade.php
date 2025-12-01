@extends('layouts.app')

@section('title', $card->title)

@section('content')
    <div class="Form shadow-lg mx-auto" style="max-width: 900px;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"
                data-bs-toggle="popover"
                data-bs-placement="top"
                data-bs-trigger="hover focus"
                data-bs-title="{{'Интересный факт'}}"
                data-bs-content="{{ $card->fun_fact_content ?? 'Нет дополнительной информации' }}"
                style="cursor: pointer; color: #432818;">
                {{ $card->title }}
            </h4>
            <span class="badge bg-secondary">{{ $card->category }}</span>
        </div>

        <div class="Form-body">
            <div class="row">
                <div class="col-md-5 mb-3 mb-md-0">
                    <img src="{{ $card->image_url }}" class="img-fluid rounded-3 shadow" alt="{{ $card->title }}">
                </div>
                <div class="col-md-7">
                    <p class="lead">{{ $card->description }}</p>

                    <hr>

                    @if($card->isMovie())
                        <div class="details-section">
                            @if($card->director)
                                <p><strong>Режиссер:</strong> {{ $card->director }}</p>
                            @endif
                            @if($card->release_year)
                                <p><strong>Год выпуска:</strong> {{ $card->release_year }}</p>
                            @endif
                            @if($card->genre)
                                <p><strong>Жанр:</strong> {{ $card->genre }}</p>
                            @endif
                            @if($card->imdb_rating)
                                <p>
                                    <strong>Рейтинг
                                        <span data-bs-toggle="tooltip"
                                              data-bs-placement="top"
                                              title="Крупнейшая онлайн-база данных о кино">IMDb</span>:
                                    </strong>
                                    {{ $card->imdb_rating_display }}
                                </p>
                            @endif
                        </div>
                    @else
                        <div class="details-section">
                            @if($card->award_category)
                                <p><strong>Категория:</strong> {{ $card->award_category }}</p>
                            @endif
                            @if($card->ceremony_date)
                                <p><strong>Дата церемонии:</strong> {{ $card->ceremony_date_formatted }}</p>
                            @endif
                        </div>
                    @endif

                    <hr>

                    <div class="additional-details">
                        {!! nl2br(e($card->details)) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('cards.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> Назад
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('cards.edit', $card) }}" class="btn btn-primary">
                    <i class="fa-solid fa-pen me-1"></i> Редактировать
                </a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fa-solid fa-trash me-1"></i> Удалить
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Подтверждение удаления</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Вы уверены, что хотите удалить "{{ $card->title }}"?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <form action="{{ route('cards.destroy', $card) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Инициализация tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(el) {
                return new bootstrap.Tooltip(el);
            });

            // Инициализация popovers
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            popoverTriggerList.map(function(el) {
                return new bootstrap.Popover(el);
            });
        });
    </script>
@endpush
