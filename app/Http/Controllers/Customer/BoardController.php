<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\BoardProduct;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BoardController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $data['pageTitle'] = __('Boards');
        $data['activeBoard'] = 'active';
        $data['boards'] = Board::withCount('boardProducts')->whereCustomerId(auth()->id())->get();

        return view('customer.boards.index', $data);
    }

    public function edit($id)
    {
        $data['board'] = Board::where(['customer_id' => auth()->id(), 'id' => $id])->first();
        return view('customer.boards.update-modal', $data);
    }

    public function view($id)
    {
        $data['pageTitle'] = __('Board Details');
        $data['activeBoard'] = 'active';
        $data['board'] = Board::where(['customer_id' => auth()->id(), 'id' => $id])->with('boardProducts.product')->first();
        return view('customer.boards.view', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        $board = Board::where('customer_id', auth()->id())->where('name', $request->name)->first();

        if ($board) {
            $response['message'] = 'This name already created.';
            return $this->error([], $response['message']);
        }

        $board = new Board();
        $board->name = $request->name;
        $board->slug = Str::slug($request->name);
        $board->save();

        $response['message'] = __('Created Successfully.');
        $response['board'] = Board::find($board->id);
        return $this->success($response['board'], $response['message']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        $board = Board::where('id', '!=', $id)->where('customer_id', auth()->id())->where('name', $request->name)->first();
        if ($board) {
            $response['message'] = 'This name already created.';
            return $this->error([], $response['message']);
        }

        $board = Board::find($id);
        if ($board) {
            $board->name = $request->name;
            $board->slug = Str::slug($request->name);
            $board->save();
            return $this->success([], __('Updated Successfully.'));
        }

        return $this->error([], 'Not Found.');

    }

    public function delete($id)
    {
        $board = Board::find($id);
        if ($board) {
            BoardProduct::where('board_id', $id)->delete();
            $board->delete();
            return $this->success([], 'Deleted Successfully.');
        }
        return $this->error([], 'Not Found.');
    }

    public function addBoardProduct(Request $request)
    {
        $validator = $request->validate([
            'board_id' => 'required',
            'product_id' => 'required',
        ]);

        $boardProductExits = BoardProduct::where('board_id', $request->board_id)->where('product_id', $request->product_id)->first();

        if ($boardProductExits) {
            return $this->error([], __('Already Found in this Board.'));
        }

        $boardProduct = new BoardProduct();
        $boardProduct->board_id = $request->board_id;
        $boardProduct->product_id = $request->product_id;
        $boardProduct->save();
        return $this->success([], __('Added to Board List.'));
    }

    public function deleteBoardProduct($id)
    {
        $boardProduct = BoardProduct::find($id);
        if ($boardProduct) {
            $boardProduct->delete();
            return $this->success([], __('Deleted from Board List.'));
        }
        return $this->error([], __('Product Not Found in Board List'));
    }
}
