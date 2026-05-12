# Manual Test: Staff Login

## Objective
Verify that staff can log in successfully with valid credentials and are redirected appropriately.

## Preconditions
- Application is running
- Database has at least one operator with known credentials (e.g., email: budi@example.com, password: budijuga)

## Test Steps
1. Navigate to the login page (/staff-login)
2. Enter valid email: budi@example.com
3. Enter valid password: budijuga
4. Click the login button
5. Verify redirection to /dashboard
6. Check that session has 'is_staff_logged_in' set to true
7. Check that session has 'staff_email' set to the entered email

## Expected Results
- User is redirected to dashboard
- Dashboard loads successfully
- User can access staff-only pages

## Edge Cases
- Invalid email: Should show error message
- Invalid password: Should show error message
- Empty fields: Should show validation errors
- SQL injection attempts: Should be sanitized