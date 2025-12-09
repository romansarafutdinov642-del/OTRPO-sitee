<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CardController extends Controller
{
    public function index()
    {
        try {
            $cards = Card::all();
            return view('cards.index', compact('cards'));
        } catch (\Exception $e) {
            Log::error('Index error: ' . $e->getMessage());
            return view('cards.index', ['cards' => collect()]);
        }
    }

    public function create()
    {
        return view('cards.form', [
            'card' => new Card(),
            'isEdit' => false,
            'categories' => Card::CATEGORIES,
        ]);
    }

    public function store(Request $request)
    {
        try {
            Log::info('=== STORE REQUEST ===');
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|string|in:' . implode(',', array_keys(Card::CATEGORIES)),
                'description' => 'required|string',
                'image' => 'required|image|max:51200',
                'fun_fact_content' => 'nullable|string',
                'brand' => 'required|string|max:100',
                'model' => 'required|string|max:100',
                'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
                'horsepower' => 'required|integer|min:1',
                'price' => 'nullable|numeric|min:0',
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                
                $path = public_path('images');
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true);
                }
                
                $filename = time() . '_' . $file->getClientOriginalName();
                $filename = str_replace(' ', '_', $filename);
                
                $file->move($path, $filename);
                
                $validated['image_path'] = 'images/' . $filename;
                
                Log::info('Image saved: ' . $validated['image_path']);
            }

            Card::create($validated);
            
            Log::info('Card created successfully');
            
            return redirect()->route('cards.index')
                ->with('success', 'Машина успешно добавлена!');
                
        } catch (\Exception $e) {
            Log::error('Store error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Ошибка: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $card = Card::findOrFail($id);
            return view('cards.show', compact('card'));
        } catch (\Exception $e) {
            Log::error('Show error: ' . $e->getMessage());
            return redirect()->route('cards.index')->with('error', 'Карточка не найдена');
        }
    }

    public function edit($id)
    {
        try {
            $card = Card::findOrFail($id);
            return view('cards.form', [
                'card' => $card,
                'isEdit' => true,
                'categories' => Card::CATEGORIES,
            ]);
        } catch (\Exception $e) {
            Log::error('Edit form error: ' . $e->getMessage());
            return redirect()->route('cards.index')->with('error', 'Карточка не найдена');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('=== UPDATE REQUEST ===');
            
            $card = Card::findOrFail($id);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|string|in:' . implode(',', array_keys(Card::CATEGORIES)),
                'description' => 'required|string',
                'image' => 'nullable|image|max:51200',
                'fun_fact_content' => 'nullable|string',
                'brand' => 'required|string|max:100',
                'model' => 'required|string|max:100',
                'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
                'horsepower' => 'required|integer|min:1',
                'price' => 'nullable|numeric|min:0',
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                
                if ($card->image_path && File::exists(public_path($card->image_path))) {
                    File::delete(public_path($card->image_path));
                    Log::info('Old image deleted: ' . $card->image_path);
                }
                
                $path = public_path('images');
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true);
                }
                
                $filename = time() . '_' . $file->getClientOriginalName();
                $filename = str_replace(' ', '_', $filename);
                
                $file->move($path, $filename);
                
                $validated['image_path'] = 'images/' . $filename;
                
                Log::info('New image saved: ' . $validated['image_path']);
            } else {
                $validated['image_path'] = $card->image_path;
            }

            $card->update($validated);
            
            Log::info('Card updated successfully');
            
            return redirect()->route('cards.index')
                ->with('success', 'Машина успешно обновлена!');
                
        } catch (\Exception $e) {
            Log::error('Update error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Ошибка: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $card = Card::findOrFail($id);
            $card->delete();
            
            Log::info('Card soft deleted: ' . $id);
            
            return redirect()->route('cards.index')
                ->with('success', 'Машина перемещена в корзину!');
                
        } catch (\Exception $e) {
            Log::error('Destroy error: ' . $e->getMessage());
            return redirect()->route('cards.index')->with('error', 'Ошибка удаления');
        }
    }

    /**
     * Показать корзину с удалёнными карточками
     */
    public function trash()
    {
        try {
            $cards = Card::onlyTrashed()->get();
            return view('cards.trash', compact('cards'));
        } catch (\Exception $e) {
            Log::error('Trash error: ' . $e->getMessage());
            return redirect()->route('cards.index')->with('error', 'Ошибка загрузки корзины');
        }
    }

    /**
     * Восстановить карточку из корзины
     */
    public function restore($id)
    {
        try {
            Log::info('=== RESTORE ATTEMPT ===');
            Log::info('Card ID: ' . $id);
            
            $card = Card::onlyTrashed()->find($id);
            
            if (!$card) {
                Log::warning('Card not found in trash: ' . $id);
                return redirect()->route('cards.trash')
                    ->with('error', 'Карточка не найдена в корзине!');
            }
            
            $cardTitle = $card->title;
            Log::info('Found card: ' . $cardTitle);
            
            $card->restore();
            
            Log::info('Card restored successfully: ' . $cardTitle);
            
            // ВАЖНО: Редирект на главную страницу каталога
            return redirect()->route('cards.index')
                ->with('success', 'Автомобиль "' . $cardTitle . '" успешно восстановлен и возвращён в каталог!');
                
        } catch (\Exception $e) {
            Log::error('Restore error: ' . $e->getMessage());
            return redirect()->route('cards.trash')
                ->with('error', 'Ошибка восстановления: ' . $e->getMessage());
        }
    }

    /**
     * Полностью удалить карточку из корзины
     */
    public function forceDelete($id)
    {
        try {
            Log::info('=== FORCE DELETE ATTEMPT ===');
            Log::info('Card ID: ' . $id);
            
            $card = Card::onlyTrashed()->find($id);
            
            if (!$card) {
                Log::warning('Card not found in trash: ' . $id);
                return redirect()->route('cards.trash')
                    ->with('error', 'Карточка не найдена в корзине!');
            }
            
            $cardTitle = $card->title;
            
            if ($card->image_path && File::exists(public_path($card->image_path))) {
                File::delete(public_path($card->image_path));
                Log::info('Image permanently deleted: ' . $card->image_path);
            }
            
            $card->forceDelete();
            
            Log::info('Card force deleted successfully: ' . $cardTitle);
            
            return redirect()->route('cards.trash')
                ->with('success', 'Автомобиль "' . $cardTitle . '" полностью удалён!');
                
        } catch (\Exception $e) {
            Log::error('Force delete error: ' . $e->getMessage());
            return redirect()->route('cards.trash')
                ->with('error', 'Ошибка полного удаления: ' . $e->getMessage());
        }
    }
}