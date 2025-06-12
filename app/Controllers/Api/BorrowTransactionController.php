<?php

namespace App\Controllers\Api;

use App\Controllers\Api\BaseApiController;
use App\Models\BorrowTransactionModel;
use App\Models\BookModel;
use App\Models\MemberModel;

class BorrowTransactionController extends BaseApiController
{
    /**
     * @var BorrowTransactionModel
     */
    protected $model;
    protected $modelName = BorrowTransactionModel::class;
    protected $format    = 'json';
    protected $bookModel;
    protected $memberModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->memberModel = new MemberModel();
    }

    // Get api/borrows/
    public function index()
    {
        $borrows = $this->model->select('borrow_transactions.*, books.title as book_title, members.name as member_name')
            ->join('books', 'books.id = borrow_transactions.book_id')
            ->join('members', 'members.id = borrow_transactions.member_id')
            ->findAll();
        return $this->respondWithSuccess($borrows, 'Borrows retrieved successfully');
    }

    // Get api/borrows/id
    public function show($id = null)
    {
        $borrow = $this->model->find($id);
        if (!$borrow) {
            return $this->respondWithError('Borrow not found', 404);
        }
        return $this->respondWithSuccess($borrow, 'Borrow retrieved successfully');
    }

    // Post api/borrows/
    public function create()
    {
        $data = $this->request->getPost(); // karena dari form

        $book = $this->bookModel->find($data['book_id']);
        $member = $this->memberModel->find($data['member_id']);

        if (!$book) {
            return $this->respondWithError('Book not found', 404);
        }

        if (!$member) {
            return $this->respondWithError('Member not found', 404);
        }

        if ((int) $book->available_quantity < 1) {
            return $this->respondWithError('No available stock for this book', 400);
        }

        if ($this->model->insert($data)) {
            $this->bookModel->update($book->id, [
                'available_quantity' => $book->available_quantity - 1
            ]);

            return $this->respondWithSuccess($data, 'Borrow created successfully', 201);
        }

        return $this->respondWithError($this->model->errors());
    }

    // Put api/borrows/id
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        $oldBorrow = $this->model->find($id);
        if (!$oldBorrow) {
            return $this->respondWithError('Borrow record not found', 404);
        }

        $oldBookId = $oldBorrow['book_id'];
        $newBookId = $data['book_id'];

        if ($oldBookId != $newBookId) {
            $oldBook = $this->bookModel->find($oldBookId);
            $newBook = $this->bookModel->find($newBookId);

            if (!$newBook) {
                return $this->respondWithError('New book not found', 404);
            }

            if ($newBook->available_quantity < 1) {
                return $this->respondWithError('No available stock for the new book', 400);
            }

            $this->bookModel->update($oldBookId, [
                'available_quantity' => $oldBook->available_quantity + 1
            ]);

            $this->bookModel->update($newBookId, [
                'available_quantity' => $newBook->available_quantity - 1
            ]);
        }

        if ($this->model->update($id, $data)) {
            return $this->respondWithSuccess($data, 'Borrow updated successfully');
        }

        return $this->respondWithError($this->model->errors());
    }

    // Delete api/borrows/id
    public function delete($id = null)
    {
        $borrow = $this->model->find($id);
        if (!$borrow) {
            return $this->respondWithError('Borrow not found', 404);
        }

        $book = $this->bookModel->find($borrow->book_id);
        if ($book) {
            // 3. Tambahkan kembali stok buku
            $this->bookModel->update($book->id, [
                'available_quantity' => $book->available_quantity + 1
            ]);
        }

        log_message('error', 'Ini error-nya: ' . print_r($book, true));

        // 4. Hapus data peminjaman
        if ($this->model->delete($id)) {
            return $this->respondWithSuccess(null, 'Borrow deleted successfully');
        }

        return $this->respondWithError('Borrow could not be deleted', 500);
    }
}
