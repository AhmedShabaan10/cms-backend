    <form action="{{ route($route, $param) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-danger btn-sm delete-button"
            data-url="{{ route($route, $param) }}">Delete</button>
    </form>
