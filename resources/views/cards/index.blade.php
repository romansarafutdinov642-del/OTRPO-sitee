@extends('layouts.app')

@section('title', 'Джек Николсон - Фильмы и награды')

@section('content')
    <h1>Джек Николсон</h1>

    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-4 row-cols-xxxl-5 justify-content-center g-3">
        @forelse($cards as $index => $card)
            <div class="col">
                <div class="card h-100 shadow-sm rounded-3" data-index="{{ $index }}">
                    <a href="{{ route('cards.show', $card) }}" class="text-decoration-none">
                        <div class="position-relative">
                            <img src="{{ $card->image_url }}" class="img-fluid rounded-3" alt="{{ $card->title }}">
                            <span class="badge">{{ $card->category }}</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $card->title }}</h5>
                            <p class="card-text">{{ Str::limit($card->description, 200) }}</p>
                        </div>
                    </a>
                    <div class="card-footer bg-transparent border-0 d-flex justify-content-end gap-2 mt-auto">
                        <a href="{{ route('cards.edit', $card) }}" class="btn btn-sm btn-outline-primary" title="Редактировать">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $card->id }}"
                                title="Удалить">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal{{ $card->id }}" tabindex="-1">
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
                            <form action="{{ route('cards.destroy', $card) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-light">Карточки не найдены. <a href="{{ route('cards.create') }}">Добавить первую</a></p>
            </div>
        @endforelse
    </div>
@endsection
