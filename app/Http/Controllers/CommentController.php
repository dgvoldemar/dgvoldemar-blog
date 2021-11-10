<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use App\Services\ServiceExceptions\CommentCantDeleteException;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService)
    {
    }

    public function delete(Request $request)
    {
        request()->validate([
            'id' => 'required|integer'
        ]);

        try {
            $this->commentService->delete($request->input('id'));
        } catch (CommentCantDeleteException $e) {
            return back()->withErrors(['errors' => $e->getMessage()]);
        } catch (\Throwable $e) {
            return back()->withErrors(['errors' => 'Something goes wrong.']);
        }
        return back()->with('success', 'Comment deleted');
    }
}
