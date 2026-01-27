# Technical Recommendations - Keuzedeel Website

## Microsoft Azure AD Integration

### Feasibility Analysis
**Recommendation**: Implement Microsoft Azure AD OAuth 2.0 integration

#### Technical Requirements
```php
// Required packages
composer require laravel/socialite
composer require socialiteproviders/microsoft
```

#### Implementation Strategy
1. **OAuth 2.0 Flow**: Standard Microsoft authentication
2. **Role Mapping**: Extract roles from Azure AD groups
3. **Study Program Detection**: Use department/organizational unit attributes

#### Configuration Example
```php
// config/services.php
'microsoft' => [
    'client_id' => env('MICROSOFT_CLIENT_ID'),
    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
    'redirect' => env('MICROSOFT_REDIRECT_URI'),
    'tenant' => env('MICROSOFT_TENANT_ID'), // School-specific tenant
],
```

#### User Role Detection
```php
// After successful OAuth login
function mapUserRole($azureUser) {
    $userGroups = $azureUser->getGroups();
    
    if (in_array('Studenten', $userGroups)) {
        return 'student';
    } elseif (in_array('Administratie', $userGroups)) {
        return 'admin';
    } elseif (in_array('SLBers', $userGroups)) {
        return 'slber';
    }
    
    return 'student'; // Default role
}
```

## Architecture Recommendations

### 1. Frontend Framework
**Recommendation**: Laravel + Blade + Alpine.js + Tailwind CSS

#### Rationale
- **Laravel**: Already installed, robust backend
- **Blade**: Simple, server-side rendering
- **Alpine.js**: Lightweight interactivity without complexity
- **Tailwind CSS**: Rapid UI development

#### Alternative: React/Vue SPA
- More complex but better UX for interactive features
- Consider if real-time updates are critical

### 2. State Management
**Recommendation**: Server-side state with minimal client-side state

#### Critical State to Manage
- Current user authentication status
- Enrollment availability (real-time)
- Form validation states

### 3. Real-time Features
**Recommendation**: Laravel WebSockets for critical updates

#### Use Cases
- Live enrollment counts
- Waitlist position updates
- Admin notifications

```php
// Required packages
composer require beyondcode/laravel-websockets
npm install pusher-js
```

## Performance Optimization

### 1. Database Optimization
```php
// Recommended caching strategy
use Illuminate\Support\Facades\Cache;

function getAvailableSpots($keuzdeelId) {
    return Cache::remember(
        "keuzdeel_{$keuzdeelId}_spots",
        300, // 5 minutes
        function () use ($keuzdeelId) {
            $keuzdeel = Keuzdeel::find($keuzdeelId);
            $enrolled = Inscription::where('keuzdeel_id', $keuzdeelId)
                                 ->whereIn('status', ['pending', 'confirmed'])
                                 ->count();
            return $keuzdeel->max_participants - $enrolled;
        }
    );
}
```

### 2. Concurrency Control
```php
// Prevent race conditions during enrollment
DB::transaction(function () use ($userId, $keuzdeelId) {
    $keuzdeel = Keuzdeel::lockForUpdate()->find($keuzdeelId);
    $currentEnrollment = $keuzdeel->inscriptions()
                                 ->whereIn('status', ['pending', 'confirmed'])
                                 ->count();
    
    if ($currentEnrollment >= $keuzdeel->max_participants) {
        throw new Exception('Keuzedeel is vol');
    }
    
    // Proceed with enrollment
});
```

### 3. Queue System for Notifications
```php
// Required packages
composer require laravel/horizon

// Job for sending enrollment notifications
class SendEnrollmentConfirmation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public function handle()
    {
        // Send email/notification
    }
}
```

## Security Implementation

### 1. Authentication Security
```php
// Middleware for role-based access
class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (!$request->user() || $request->user()->role !== $role) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}

// Route protection
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard']);
});
```

### 2. Input Validation
```php
// Form Request validation
class StoreInscriptionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'keuzdeel_id' => [
                'required',
                'exists:keuzedelen,id',
                function ($attribute, $value, $fail) {
                    if (!$this->user()->canEnroll($value)) {
                        $fail('Inschrijving niet mogelijk voor dit keuzedeel.');
                    }
                }
            ],
        ];
    }
}
```

### 3. CSRF Protection
```php
// Already enabled by default in Laravel
// Ensure all forms include @csrf token
```

## Deployment Strategy

### 1. Environment Setup
```bash
# Production server requirements
- PHP 8.2+
- MySQL 8.0+ or PostgreSQL 13+
- Redis for caching and queues
- Nginx or Apache
- SSL Certificate (Let's Encrypt)
```

### 2. CI/CD Pipeline
```yaml
# .github/workflows/deploy.yml
name: Deploy
on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 8.2
      - name: Install dependencies
        run: composer install --no-dev
      - name: Run tests
        run: php artisan test
      - name: Deploy to production
        run: ./deploy.sh
```

### 3. Monitoring & Logging
```php
// Recommended packages
composer require laravel/telescope
composer require sentry/sentry-laravel

// Custom logging for critical events
Log::channel('enrollments')->info('Student enrolled', [
    'user_id' => $user->id,
    'keuzdeel_id' => $keuzdeel->id,
    'timestamp' => now()
]);
```

## Testing Strategy

### 1. Unit Tests
```php
// Example test for enrollment logic
class EnrollmentTest extends TestCase
{
    public function test_student_can_enroll_in_available_keuzdeel()
    {
        $student = User::factory()->student()->create();
        $keuzdeel = Keuzdeel::factory()->create(['max_participants' => 30]);
        
        $response = $this->actingAs($student)
                        ->post('/inscriptions', ['keuzdeel_id' => $keuzdeel->id]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('inscriptions', [
            'user_id' => $student->id,
            'keuzdeel_id' => $keuzdeel->id
        ]);
    }
}
```

### 2. Feature Tests
```php
// Test complete user flows
class UserFlowTest extends TestCase
{
    public function test_complete_enrollment_flow()
    {
        // Test login, browse, enroll, receive confirmation
    }
}
```

### 3. Browser Tests
```php
// Example with Laravel Dusk
class EnrollmentBrowserTest extends DuskTestCase
{
    public function test_student_can_enroll_via_browser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                   ->type('email', 'student@school.nl')
                   ->press('Inloggen')
                   ->waitForLocation('/dashboard')
                   ->clickLink('Keuzedelen')
                   ->click('@enroll-button')
                   ->waitForText('Inschrijving succesvol');
        });
    }
}
```

## Risk Mitigation

### 1. Technical Risks
| Risk | Impact | Probability | Mitigation |
|------|--------|-------------|------------|
| Azure AD integration fails | High | Medium | Manual user creation fallback |
| Performance issues during peak enrollment | High | High | Load testing, queue system |
| Data loss | Critical | Low | Daily backups, point-in-time recovery |

### 2. Business Risks
| Risk | Impact | Probability | Mitigation |
|------|--------|-------------|------------|
| User adoption low | Medium | Medium | User training, simple UI |
| Incorrect enrollment data | High | Low | Validation, audit trails |
| System downtime during enrollment | High | Medium | Redundancy, monitoring |

## Implementation Timeline

### Phase 1: Foundation (2 weeks)
- Set up Azure AD integration
- Create basic database schema
- Implement user authentication
- Basic role-based access

### Phase 2: Core Features (3 weeks)
- Keuzedeel management (CRUD)
- Student enrollment system
- Admin dashboard
- Capacity management

### Phase 3: Advanced Features (2 weeks)
- Waitlist system
- Notifications
- Reporting
- SLB presentation mode

### Phase 4: Testing & Polish (1 week)
- User acceptance testing
- Performance optimization
- Security audit
- Documentation

## Budget Considerations

### Development Costs
- Developer hours: ~160 hours (8 weeks @ 20 hours/week)
- Testing & QA: ~40 hours
- Project management: ~20 hours

### Infrastructure Costs (Monthly)
- Hosting: €50-100
- Database: €30-50
- Redis cache: €20-30
- Monitoring: €10-20
- SSL certificate: Free (Let's Encrypt)

### Third-party Services
- Azure AD: Free (school tenant)
- Email service: €10-30/month
- Backup storage: €10-20/month
