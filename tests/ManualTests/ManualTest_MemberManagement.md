# Manual Test: Member Management

## Objective
Verify CRUD operations for members.

## Preconditions
- Staff is logged in

## Test Steps

### List Members
1. Navigate to /member
2. Verify list of all members is displayed
3. Check columns: ID, Name, Email, Phone, etc.

### Add Member
1. Navigate to /member/add
2. Fill in name, email, phone, address
3. Submit form
4. Verify redirection to /member
5. Check that new member appears in list

### Edit Member
1. From member list, click edit for a member
2. Modify details
3. Submit form
4. Verify changes are saved

### Delete Member
1. From member list, click delete for a member
2. Confirm deletion
3. Verify member is removed from list

## Expected Results
- All operations complete successfully
- Data is persisted correctly
- Validations work (valid email, required fields)

## Edge Cases
- Invalid email: Should show error
- Duplicate email: Should prevent
- Delete member with active rental: Should prevent or warn