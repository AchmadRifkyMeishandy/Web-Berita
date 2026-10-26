<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Csrf;
use App\Models\Comment;
use Throwable;

final class CommentController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $this->render('admin/comments/index', [
            'pageTitle' => 'Kelola Komentar',
            'comments' => Comment::allForAdmin(),
            'replies' => Comment::allRepliesForAdmin(),
            'successMessage' => flash('success'),
            'errorMessage' => flash('error'),
        ], 'admin');
    }

    public function delete(): void
    {
        $this->requireAdmin();
        Csrf::requireValidRequest();
        $commentId = $this->validId($_POST['comment_id'] ?? null);
        $replyId = $this->validId($_POST['reply_id'] ?? null);
        try {
            if ($commentId) {
                Comment::delete($commentId);
                flash('success', 'Komentar dan balasannya berhasil dihapus.');
            } elseif ($replyId) {
                Comment::deleteReply($replyId);
                flash('success', 'Balasan komentar berhasil dihapus.');
            } else {
                flash('error', 'ID komentar tidak valid.');
            }
        } catch (Throwable $exception) {
            error_log('Delete comment failed: ' . $exception->getMessage());
            flash('error', 'Komentar gagal dihapus.');
        }
        $this->redirect('admin.comments.index');
    }
}
