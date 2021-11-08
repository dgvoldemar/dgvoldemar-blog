<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\Request;
use LogicException;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService)
    {}

    public function delete(Request $request)
    {
        request()->validate([
            'id' => 'required|integer'
        ]);

        try {
            $this->commentService->delete($request->input('id'));
        }catch (LogicException $e){
            return back()->withErrors(['errors' => 'Only admin and owner (within one hour) can delete comment.']);
        }
        catch (\Throwable $e) {
            return back()->withErrors(['errors' => 'Something goes wrong.']);
        }
        return back()->with('success', 'Comment deleted');
    }
}
