<?php

namespace App\Http\Repository;

use App\Models\Book;

class BookRepository
{
   protected $model;

    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    public function getAll($query = null, $perPage = 5)
    {
        $booksQuery = $this->model->with('classType');

        if ($query) {
            $booksQuery->where('name', 'like', '%' . $query . '%')
                       ->orWhere('category', 'like', '%' . $query . '%')
                       ->orWhereHas('classType', function ($q) use ($query) {
                           $q->where('name', 'like', '%' . $query . '%');
                       });
        }

        return $booksQuery->orderBy('id', 'desc')->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        try {
            $book = $this->model->findOrFail($id);
            $book->update($data);
            return $book;
        } catch (\Exception $e) {
            // Handle the exception as needed
            throw new \Exception("Book not found or update failed.");
        }
    }
}