# Manual Test: Rental Management

## Objective
Verify rental operations: start rental, view rentals, end rental, payment.

## Preconditions
- Staff is logged in
- Available computers and members exist

## Test Steps

### View Rentals
1. Navigate to /rental
2. Verify active and inactive rentals are listed
3. Check details: computer, member, start time, status

### Start Rental
1. Navigate to /rental/add
2. Select available PC
3. Search and select member (or leave empty for guest)
4. Submit form
5. Verify redirection to /rental
6. Check that rental appears in active list
7. Check that PC status changes to occupied

### End Rental and Payment
1. From active rentals, click payment for a rental
2. Verify payment calculation (hours * tariff)
3. Select payment method
4. Submit payment
5. Verify rental moves to inactive
6. Check that PC becomes available
7. Check payment record is created

## Expected Results
- Rentals start and end correctly
- Calculations are accurate
- Status updates work
- Data is persisted

## Edge Cases
- No available PCs: Should not allow start
- Invalid member: Should handle gracefully
- End time before start: Should handle
- Payment amount mismatch: Should use calculated amount