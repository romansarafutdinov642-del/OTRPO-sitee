<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::all();
        return view('cards.index', compact('cards'));
    }

    public function create()
    {
        return view('cards.form', [
            'card' => new Card(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateCard($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $this->handleImageUpload($request->file('image'));
        }

        Card::create($validated);

        return redirect()->route('cards.index')
            ->with('success', 'Карточка успешно создана!');
    }

    public function show(Card $card)
    {
        return view('cards.show', compact('card'));
    }

    public function edit(Card $card)
    {
        return view('cards.form', [
            'card' => $card,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Card $card)
    {
        $validated = $this->validateCard($request, $card->id);

        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($card->image_path) {
                Storage::disk('public')->delete($card->image_path);
            }
            $validated['image_path'] = $this->handleImageUpload($request->file('image'));
        }

        $card->update($validated);

        return redirect()->route('cards.index')
            ->with('success', 'Карточка успешно обновлена!');
    }

    public function destroy(Card $card)
    {
        $card->delete();

        return redirect()->route('cards.index')
            ->with('success', 'Карточка успешно удалена!');
    }

    public function restore($id)
    {
        $card = Card::withTrashed()->findOrFail($id);
        $card->restore();

        return redirect()->route('cards.index')
            ->with('success', 'Карточка восстановлена!');
    }

    public function forceDelete($id)
    {
        $card = Card::withTrashed()->findOrFail($id);

        if ($card->image_path) {
            Storage::disk('public')->delete($card->image_path);
        }

        $card->forceDelete();

        return redirect()->route('cards.index')
            ->with('success', 'Карточка полностью удалена!');
    }

    private function validateCard(Request $request, ?int $cardId = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Фильмы,Награды',
            'description' => 'required|string|max:1000',
            'details' => 'required|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'fun_fact_content' => 'nullable|string|max:500',
            'director' => 'nullable|string|max:255',
            'release_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'genre' => 'nullable|string|max:255',
            'imdb_rating' => 'nullable|numeric|min:0|max:10',
            'ceremony_date' => 'nullable|date',
            'award_category' => 'nullable|string|max:255',
        ], [
            'title.required' => 'Название обязательно для заполнения',
            'category.required' => 'Выберите категорию',
            'category.in' => 'Недопустимая категория',
            'description.required' => 'Описание обязательно',
            'details.required' => 'Детали обязательны',
            'image.image' => 'Файл должен быть изображением',
            'image.max' => 'Размер изображения не более 5MB',
            'release_year.min' => 'Год выпуска не может быть раньше 1900',
            'imdb_rating.max' => 'Рейтинг IMDb не может быть больше 10',
        ]);
    }

    private function handleImageUpload($file): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = 'images/cards/' . $filename;

        $image = Image::read($file);
        $image->cover(400, 600); // Размер под карточку

        Storage::disk('public')->put($path, $image->toJpeg(85));

        return $path;
    }
}
