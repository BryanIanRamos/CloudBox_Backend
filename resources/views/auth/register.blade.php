<x-layout>
    <div class="max-w-md mx-auto mt-10">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
            
            <form id="registerForm" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Name
                    </label>
                    <input 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="name" 
                        type="text" 
                        name="name"
                        placeholder="Enter your name"
                        value="{{ old('name') }}"
                        required
                    >
                    <p class="text-red-500 text-xs italic hidden" id="nameError"></p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="email" 
                        type="email" 
                        name="email"
                        placeholder="Enter your email"
                        value="{{old('email')}}"
                        required
                    >
                    <p class="text-red-500 text-xs italic hidden" id="emailError"></p>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="password" 
                        type="password" 
                        name="password"
                        placeholder="******************"
                        required
                    >
                    <p class="text-red-500 text-xs italic hidden" id="passwordError"></p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="confirmPassword">
                        Confirm Password
                    </label>
                    <input 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" 
                        id="confirmPassword" 
                        name="password_confirmation"
                        type="password" 
                        placeholder="******************"
                        required
                    >
                    <p class="text-red-500 text-xs italic hidden" id="confirmPasswordError"></p>
                </div>
                
                <div class="flex items-center justify-between">
                    <button 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                        type="submit"
                    >
                        Register
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('show.login') }}">
                        Already have an account?
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->any())
      <ul>
        @foreach ( $errors->all() as $error)
          <li>{{$error}}</li>
        @endforeach
      </ul>
      
    @endif

    {{-- <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            let isValid = true;
            
            // Validate name
            if (name.length < 2) {
                document.getElementById('nameError').textContent = 'Name must be at least 2 characters';
                document.getElementById('nameError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('nameError').classList.add('hidden');
            }
            
            // Validate email
            if (!email.includes('@')) {
                document.getElementById('emailError').textContent = 'Please enter a valid email';
                document.getElementById('emailError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('emailError').classList.add('hidden');
            }
            
            // Validate password
            if (password.length < 6) {
                document.getElementById('passwordError').textContent = 'Password must be at least 6 characters';
                document.getElementById('passwordError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('passwordError').classList.add('hidden');
            }
            
            // Validate password confirmation
            if (password !== confirmPassword) {
                document.getElementById('confirmPasswordError').textContent = 'Passwords do not match';
                document.getElementById('confirmPasswordError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('confirmPasswordError').classList.add('hidden');
            }
            
            if (isValid) {
                alert('Registration successful! Redirecting to dashboard...');
                window.location.href = '/dashboard';
            }
        });
    </script> --}}
</x-layout>