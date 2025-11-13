<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MakeAuthSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:auth-setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup authentication system for Madura Mart automatically';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('╔════════════════════════════════════════╗');
        $this->info('║   MADURA MART AUTH SETUP INSTALLER    ║');
        $this->info('╚════════════════════════════════════════╝');
        $this->newLine();

        // Step 1: Create auth folder
        $this->info('➜ Creating auth views folder...');
        $authPath = resource_path('views/auth');
        if (!File::exists($authPath)) {
            File::makeDirectory($authPath, 0755, true);
            $this->info('  ✓ Auth folder created');
        } else {
            $this->info('  ✓ Auth folder already exists');
        }

        // Step 2: Create AuthController
        $this->info('➜ Creating AuthController...');
        if ($this->createAuthController()) {
            $this->info('  ✓ AuthController created successfully');
        } else {
            $this->error('  ✗ Failed to create AuthController');
        }

        // Step 3: Update routes
        $this->info('➜ Updating routes...');
        if ($this->updateRoutes()) {
            $this->info('  ✓ Routes updated successfully');
        } else {
            $this->error('  ✗ Failed to update routes');
        }

        // Step 4: Clear cache
        $this->info('➜ Clearing cache...');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        $this->info('  ✓ Cache cleared');

        // Step 5: Run migrations
        if ($this->confirm('Do you want to run migrations?', true)) {
            $this->info('➜ Running migrations...');
            try {
                Artisan::call('migrate', ['--force' => true]);
                $this->info('  ✓ Migrations completed');
            } catch (\Exception $e) {
                $this->error('  ✗ Migration failed: ' . $e->getMessage());
            }
        }

        // Step 6: Create test user
        if ($this->confirm('Do you want to create a test user?', true)) {
            $this->createTestUser();
        }

        $this->newLine();
        $this->info('╔════════════════════════════════════════╗');
        $this->info('║         SETUP COMPLETE! ✓             ║');
        $this->info('╚════════════════════════════════════════╝');
        $this->newLine();

        $this->comment('Next steps:');
        $this->line('  1. Copy login.blade.php to resources/views/auth/');
        $this->line('  2. Copy register.blade.php to resources/views/auth/');
        $this->line('  3. Update dashboard/index.blade.php (add logout button)');
        $this->line('  4. Run: php artisan serve');
        $this->line('  5. Visit: http://localhost:8000/login');
        $this->newLine();

        return Command::SUCCESS;
    }

    /**
     * Create AuthController file
     */
    protected function createAuthController()
    {
        $controllerPath = app_path('Http/Controllers/AuthController.php');

        $stub = <<<'PHP'
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }
        return view('auth.login', ['title' => 'Login']);
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }
        return view('auth.register', ['title' => 'Register']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            Log::info('User logged in', ['user_id' => Auth::id(), 'email' => Auth::user()->email, 'ip' => $request->ip()]);
            return redirect()->intended(route('dashboard.index'))
                ->with('success', 'Login berhasil! Selamat datang ' . Auth::user()->name);
        }

        Log::warning('Failed login attempt', ['email' => $request->email, 'ip' => $request->ip()]);
        return back()->withErrors(['email' => 'Email atau password salah'])->withInput($request->only('email'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:employee,owner',
            'terms' => 'accepted',
        ], [
            'name.required' => 'Nama harus diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role.required' => 'Role harus dipilih',
            'role.in' => 'Role tidak valid',
            'terms.accepted' => 'Anda harus menyetujui Syarat & Ketentuan',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            Log::info('New user registered', ['user_id' => $user->id, 'email' => $user->email, 'role' => $user->role, 'ip' => $request->ip()]);
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('dashboard.index')
                ->with('success', 'Registrasi berhasil! Selamat datang ' . $user->name);
        } catch (\Exception $e) {
            Log::error('Registration failed', ['email' => $request->email, 'error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Log::info('User logged out', ['user_id' => Auth::id(), 'email' => Auth::user()->email, 'ip' => $request->ip()]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout');
    }
}
PHP;

        File::put($controllerPath, $stub);
        return true;
    }

    /**
     * Update routes file
     */
    protected function updateRoutes()
    {
        $routesPath = base_path('routes/web.php');

        $routesContent = <<<'PHP'
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome', ['title' => 'Welcome']);
})->name('home');

Route::get('/mizuki', function () {
    return view('mizuki', ['title' => 'Mizuki']);
})->name('mizuki');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest Only)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

/*
|--------------------------------------------------------------------------
| Protected Routes (Authenticated Users Only)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('test', TestController::class);
});
PHP;

        File::put($routesPath, $routesContent);
        return true;
    }

    /**
     * Create test user
     */
    protected function createTestUser()
    {
        $name = $this->ask('Enter test user name', 'Admin Test');
        $email = $this->ask('Enter test user email', 'admin@maduramart.com');
        $password = $this->secret('Enter test user password (default: password123)') ?: 'password123';
        $role = $this->choice('Select role', ['employee', 'owner'], 1);

        try {
            $user = \App\Models\User::create([
                'name' => $name,
                'email' => $email,
                'password' => \Illuminate\Support\Facades\Hash::make($password),
                'role' => $role,
            ]);

            $this->newLine();
            $this->info('✓ Test user created successfully!');
            $this->line("  Email: {$email}");
            $this->line("  Password: {$password}");
            $this->line("  Role: {$role}");
        } catch (\Exception $e) {
            $this->error('Failed to create test user: ' . $e->getMessage());
        }
    }
}
