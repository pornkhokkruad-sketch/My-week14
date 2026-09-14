<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['manage', 'create', 'store', 'edit', 'update', 'delete', 'changeStatus']);
    }

    // หน้า public — เฉพาะบทความที่เผยแพร่แล้ว
    public function index()
    {
        $blogs = Blog::where('status', true)->latest()->paginate(10);
        return view('blog', compact('blogs'));
    }

    public function detail(int $id)
    {
        $blog = Blog::where('status', true)->findOrFail($id);

        return view('detail', compact('blog'));
    }

    // หน้าจัดการ (ต้อง login) — ทุกสถานะ
    public function manage()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('blog2', compact('blogs'));
    }

    public function create()
    {
        return view('form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:150',
            'content' => 'required|string|min:10',
        ], [
            'title.required'   => 'กรุณากรอกชื่อบทความ',
            'content.required' => 'กรุณากรอกเนื้อหา',
            'content.min'      => 'เนื้อหาต้องมีอย่างน้อย 10 ตัวอักษร',
        ]);

        Blog::create([
            'title'   => $validated['title'],
            'content' => $validated['content'],
            'status'  => false,
        ]);

        return redirect()->route('author.blog.manage')->with('success', 'บันทึกบทความเรียบร้อยแล้ว');
    }

    public function edit(int $id)
    {
        $blog = Blog::findOrFail($id);
        return view('edit', compact('blog'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'title'   => 'required|max:150',
            'content' => 'required',
        ], [
            'title.required'   => 'กรุณาใส่ชื่อบทความ',
            'title.max'        => 'ชื่อบทความต้องไม่เกิน 150 ตัวอักษร',
            'content.required' => 'กรุณาใส่เนื้อหา',
        ]);

        $blog = Blog::findOrFail($id);
        $blog->update([
            'title'   => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('author.blog.manage')->with('success', 'แก้ไขบทความเรียบร้อยแล้ว');
    }

    public function delete(int $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->back()->with('success', 'ลบบทความเรียบร้อยแล้ว');
    }

    public function changeStatus(int $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->status = !$blog->status;
        $blog->save();

        return redirect()->back()->with('success', 'เปลี่ยนสถานะบทความเรียบร้อยแล้ว');
    }
}