<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'category',
        'description',
        'details',
        'image_path',
        'fun_fact_content',
        'director',
        'release_year',
        'genre',
        'imdb_rating',
        'ceremony_date',
        'award_category',
    ];

    protected $casts = [
        'ceremony_date' => 'date',
        'release_year' => 'integer',
        'imdb_rating' => 'decimal:1',
    ];

    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? mb_ucfirst($value) : null,
            set: fn (?string $value) => $value ? trim($value) : null,
        );
    }

    protected function ceremonyDateFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->ceremony_date
                ? $this->ceremony_date->locale('ru')->isoFormat('D MMMM YYYY')
                : null,
        );
    }

    protected function imdbRatingDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->imdb_rating
                ? number_format($this->imdb_rating, 1) . '/10'
                : null,
        );
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image_path
                ? asset('storage/' . $this->image_path)
                : asset('images/placeholder.jpg'),
        );
    }

    public function isMovie(): bool
    {
        return $this->category === 'Фильмы';
    }

    public function isAward(): bool
    {
        return $this->category === 'Награды';
    }

    public function scopeMovies($query)
    {
        return $query->where('category', 'Фильмы');
    }

    public function scopeAwards($query)
    {
        return $query->where('category', 'Награды');
    }
}
