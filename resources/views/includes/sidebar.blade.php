                <div class="my-4">Catégories</div>
                    <div class="list-group">
@foreach(App\Models\Category::has('articles')->get() as $category)
                        <a href="{{ route('category.show', ['category' => $category->slug]) }}" class="list-group-item {{ Request::is('category/'.$category->slug) ? 'active' : '' }}">{{ $category->name }}</a>
@endforeach
                    </div>
