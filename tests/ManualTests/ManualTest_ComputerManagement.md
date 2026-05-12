# Manual Test: Computer Management

## Objective
Verify CRUD operations for computers.

## Preconditions
- Staff is logged in

## Test Steps

### List Computers
1. Navigate to /computer
2. Verify list of all computers is displayed
3. Check columns: ID, Spec, Tariff, Status

### Add Computer
1. Navigate to /computer/add
2. Fill in spec (e.g., "Test PC")
3. Fill in tariff (e.g., 15000)
4. Set status (0 for available)
5. Submit form
6. Verify redirection to /computer
7. Check that new computer appears in list

### Edit Computer
1. From computer list, click edit for a computer
2. Modify spec or tariff
3. Submit form
4. Verify changes are saved and displayed

### View Details
1. From computer list, click detail for a computer
2. Verify detailed view shows all information

### Delete Computer
1. From computer list, click delete for a computer
2. Confirm deletion
3. Verify computer is removed from list

## Expected Results
- All operations complete successfully
- Data is persisted correctly
- Validations work (required fields, etc.)

## Edge Cases
- Invalid tariff (non-numeric): Should show error
- Empty spec: Should show error
- Delete computer in use: Should prevent or warn