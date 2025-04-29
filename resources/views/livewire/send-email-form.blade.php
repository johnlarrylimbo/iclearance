<div>
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="sendEmail">
        <div>
            <label>Name:</label>
            <input type="text" wire:model="name">
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Email:</label>
            <input type="email" wire:model="email">
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Message:</label>
            <textarea wire:model="message"></textarea>
            @error('message') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Send Email</button>
    </form>
</div>