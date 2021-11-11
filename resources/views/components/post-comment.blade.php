@props(['comment'])

<x-panel class="bg-gray-50">
    <article class="flex space-x-4">
        <div class="flex-shrink-0">
            <img src="https://i.pravatar.cc/60?u={{ $comment->user_id }}" alt="" width="60" height="60" class="rounded-xl">
        </div>

        <div>
            <header class="mb-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold">{{ $comment->author->username }}</h3>

                    @if (Auth::check() AND $comment->canDelete(Auth::user()))
                        <form method="post" action="/comments/delete" enctype="multipart/form-data">
                            @csrf
                            <input name="id" type="hidden" value="{{ $comment->id }}">
                            <button type="submit">&#10006;</button>
                        </form>
                    @endif
                </div>


                <p class="text-xs">
                    Posted
                    <time>{{ $comment->created_at->format('F j, Y, g:i a') }}</time>
                </p>
            </header>

            <p>
                {{ $comment->body }}
            </p>
        </div>
    </article>
</x-panel>
