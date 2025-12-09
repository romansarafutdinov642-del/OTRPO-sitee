@extends('layouts.app')

@section('title', $card->title . ' - Детали автомобиля')

@section('content')
    <!-- ДЕТАЛЬНАЯ КАРТОЧКА -->
    <div class="card shadow-lg">
        <div class="row g-0">
            <div class="col-lg-6">
                <div class="position-relative">
                    @if($card->image_path && file_exists(public_path($card->image_path)))
                        <img src="{{ asset($card->image_path) }}" 
                             class="img-fluid w-100" 
                             alt="{{ $card->title }}"
                             style="height: 500px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 500px;">
                            <i class="fas fa-car fa-5x text-muted"></i>
                        </div>
                    @endif
                    
                    <!-- БЕЙДЖ -->
                    <span class="position-absolute top-0 end-0 m-3 badge bg-primary fs-6">
                        <i class="fas fa-tag me-1"></i>{{ $card->category_name ?? $card->category }}
                    </span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-4">
                    <!-- НАЗВАНИЕ МАШИНЫ -->
                    <h1 class="display-5 fw-bold mb-2">{{ $card->title }}</h1>
                    <h3 class="text-muted mb-4">{{ $card->brand }} {{ $card->model }} ({{ $card->year }})</h3>

                    <!-- СПЕЦИФИКАЦИИ -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded">
                                <div class="text-muted small">Год выпуска</div>
                                <div class="fw-bold fs-5">{{ $card->year }} г.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded">
                                <div class="text-muted small">Мощность</div>
                                <div class="fw-bold fs-5">{{ $card->horsepower }} л.с.</div>
                            </div>
                        </div>
                        @if($card->price)
                        <div class="col-md-12">
                            <div class="bg-primary text-white p-3 rounded">
                                <div class="small">Стоимость</div>
                                <div class="fw-bold fs-4">{{ $card->formatted_price ?? '$' . number_format($card->price, 0, '.', ' ') }}</div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- ИНТЕРЕСНЫЙ ФАКТ И ОПИСАНИЕ В РАМКЕ -->
                    <div class="border rounded p-4 mb-4">
                        <!-- ИНТЕРЕСНЫЙ ФАКТ -->
                        @if($card->fun_fact_content)
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-lightbulb text-warning me-2"></i>
                                <h5 class="mb-0 fw-bold">Интересный факт</h5>
                            </div>
                            <p class="mb-0">{{ $card->fun_fact_content }}</p>
                        </div>
                        @endif
                        
                        <!-- ОПИСАНИЕ -->
                        @if($card->description)
                        <div>
                            <h5 class="mb-2 fw-bold">Описание</h5>
                            <p class="mb-0">{{ $card->description }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- КНОПКИ ДЕЙСТВИЙ -->
                    <div class="d-flex flex-wrap gap-2 mt-4 pt-4 border-top">
                        <a href="{{ route('cards.edit', $card) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Редактировать
                        </a>
                        
                        <!-- ТОЛЬКО УДАЛЕНИЕ - ВОССТАНОВЛЕНИЯ НЕТ -->
                        <form action="{{ route('cards.destroy', $card) }}" method="POST" class="d-inline" 
                              data-confirm="Вы уверены, что хотите удалить эту машину навсегда?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i> Удалить
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection