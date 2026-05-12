# Manual Test: Staff Management

## Objective
Verify CRUD operations for staff/operators (admin only).

## Preconditions
- Admin staff is logged in (role 0)

## Test Steps

### List Staff
1. Navigate to /staff
2. Verify list of all staff is displayed
3. Check columns: Username, Full Name, Email, Role, Status

### Add Staff
1. Navigate to /staff/add
2. Fill in username, password, full name, email, role
3. Submit form
4. Verify redirection to /staff
5. Check that new staff appears in list

### Edit Staff
1. From staff list, click edit for a staff
2. Modify details (optionally change password)
3. Submit form
4. Verify changes are saved

### Delete Staff
1. From staff list, click delete for a staff
2. Confirm deletion
3. Verify staff is removed from list

## Expected Results
- All operations complete successfully
- Passwords are hashed
- Validations work (unique username, valid email, min password length)

## Edge Cases
- Non-admin trying to access: Should redirect
- Duplicate username: Should prevent
- Delete self: Should prevent