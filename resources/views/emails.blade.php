<x-layout>
    <h1>Email Form</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('warning'))
        <p style="color: orange;">{{ session('warning') }}</p>
    @endif

    @foreach($errors->all() as $error)
        <p style="color: red;">{{ $error }}</p>
    @endforeach

    <form action="/emails" method="POST">
        @csrf
        <input type="text" name="email" value="{{ old('email') }}" placeholder="Enter email">
        <button type="submit">Add Email</button>
    </form>

    <h2>Saved Emails</h2>

    <ul>
        @forelse($emails as $index => $email)
            <li>
                {{ $email }}
                <form action="/emails/delete/{{ $index }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Delete</button>
                </form>
            </li>
        @empty
            <p>No emails saved yet.</p>
        @endforelse
    </ul>
</x-layout>