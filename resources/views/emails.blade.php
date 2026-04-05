<x-layout>
    <h1>Email Form</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('warning'))
        <p style="color: orange;">{{ session('warning') }}</p>
    @endif

    @if($errors->any())
        <ul style="color: red;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/emails" method="POST">
        @csrf
        <input type="text" name="email" value="{{ old('email') }}" placeholder="Enter email">
        <button type="submit">Add Email</button>
    </form>

    <h2>Saved Emails</h2>

    @if(count($emails) > 0)
        <ul>
            @foreach($emails as $index => $email)
                <li>
                    {{ $email }}
                    <form action="/emails/delete/{{ $index }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>No emails saved yet.</p>
    @endif
</x-layout>