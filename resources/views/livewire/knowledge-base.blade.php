<div class="sb-kb-layout">

    {{-- ═══ LEFT PANEL ═══ --}}
    <div class="sb-kb-left">

        <div class="sb-kb-filters">
            <select wire:model.live="filterProd">
                <option value="">All products</option>
                @foreach($products as $prod)
                    <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                @endforeach
            </select>
            <select wire:model.live="filterDept">
                <option value="">All departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterPriority">
                <option value="">All priorities</option>
                @foreach($priorities as $priority)
                    <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="sb-articles-list">
            @forelse($articles as $article)
                <div class="sb-article-item {{ $activeArticleId == $article->id ? 'active' : '' }}"
                    wire:click="selectArticle({{ $article->id }})">
                    <div class="sb-article-name">{{ $article->title }}</div>
                    <div class="sb-article-tags">
                        <span class="sb-tag sb-tag-dept">{{ $article->department->name }}</span>
                        <span class="sb-tag sb-tag-prod">{{ $article->product->name }}</span>
                        <span class="sb-tag sb-tag-prior-{{ strtolower($article->priority->name) }}">
                            {{ $article->priority->name }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="sb-no-results">
                    <i class="ti ti-mood-empty"></i>
                    No articles found
                </div>
            @endforelse
        </div>

        <div class="sb-kb-footer">
            <button class="sb-btn-ghost" wire:click="openCreateModal">
                <i class="ti ti-plus"></i> New article
            </button>
        </div>

    </div>

    {{-- ═══ RIGHT PANEL ═══ --}}
    <div class="sb-kb-right">

        @if(!$activeArticleId || !$activeArticle)
            <div class="sb-kb-empty">
                <i class="ti ti-article"></i>
                <p>Select an article to view</p>
            </div>
        @else
            <div style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

                <div class="sb-detail-header">
                    <div class="sb-detail-title">{{ $activeArticle->title }}</div>
                    <div class="sb-detail-tags">
                        <span class="sb-tag sb-tag-dept">{{ $activeArticle->department->name }}</span>
                        <span class="sb-tag sb-tag-prod">{{ $activeArticle->product->name }}</span>
                        <span class="sb-tag sb-tag-prior-{{ strtolower($activeArticle->priority->name) }}">
                            {{ $activeArticle->priority->name }}
                        </span>
                    </div>
                    <div class="sb-detail-desc">{{ $activeArticle->description }}</div>
                </div>

                <div class="sb-detail-body">
                    <div class="sb-steps-heading">
                        <i class="ti ti-list-check"></i> Resolution steps
                    </div>
                    @foreach($activeArticle->steps as $i => $step)
                        <div class="sb-step">
                            <div class="sb-step-num">{{ $i + 1 }}</div>
                            <div class="sb-step-content">
                                <div class="sb-step-text">{{ $step->body }}</div>
                                @if($step->code)
                                    <div class="sb-step-code">{{ $step->code }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="sb-detail-actions">
                    {{-- ═══ MODAL ═══ <button class="sb-btn-outline"><i class="ti ti-edit"></i> Edit</button>--}}
                    <button class="sb-btn-outline" wire:click="edit({{ $activeArticle->id }})">
                        <i class="ti ti-edit"></i> Edit
                    </button>
                    <button class="sb-btn-danger" wire:click="delete({{ $activeArticle->id }})"
                        wire:confirm="Delete this article?">
                        <i class="ti ti-trash"></i> Delete
                    </button>
                </div>

            </div>
        @endif

    </div>

    {{-- ═══ MODAL ═══ --}}
    @if($showModal)
        <div class="sb-modal-overlay" wire:click.self="$set('showModal', false)">
            <div class="sb-modal">

                <div class="sb-modal-header">
                    <span>{{ $modalTitle }}</span>
                    <button wire:click="$set('showModal', false)"><i class="ti ti-x"></i></button>
                </div>

                <div class="sb-modal-body">

                    <div class="sb-form-group">
                        <label>Title</label>
                        <input type="text" wire:model="form.title" placeholder="Issue title..." />
                        @error('form.title') <div class="sb-alert-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="sb-form-group">
                        <label>Description</label>
                        <textarea wire:model="form.description" placeholder="Brief description..."></textarea>
                    </div>

                    <div class="sb-form-group">
                        <label>Department</label>
                        <select wire:model.live="form.department_id">
                            <option value="">Select department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('form.department_id') <div class="sb-alert-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="sb-form-group">
                        <label>Product</label>
                        <select wire:model="form.product_id">
                            <option value="">Select product</option>
                            @foreach($products as $prod)
                                <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                            @endforeach
                        </select>
                        @error('form.product_id') <div class="sb-alert-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="sb-form-group">
                        <label>Priority</label>
                        <select wire:model="form.priority_id">
                            <option value="">Select priority</option>
                            @foreach($priorities as $priority)
                                <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                            @endforeach
                        </select>
                        @error('form.priority_id') <div class="sb-alert-error">{{ $message }}</div> @enderror
                    </div>

                    {{-- Steps --}}
                    <div class="sb-form-group">
                        <label>Resolution steps</label>
                        <div class="sb-step-inputs">
                            @foreach($steps as $i => $step)
                                <div class="sb-step-input-row">
                                    <div style="flex:1; display:flex; flex-direction:column; gap:4px;">
                                        <textarea wire:model="steps.{{ $i }}.text"
                                            placeholder="Step {{ $i + 1 }}..."></textarea>
                                        <input type="text" wire:model="steps.{{ $i }}.code"
                                            placeholder="Code / command (optional)" class="sb-code-in" />
                                    </div>
                                    @if(count($steps) > 1)
                                        <button class="sb-step-remove" wire:click="removeStep({{ $i }})">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    @endif
                                </div>
                                @error('steps.' . $i . '.text') <div class="sb-alert-error">{{ $message }}</div> @enderror
                            @endforeach
                        </div>
                        <button class="sb-btn-ghost" wire:click="addStep">
                            <i class="ti ti-plus"></i> Add step
                        </button>
                    </div>

                </div>

                <div class="sb-modal-footer">
                    <button class="sb-btn-outline" wire:click="$set('showModal', false)">Cancel</button>
                    <button class="sb-btn-primary" wire:click="save">
                        <i class="ti ti-check"></i> Save article
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>