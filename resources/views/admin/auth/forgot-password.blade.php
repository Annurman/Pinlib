<!-- forgot-password.blade.php -->
<x-guest-layout>
    <h1>Lupa Password Admin</h1>

    @if (session('status'))
        <div class="text-green-500">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.password.email') }}">
        @csrf
        <input type="email" name="email" placeholder="Email admin" required>
        <button type="submit">Kirim Link Reset</button>
    </form>
</x-guest-layout>
