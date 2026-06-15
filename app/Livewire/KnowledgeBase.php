<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;
use App\Models\Step;
use App\Models\Department;
use App\Models\Product;
use App\Models\Priority;

class KnowledgeBase extends Component
{
    public $search = '';
    public $filterDept = '';
    public $filterProd = '';
    public $filterPriority = '';
    public $activeArticleId = null;

    public $editingId = null;

    // Modal
    public $showModal = false;
    public $modalTitle = '';
    public $form = [
        'title' => '',
        'description' => '',
        'department_id' => '',
        'product_id' => '',
        'priority_id' => '',
    ];
    public $steps = [
        ['text' => '', 'code' => '']
    ];

    public function selectArticle($id)
    {
        $this->activeArticleId = $id;
    }

    public function openCreateModal()
    {
        $this->reset('form', 'steps');
        $this->steps = [['text' => '', 'code' => '']];
        $this->modalTitle = 'New article';
        $this->showModal = true;
    }

    public function addStep()
    {
        $this->steps[] = ['text' => '', 'code' => ''];
    }

    public function removeStep($index)
    {
        array_splice($this->steps, $index, 1);
    }

    public function edit($id)
    {
        $article = Article::with('steps')->findOrFail($id);

        $this->editingId = $article->id;

        $this->form = [
            'title' => $article->title,
            'description' => $article->description,
            'department_id' => $article->department_id,
            'product_id' => $article->product_id,
            'priority_id' => $article->priority_id,
        ];

        $this->steps = $article->steps->map(function ($step) {
            return [
                'text' => $step->body,
                'code' => $step->code,
            ];
        })->toArray();

        $this->modalTitle = 'Edit article';
        $this->showModal = true;
    }

    public function delete($id)
    {
        $article = Article::findOrFail($id);

        $article->delete();

        $this->activeArticleId = null;
    }

    public function save()
    {
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.description' => 'nullable|string',
            'form.department_id' => 'required|exists:departments,id',
            'form.product_id' => 'required|exists:products,id',
            'form.priority_id' => 'required|exists:priorities,id',
            'steps.*.text' => 'required|string',
            'steps.*.code' => 'nullable|string',
        ]);

        /* $article = Article::create([
             'title' => $this->form['title'],
             'description' => $this->form['description'],
             'department_id' => $this->form['department_id'],
             'product_id' => $this->form['product_id'],
             'priority_id' => $this->form['priority_id'],
             'user_id' => auth()->id(),
         ]);*/

        if ($this->editingId) {

            $article = Article::findOrFail($this->editingId);

            $article->update([
                'title' => $this->form['title'],
                'description' => $this->form['description'],
                'department_id' => $this->form['department_id'],
                'product_id' => $this->form['product_id'],
                'priority_id' => $this->form['priority_id'],
            ]);

            $article->steps()->delete();

        } else {

            $article = Article::create([
                'title' => $this->form['title'],
                'description' => $this->form['description'],
                'department_id' => $this->form['department_id'],
                'product_id' => $this->form['product_id'],
                'priority_id' => $this->form['priority_id'],
                'user_id' => auth()->id(),
            ]);
        }

        foreach ($this->steps as $i => $step) {
            Step::create([
                'article_id' => $article->id,
                'body' => $step['text'],
                'code' => $step['code'] ?? null,
                'order' => $i,
            ]);
        }

        $this->showModal = false;
        $this->activeArticleId = $article->id;
        $this->editingId = null;
    }

    protected $listeners = ['searchUpdated'];


    public function searchUpdated($value)
    {
        $this->search = $value;
    }

    public function render()
    {
        $articles = Article::with(['department', 'product', 'priority', 'steps'])
            ->when($this->filterDept, fn($q) => $q->where('department_id', $this->filterDept))
            ->when($this->filterProd, fn($q) => $q->where('product_id', $this->filterProd))
            ->when($this->filterPriority, fn($q) => $q->where('priority_id', $this->filterPriority))
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->latest()
            ->get();

        $activeArticle = $this->activeArticleId
            ? $articles->firstWhere('id', $this->activeArticleId)
            : null;

        return view('livewire.knowledge-base', [
            'articles' => $articles,
            'activeArticle' => $activeArticle,
            'departments' => Department::all(),
            'products' => Product::all(),
            'priorities' => Priority::all(),
        ])->layout('layouts.app', ['title' => 'Knowledge Base']);
    }
}